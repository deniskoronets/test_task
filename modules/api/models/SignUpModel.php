<?php

namespace app\modules\api\models;

use app\models\User;
use Gumlet\ImageResize;
use yii\base\Model;
use yii\web\UploadedFile;

class SignUpModel extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var UploadedFile
     */
    public $avatar;

    public function rules()
    {
        return [
            [['email', 'password', 'avatar'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email'],
            ['password', 'string', 'min' => 6],
            ['avatar', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024],
        ];
    }

    /**
     * @return string
     * @throws \Gumlet\ImageResizeException
     */
    private function uploadAvatar(int $size) : string
    {
        $image = new ImageResize($this->avatar->tempName);
        $image->resizeToBestFit($size, $size);

        do {
            $fileName = uniqid() . '.jpg';
        } while (file_exists(\Yii::getAlias(User::AVATAR_PATH . $fileName)));

        $image->save($fileName);

        return $fileName;
    }

    /**
     * @return bool|array
     * @throws \yii\base\Exception
     * @throws \Throwable
     */
    public function signUp()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->setPassword($this->password);

        $user->setAttributes([
            'email' => $this->email,
            'avatar_path' => $this->uploadAvatar(User::AVATAR_SIZE),
            'avatar_thumbnail_path' => $this->uploadAvatar(User::AVATAR_THUMBNAIL_SIZE),
        ]);

        $user->created_at = now();
        $user->saveOrFail();

        return [
            'avatar' => $user->avatarUrl,
            'jwtToken' => $user->getJWT(),
        ];
    }

}