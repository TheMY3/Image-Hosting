<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Images;
use app\components\PseudoCrypt;

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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new Images;

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();
            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false) {
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                return $this->redirect(['share', 'link' => PseudoCrypt::hash($model->id, 6)]);
            } else {
                // error in saving model
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Images model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Images;

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();

            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false) {
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                return $this->redirect(['image', 'link' => $model->id]);
            } else {
                // error in saving model
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Images model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldFile = $model->getImageFile();
        $oldImage = $model->image;
        $oldFileName = $model->filename;

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();

            // revert back if no valid file instance uploaded
            if ($image === false) {
                $model->image = $oldImage;
                $model->filename = $oldFileName;
            }

            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false && unlink($oldFile)) { // delete old and overwrite
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                return $this->redirect(['image', 'link' => $model->id]);
            } else {
                // error in saving model
            }
        }
        return $this->render('update', [
            'model' => $model,
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

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Images model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // validate deletion and on failure process any exception
        // e.g. display an error message
        if ($model->delete()) {
            if (!$model->deleteImage()) {
                Yii::$app->session->setFlash('error', 'Error deleting image');
            }
        }
        return $this->redirect(['index']);
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
