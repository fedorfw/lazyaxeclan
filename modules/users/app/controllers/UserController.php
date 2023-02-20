<?php

namespace users\app\controllers;

use app\modules\common\components\BaseApiController;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use users\app\transformers\UserTransformer;
use users\Domain\Interfaces\UserRepositoryInterface;
use Yii;
use yii\web\ForbiddenHttpException;

class UserController extends BaseApiController
{
    public function actionTest()
    {
        return $this->apiSuccess();
    }

    public function actionGetUser()
    {
        $email = "fedorfw@mail.ru";

        try {
            $users = Yii::$container->get(UserRepositoryInterface::class)
                ->findUserByEmail($email);
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
