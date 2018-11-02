<?php

namespace app\modules\api\controllers;

use app\modules\api\models\EmailGithubUsersModel;

class GithubController extends ApiController
{
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