<?php

namespace app\exceptions;

use Throwable;
use yii\base\Exception;

/**
 * This exception means that wrapper model passed validation, but internal AR model failed on save
 * Class BaseModelSaveException
 * @package app\exceptions
 */
class BaseModelSaveException extends Exception
{
    public $errors = [];

    public function __construct(string $message = "", array $errors, int $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }
}