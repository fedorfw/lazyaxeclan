<?php

namespace users\app\controllers;

use app\modules\common\components\BaseApiController;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use users\app\transformers\UserTransformer;
use users\Domain\Interfaces\UserRepositoryInterface;
use users\Infrastructure\Repositories\UserRepository;
use Yii;
use yii\di\Container;
use yii\web\ForbiddenHttpException;
use users\Domain\UseCases\GetList;

class UserController extends BaseApiController
{
    public function actionTest()
    {
        return $this->apiSuccess();
    }

    public function actionGetUser()
    {
        $email = "fedorfw@mail.ru";
        $command = new GetList\Command();
        $command->hi = $email;


        try {
            Yii::$container->get(GetList\Handler::class)->handler($command);
        } catch (\Exception $e) {
            return $this->apiError([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        return $this->apiSuccess();
    }
}
