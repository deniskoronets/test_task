<?php

namespace app\modules\api\traits;

use yii\base\UserException;
use yii\web\HttpException;
use yii\web\Response;

trait ApiResponse
{
    /**
     * For trait usage
     * @param int $code
     * @param $data
     * @return \yii\console\Response|Response
     */
    private function json(int $code, $data)
    {
        $response = \Yii::$app->getResponse();
        $response->format = Response::FORMAT_JSON;
        $response->statusCode = $code;
        $response->data = $data;

        return $response;
    }

    /**
     * Sends success response
     * @param $data
     * @param int $code
     * @return \yii\web\Response
     */
    public function success($data, int $code = 200)
    {
        return $this->json($code, [
            'success' => true,
            'error' => null,
            'data' => $data,
        ]);
    }

    /**
     * Sends error response
     * @param int $code
     * @param string $type
     * @param string $message
     * @param array $additional
     * @return \yii\web\Response
     */
    public function error(int $code, string $type, string $message, array $additional = [])
    {
        return $this->json($code, [
            'success' => false,
            'error' => [
                'code' => $code,
                'type' => $type,
                'message' => $message,
                'additional' => $additional
            ]
        ]);
    }

    public function handleErrors(\Closure $closure)
    {
        try {
            return $closure();

        } catch (HttpException $exception) {

            return $this->error(
                $exception->statusCode,
                'http',
                $exception->getMessage(),
                YII_DEBUG ? ['exception' => $exception] : []
            );

        } catch (UserException $exception) {

            return $this->error(
                422,
                'user',
                $exception->getMessage(),
                YII_DEBUG ? ['exception' => $exception] : []
            );

        } catch (\Throwable $exception) {

            return $this->error(
                500,
                'critical',
                'An error occurred while processing your request',
                YII_DEBUG ? ['exception' => $exception] : []
            );
        }
    }
}