<?php
namespace app\controllers;

use Imagine\Image\Box;
use Imagine\Image\Point;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use app\components\Controller;
use yii\filters\VerbFilter;
use app\components\PseudoCrypt;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\models\AuthUsers;
use app\models\Users;
use app\models\Images;
use app\models\LoginForm;
use app\models\RegistrationForm;
use app\models\ContactForm;
use yii\imagine\Image;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
//            'captcha' => [
//                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function actionIndex()
    {
        $imagine = Image::getImagine();

        $model = new Images;
        $model->status = 1;
        $model->watermark = 1;

        $data = [
            'today' => Images::find()->where('created >= '.(time()-60*60*24))->count(),
            'week' => Images::find()->where('created >= '.(time()-60*60*24*7))->count(),
            'mounth' => Images::find()->where('created >= '.(time()-60*60*24*30))->count(),
            'all' => Images::find()->count(),
        ];

        $rotate = [
            0 => 'не поворачивать',
            90 => '90 град. по час. стрелке',
            270 => '90 град. против час. стрелки',
            180 => '180 град.'
        ];

        $flip = [
            'не отражать',
            'отразить по горизонтали',
            'отразить по вертикали'
        ];

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();
            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false) {
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                    $uploadImage = $imagine->open($path);
                    if (Yii::$app->user->isGuest) {
                        if ($uploadImage->getSize()->getWidth() >= 155 && $uploadImage->getSize()->getHeight() >= 27) {
                            $watermark = $imagine->open(Yii::getAlias('@app/media/img/watermark.png'));
                            $bottomRight = [$uploadImage->getSize()->getWidth() - $watermark->getSize()->getWidth(), $uploadImage->getSize()->getHeight() - $watermark->getSize()->getHeight()];
                            $uploadImage->paste($watermark, new Point($bottomRight[0], $bottomRight[1]));
                        }
                    }
                    else {
                        if ($model->size) {
                            $uploadImage->resize(new Box($model->size_height, $model->size_width));
                        }
                        if ($model->rotate) {
                            $uploadImage->rotate($model->rotate_value);
                        }
                        if ($model->negattive) {
                            $uploadImage->effects()->negative();
                        }
                        if ($model->grayscale) {
                            $uploadImage->effects()->grayscale();
                        }
                        if ($model->flip && $model->flip_value > 0) {
                            if ($model->flip_value == 1)
                                $uploadImage->flipHorizontally();
                            elseif ($model->flip_value == 2)
                                $uploadImage->flipVertically();
                        }
                        if ($model->watermark && $uploadImage->getSize()->getWidth() >= 155 && $uploadImage->getSize()->getHeight() >= 27) {
                            $watermark = $imagine->open(Yii::getAlias('@app/media/img/watermark.png'));
                            $bottomRight = [$uploadImage->getSize()->getWidth() - $watermark->getSize()->getWidth(), $uploadImage->getSize()->getHeight() - $watermark->getSize()->getHeight()];
                            $uploadImage->paste($watermark, new Point($bottomRight[0], $bottomRight[1]));
                        }
                    }
                    $uploadImage->save($path);
                }
                return $this->redirect(['share', 'link' => PseudoCrypt::hash($model->id, 6)]);
            } else {
                // error in saving model
            }
        }
        return $this->render('index', compact('model', 'data', 'rotate', 'flip'));
    }

    public function actionInformation()
    {
        return $this->render('information');
    }

    public function actionGallery() {
        $data = new ActiveDataProvider([
            'query' => Images::find()->where(['status' => 1])->orderBy('created DESC'),
            'pagination' => [
                'pageSize' => 9,
                'pageSizeParam' => false
            ],
        ]);

        return $this->render('gallery', [
            'data' => $data,
        ]);
    }

    public function actionMyImages() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(['gallery']);
        }

        $data = new ActiveDataProvider([
            'query' => Images::find()->where(['id_user' => Yii::$app->user->id])->orderBy('created DESC'),
            'pagination' => [
                'pageSize' => 9,
                'pageSizeParam' => false
            ],
        ]);

        return $this->render('my-images', [
            'data' => $data,
        ]);
    }

    public function actionShare($link)
    {
        $id = PseudoCrypt::unhash($link);
        $model = $this->findModel($id);

        return $this->render('share', [
            'model' => $model,
            'link' => $link
        ]);
    }

    public function actionImage($link)
    {
        $id = PseudoCrypt::unhash($link);
        $model = $this->findModel($id);

        if (!isset(Yii::$app->request->cookies['image_view_' . $link])) {
            $model->updateCounters(['views' => 1]);
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'image_view_' . $link,
                'value' => $link,
                'expire' => time() + 60 * 60 * 24
            ]));
        }

        return $this->render('view', [
            'model' => $model,
            'link' => $link
        ]);
    }

    public function actionImageEdit($link)
    {
        $id = PseudoCrypt::unhash($link);
        $model = $this->findModel($id);
        $model->setScenario('update');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['output'=>$model->name, 'message'=>''];
        }

        return $this->render('edit', [
            'model' => $model,
            'link' => $link
        ]);
    }

    public function actionImageDelete($link)
    {
        $id = PseudoCrypt::unhash($link);
        $model = $this->findModel($id);

        // validate deletion and on failure process any exception
        // e.g. display an error message
        if ($model->delete()) {
            if (!$model->deleteImage()) {
                Yii::$app->session->setFlash('error', 'Error deleting image');
            }
        }
        return $this->redirect(['my-images']);
    }

    public function actionLike($link)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = PseudoCrypt::unhash($link);
        $model = $this->findModel($id);

        if (!isset(Yii::$app->request->cookies['image_like_'.$link])) {
            $model->updateCounters(['likes' => 1]);
            $likes = $model->likes++;
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'image_like_'.$link,
                'value' => $link,
                'expire' => time() + 60 * 60 * 24
            ]));
            $result = [
                'result' => 'success',
                'action' => 'like',
                'likes' => $likes
            ];
        }
        else {
            Yii::$app->response->cookies->remove('image_like_'.$link);
            $model->updateCounters(['likes' => '-1']);
            $likes = $model->likes--;
            $result = [
                'result' => 'success',
                'action' => 'dislike',
                'likes' => $likes
            ];
        }
        return $result;
    }

    public function actionContacts() {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->flash('info', 'Сообщение отправлено!');
            $message = 'Текст: <br />'.$model->name.'<br />Контакты пользователя: <br />
                                   Логин: '.$model->name.'<br />
                                   Email: '.$model->email.'<br />
                                   IP: '.Yii::$app->request->userIP.'<br />
								   User-Agent: '.Yii::$app->request->userAgent.'<br />';
            Yii::$app->mailer->compose('layouts/html', ['content' => $message])
                ->setFrom(Yii::$app->params['email'])
                ->setTo('yaroslav.molchan@gmail.com')
                ->setSubject('WAPICS - '.$model->subject)
                ->send();
            return $this->goHome();
        }
        else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionRegistration() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        } else if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new Users([
                'username' => $model->username,
                'email' => isset($model->email) ? $model->email : null,
                'password' => $model->password,
            ]);
            $user->generateAuthKey();
            $user->generatePasswordResetToken();
            $transaction = $user->getDb()->beginTransaction();
            if ($user->save()) {
                $transaction->commit();
                Yii::$app->user->login($user);
            }
            return $this->goBack();
        } else {
            return $this->renderAjax('registration', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function onAuthSuccess($client) {
        $attributes = $client->getUserAttributes();

        /** @var Auth $auth */
        $auth = AuthUsers::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();
        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = $auth->user;
                Yii::$app->user->login($user);
            } else { // signup
                if (isset($attributes['email']) && Users::find()->where(['email' => $attributes['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);

                    if ($client->getId() =='twitter') {
                        $username = $attributes['name'];
                    }
                    else {
                        $username = isset($attributes['login']) ? $attributes['login'] : null;
                    }
//                    $username = isset($attributes['login']) ? $attributes['login'] : null;
                    $user = new Users([
                        'username' => $username,
                        'email' => isset($attributes['email']) ? $attributes['email'] : null,
                        'password' => $password,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();
                    $transaction = $user->getDb()->beginTransaction();
                    if ($user->save()) {
                        $auth = new AuthUsers([
                            'id_user' => $user->id_user,
                            'source' => $client->getId(),
                            'source_id' => (string) $attributes['id'],
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user);
                        } else {
                            print_r($auth->getErrors());
                        }
                    } else {
                        print_r($user->getErrors());
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new AuthUsers([
                    'id_user' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }

    /**
     * Finds the Images model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Images the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Images::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
