<?php

namespace app\modules\api\models;

use app\models\User;
use yii\base\Model;

class SignInModel extends Model
{
    /**
     * @var User|null
     */
    private $_user;

    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Allows to sign in user
     * @return array|bool
     */
    public function signIn()
    {
        if (!$this->validate()) {
            return false;
        }

        return [
            'user' => array_merge(
                $this->_user->toArray(['id', 'email', 'created_at', 'updated_at']),
                [
                    'avatarUrl' => $this->_user->avatarUrl,
                    'avatarThumbnailUrl' => $this->_user->avatarThumbnailUrl,
                ]
            ),
            'jwtToken' => $this->_user->getJWT(),
        ];
    }

    /**
     * Finds user by email
     *
     * @return User|null
     */
    public function getUser()
    {
        if (empty($this->_user)) {
            $this->_user = User::find()->where(['email' => $this->email])->one();
        }

        return $this->_user;
    }
}