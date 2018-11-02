<?php

namespace app\modules\api\controllers;

use app\modules\api\traits\ApiResponse;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    use ApiResponse;

    /**
     * Handles api errors
     * @return mixed|\yii\web\Response
     */
    public function actionError()
    {
        return $this->handleErrors(function() {
            if (($exception = \Yii::$app->getErrorHandler()->exception) === null) {
                $exception = new NotFoundHttpException('Page not found.');
            }

            throw $exception;
        });
    }

    /**
     * Shows api documentation
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'documentation' => require __DIR__ . '/../documentation.php',
        ]);
    }
}