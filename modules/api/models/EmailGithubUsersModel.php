<?php

namespace app\modules\api\models;

use yii\base\Model;

class EmailGithubUsersModel extends Model
{
    /**
     * @var string
     */
    public $usernames;

    /**
     * @var string
     */
    public $message;


    /**
     * @return array
     */
    public function rules() : array
    {
        return [
            ['usernames', 'each', 'rule' => ['string', 'min' => 2, 'max' => 32]],
        ];
    }

    public function process()
    {
        if (!$this->validate()) {
            return false;
        }
    }


}