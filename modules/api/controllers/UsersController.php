<?php

namespace app\modules\api\controllers;

use app\modules\api\models\SignInModel;
use app\modules\api\models\SignUpModel;
use yii\web\UploadedFile;

class UsersController extends ApiController
{
    /**
     * Remove JWT token validation
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'sign-up'  => ['POST'],
                    'sign-in'  => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\base\Exception
     * @throws \Throwable
     */
    public function actionSignUp()
    {
        $model = new SignUpModel();
        $model->setAttributes(\Yii::$app->request->post());
        $model->avatar = UploadedFile::getInstanceByName('avatar');

        if (!$model->validate()) {
            return $this->validationErrors($model);
        }

        return $this->success($model->signUp());
    }

    /**
     * @return \yii\web\Response
     */
    public function actionSignIn()
    {
        $model = new SignInModel();
        $model->setAttributes(\Yii::$app->request->post());

        if (!$model->validate()) {
            return $this->validationErrors($model);
        }

        return $this->success($model->signIn());
    }

}