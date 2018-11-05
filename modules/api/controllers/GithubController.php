<?php

namespace app\modules\api\controllers;

use app\modules\api\models\EmailGithubUsersModel;

class GithubController extends ApiController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), [
                'verbs' => [
                    'class' => \yii\filters\VerbFilter::class,
                    'actions' => [
                        'email-users'  => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionEmailUsers()
    {
        $model = new EmailGithubUsersModel();
        $model->setAttributes(\Yii::$app->request->post());

        if (!$model->validate()) {
            return $this->validationErrors($model);
        }

        return $this->success($model->process());
    }
}