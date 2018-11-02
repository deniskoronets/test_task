<?php

namespace app\modules\api\controllers;

use app\modules\api\traits\ApiResponse;
use yii\base\Model;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Controller;

/**
 * Class ApiController
 * @package app\modules\api\controllers
 */
abstract class ApiController extends Controller
{
    use ApiResponse;

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'bearerAuth' => [
                'class' => HttpBearerAuth::class,
            ],
        ]);
    }

    /**
     * Sends error response with validation errors
     * @param Model $model
     * @return \yii\web\Response
     */
    public function validationErrors(Model $model)
    {
        return $this->error(422, 'validation', 'Request validation has failed', [
            'errors' => $model->getErrors(),
        ]);
    }

    /**
     * Handles errors and formats response
     * @param string $id
     * @param array $params
     * @return mixed|\yii\web\Response
     */
    public function runAction($id, $params = [])
    {
        return $this->handleErrors(function() use ($id, $params) {
            return parent::runAction($id, $params);
        });
    }
}
