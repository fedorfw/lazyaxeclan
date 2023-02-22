<?php

namespace users\app\controllers;

use app\modules\common\components\BaseApiController;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
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

        $user = Yii::$container->get(UserRepository::class)->findUserByEmail($email);
        if (!$user) {
            return $this->apiError();
        }

        $item = new Item(
            $user,
            new UserTransformer()
        );
        return (new Manager())
            ->createData($item)
            ->toArray();

    }

    public function actionList()
    {
        try {
            $users = Yii::$container->get(UserRepositoryInterface::class)
                ->getList();
        } catch (\Exception $e) {
            return $this->apiError();
        }

        $collection = new Collection(
            $users,
            new UserTransformer()
        );
        return (new Manager())
            ->createData($collection)
            ->toArray();
    }
}
