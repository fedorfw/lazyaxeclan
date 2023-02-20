<?php

namespace app\modules\common\components;

use Yii;
use yii\web\Controller;
use yii\web\Response;

abstract class BaseApiController extends Controller
{
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::afterAction($action, $result);
    }

    protected function getJsonRest()
    {
        return @json_decode(Yii::$app->request->getRawBody());
    }

    protected function apiSuccess($data = ['status' => 'success'])
    {
        Yii::$app->response->statusCode = 200;

        return $data;
    }

    protected function apiError($data = ['status' => 'error'])
    {
        Yii::$app->response->statusCode = 404;

        return $data;
    }


}
