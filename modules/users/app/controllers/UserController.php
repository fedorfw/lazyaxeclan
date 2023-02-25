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
use users\Domain\UseCases\Create;
use users\Domain\UseCases\Update;

class UserController extends BaseApiController
{
    public function actionAddUser()
    {
        $userData = $this->getJsonRest();
        if (!$userData) {
            return $this->apiError([
                'status' => 'error',
                'message' => 'Ошибка параметров'
            ]);
        }

        $command = new Create\Command();
        $command->name= $userData->name;
        $command->lastName = $userData->lastName ?? null;
        $command->email = $userData->email ?? null;
        $command->phone = $userData->phone ?? null;
        $command->pass = $userData->pass ?? null;

        $handler = Yii::$container->get(Create\Handler::class);

        try {
            $handler->handle($command);
        } catch (\Exception $e) {
            return $this->apiError([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

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
            return $this->apiError($e);
        }

        $collection = new Collection(
            $users,
            new UserTransformer()
        );
        return (new Manager())
            ->createData($collection)
            ->toArray();
    }

    public function actionDeleteUser()
    {
        $user = $this->getJsonRest();
        if (!$user) {
            return $this->apiError([
                'status' => 'error',
                'message' => 'Ошибка параметров'
            ]);
        }
        $user = Yii::$container->get(UserRepository::class)->findUser($user->id);

        Yii::$container->get(UserRepository::class)->delete($user);

        return $this->apiSuccess();
    }

    public function actionUpdateUser()
    {
        $userData = $this->getJsonRest();
        if (!$userData) {
            return $this->apiError([
                'status' => 'error',
                'message' => 'Ошибка параметров'
            ]);
        }

        $command = new Update\Command();
        $command->id = $userData->id;
        $command->name = $userData->name;
        $command->email = $userData->email ?? null;
        $command->phone = $userData->phone ?? null;

        $handler = Yii::$container->get(Update\Handler::class);

        try {
            $handler->handle($command);
        } catch (\Exception $e) {
            return $this->apiError([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return $this->apiSuccess();
    }
}
