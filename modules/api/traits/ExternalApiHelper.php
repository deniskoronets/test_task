<?php

namespace app\modules\api\traits;

use Cmfcmf\OpenWeatherMap;
use Github\Client;
use Github\Exception\RuntimeException;
use yii\base\InvalidConfigException;

trait ExternalApiHelper
{
    /**
     * @var \Github\Client
     */
    private $githubClient;

    /**
     * @var OpenWeatherMap
     */
    private $openWeather;

    /**
     * @throws InvalidConfigException
     * @throws \Exception
     */
    private function initApiHelper()
    {
        if (empty(\Yii::$app->params['githubToken'])) {
            throw new InvalidConfigException('Please specify githubToken in app params');
        }

        $this->githubClient = new \Github\Client();

        $this->githubClient->authenticate(
            \Yii::$app->params['githubToken'], null,
            Client::AUTH_HTTP_TOKEN
        );

        if (empty(\Yii::$app->params['openWeatherKey'])) {
            throw new InvalidConfigException('Please specify openWeatherKey in app params');
        }

        $this->openWeather = new OpenWeatherMap(\Yii::$app->params['openWeatherKey']);
    }

    /**
     * Allows to get github user info
     * @param string $username
     * @return array|null
     */
    private function githubUserInfo(string $username)
    {
        try {
            return $this->githubClient->user()->show($username);
        } catch (RuntimeException $exception) {
            return null;
        }
    }

    /**
     * Allows to get weather at location
     * @param string $location
     * @return string
     */
    private function weather(string $location) : string
    {
        try {
            return $this->openWeather->getWeather(
                $location,
                'metric',
                'en'
            )->weather->description ?: 'Unknown';

        } catch (OpenWeatherMap\Exception $exception) {
            return 'Unknown';
        }
    }
}