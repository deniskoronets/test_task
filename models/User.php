<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package app\models
 *
 * @property int $id
 * @property string $email
 * @property string $password_hash
 * @property string $avatar_path
 * @property string $avatar_thumbnail_path
 * @property string $created_at
 * @property string $updated_at
 *
 * @property string $avatarUrl
 * @property string $avatarThumbnailUrl
 */
class User extends BaseActiveRecord implements \yii\web\IdentityInterface
{
    use \damirka\JWT\UserTrait;

    const AVATAR_PATH = '@webroot/avatars/';
    const AVATAR_URL = '@web/avatars/';

    const AVATAR_SIZE = 600;
    const AVATAR_THUMBNAIL_SIZE = 62;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password_hash', 'avatar_path', 'avatar_thumbnail_path', 'created_at'], 'required'],
            [['email', 'password_hash', 'avatar_path', 'avatar_thumbnail_path'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            ['email', 'unique'],
        ];
    }

    /**
     * @return string
     */
    public static function tableName() : string
    {
        return 'users';
    }

    /**
     * @return string
     */
    protected static function getSecretKey() : string
    {
        return \Yii::$app->params['jwtSecret'];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string|void
     * @throws NotSupportedException
     */
    public function getAuthKey()
    {
        throw new NotSupportedException('Web login disabled');
    }

    /**
     * @param string $authKey
     * @return bool|void
     * @throws NotSupportedException
     */
    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException('Web login disabled');
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) : bool
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return string
     */
    public function getAvatarUrl() : string
    {
        return Url::to(self::AVATAR_URL . $this->avatar_path, true);
    }

    /**
     * @return string
     */
    public function getAvatarThumbnailUrl() : string
    {
        return Url::to(self::AVATAR_URL . $this->avatar_thumbnail_path, true);
    }
}
