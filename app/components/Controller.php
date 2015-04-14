<?php

namespace app\components;

use Yii;
use app\models;

class Controller extends \yii\web\Controller {

//    public $enableCsrfValidation = false;
//    public $layout = '@easyii/views/layouts/main';
    public $pageTitle = null;
    public $pageDescription = null;
    public $pageInfo = null;

    public $rootActions = [];
    public $error = null;

    public function beforeAction($action) {
        if (!parent::beforeAction($action))
            return false;
        else
            return true;
    }

    public function flash($type, $message) {
        Yii::$app->getSession()->setFlash($type == 'error' ? 'danger' : $type, $message);
    }

    public function back() {
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function formatResponse($success = '', $back = true) {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($this->error) {
                return ['result' => 'error', 'error' => $this->error];
            } else {
                $response = ['result' => 'success'];
                if ($success) {
                    if (is_array($success)) {
                        $response = array_merge(['result' => 'success'], $success);
                    } else {
                        $response = array_merge(['result' => 'success'], ['message' => $success]);
                    }
                }
                return $response;
            }
        } else {
            if ($this->error) {
                $this->flash('error', $this->error);
            } else {
                if (is_array($success) && isset($success['message'])) {
                    $this->flash('success', $success['message']);
                } elseif (is_string($success)) {
                    $this->flash('success', $success);
                }
            }
            return $back ? $this->back() : $this->refresh();
        }
    }

}
