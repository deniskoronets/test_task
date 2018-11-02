<?php

namespace app\modules\api\models;

use app\modules\api\traits\ExternalApiHelper;
use Github\Client;
use Github\Exception\RuntimeException;
use yii\base\InvalidConfigException;
use yii\base\Model;

class EmailGithubUsersModel extends Model
{
    use ExternalApiHelper;

    /**
     * @var array
     */
    public $usernames;

    /**
     * @var string
     */
    public $message;

    /**
     * @var array
     */
    private $_foundGithubUsers;

    /**
     * EmailGithubUsersModel constructor.
     * @param array $config
     * @throws InvalidConfigException
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->initApiHelper();
    }


    /**
     * @return array
     */
    public function rules() : array
    {
        return [
            [['usernames', 'message'], 'required'],
            ['message', 'string', 'max' => 10000],
            ['usernames', 'each', 'rule' => ['string', 'min' => 2, 'max' => 32]],
        ];
    }

    /**
     * Validates if users exists on github
     */
    public function afterValidate()
    {
        parent::afterValidate();

        foreach ($this->usernames as $username) {
            $user = $this->githubUserInfo($username);

            if (!$user) {
                $this->addError('usernames', 'User ' . $username . ' do not exists');
                continue;
            }

            if (!$user['email']) {
                $this->addError('usernames', 'User ' . $username . ' has no email');
                continue;
            }

            $this->_foundGithubUsers[] = [
                'email' => $user['email'],
                'location' => $user['location'],
            ];
        }
    }

    /**
     * Processes request
     * @return array
     */
    public function process() : array
    {
        $result = [];

        foreach ($this->_foundGithubUsers as $user) {

            $text = $this->message . PHP_EOL . PHP_EOL .
                'Weather at ' . $user['location'] . ' is: ' . $this->weather($user['location']);

            $sent = $this->sendEmail(
                $user['email'],
                $text
            );

            $result[] = [
                'email' => $user['email'],
                'text' => $text,
                'sent' => $sent,
            ];
        }

        return $result;
    }

    /**
     * @param string $email
     * @param string $text
     * @return bool
     */
    private function sendEmail(string $email, string $text) : bool
    {
        return sendMail()->setTo($email)->setTextBody($text)->send();
    }
}