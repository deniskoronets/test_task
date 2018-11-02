<?php

namespace app\models;

use app\exceptions\BaseModelSaveException;
use yii\db\ActiveRecord;

/**
 * Should be used for all AR models. Avoid AR direct usage in User -> API requests, always use wrapper-model
 * Class BaseActiveRecord
 * @package app\models
 */
class BaseActiveRecord extends ActiveRecord
{
    /**
     * @throws BaseModelSaveException
     */
    public function saveOrFail()
    {
        if (!$this->save()) {
            throw new BaseModelSaveException(
                'Unable to save base model ' . get_called_class(), $this->getErrors()
            );
        }
    }
}