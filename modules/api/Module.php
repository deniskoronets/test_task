<?php

namespace app\modules\api;
use app\modules\api\traits\ApiResponse;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    use ApiResponse;

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        \Yii::$app->errorHandler->errorAction = 'api/default/error';
    }
}
