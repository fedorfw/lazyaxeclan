<?php

namespace users\app\controllers;

use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\User;
use app\modules\common\components\BaseApiController;
use DomainException;
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
use users\Domain\UseCases\Register;
use users\Domain\UseCases\Confirm;
use users\Domain\UseCases\TestEmailSend;

class UserController extends BaseApiController
{
    /** @var UserRepositoryInterface */
    private  $users;


    public function init()
    {
        $this->users = Yii::$container->get(UserRepositoryInterface::class);
        parent::init();
    }


//    public function actionAddUser()
//    {
//        $userData = $this->getJsonRest();
//        if (!$userData) {
//            return $this->apiError([
//                'status' => 'error',
//                'message' => 'Ошибка параметров'
//            ]);
//        }
//
//        $command = new Create\Command();
//        $command->name= $userData->name;
//        $command->lastName = $userData->lastName ?? null;
//        $command->email = $userData->email ?? null;
//        $command->phone = $userData->phone ?? null;
//        $command->pass = $userData->pass ?? null;
//
//        $handler = Yii::$container->get(Create\Handler::class);
//
//        try {
//            $handler->handle($command);
//        } catch (\Exception $e) {
//            return $this->apiError([
//                'status' => 'error',
//                'message' => $e->getMessage()
//            ]);
//        }
//
//        return $this->apiSuccess();
//    }
//
//    public function actionGetUser()
//    {
//        $email = "fedorfw@mail.ru";
//
//        $user = Yii::$container->get(UserRepository::class)->findUserByEmail($email);
//        if (!$user) {
//            return $this->apiError();
//        }
//
//        $item = new Item(
//            $user,
//            new UserTransformer()
//        );
//        return (new Manager())
//            ->createData($item)
//            ->toArray();
//
//    }
//
//    public function actionList()
//    {
//        try {
//            $users = Yii::$container->get(UserRepositoryInterface::class)
//                ->getList();
//        } catch (\Exception $e) {
//            return $this->apiError($e);
//        }
//
//        $collection = new Collection(
//            $users,
//            new UserTransformer()
//        );
//        return (new Manager())
//            ->createData($collection)
//            ->toArray();
//    }
//
//    public function actionDeleteUser()
//    {
//        $user = $this->getJsonRest();
//        if (!$user) {
//            return $this->apiError([
//                'status' => 'error',
//                'message' => 'Ошибка параметров'
//            ]);
//        }
//        $user = Yii::$container->get(UserRepository::class)->findUser($user->id);
//
//        Yii::$container->get(UserRepository::class)->delete($user);
//
//        return $this->apiSuccess();
//    }
//
//    public function actionUpdateUser()
//    {
//        $userData = $this->getJsonRest();
//        if (!$userData) {
//            return $this->apiError([
//                'status' => 'error',
//                'message' => 'Ошибка параметров'
//            ]);
//        }
//
//        $command = new Update\Command();
//        $command->id = $userData->id;
//        $command->name = $userData->name;
//        $command->email = $userData->email ?? null;
//        $command->phone = $userData->phone ?? null;
//
//        $handler = Yii::$container->get(Update\Handler::class);
//
//        try {
//            $handler->handle($command);
//        } catch (\Exception $e) {
//            return $this->apiError([
//                'status' => 'error',
//                'message' => $e->getMessage()
//            ]);
//        }
//
//        return $this->apiSuccess();
//    }

    public function actionRegister()
    {
        $json = $this->getJsonRest();
        if (!$json) {
            return $this->apiError();
        }

        $registerForm = new RegisterForm();
        $registerForm->setAttributes([
            'email' => $json->email,
            'password' => $json->password,
        ]);

        if (!$registerForm->validate()) {
            return $this->apiError([
                'status' => 'error',
                'field_errors' => $registerForm->getErrors()
            ]);
        }

        $command = new Register\Command();
        $command->email = $registerForm->email;
        $command->password = $registerForm->password;

        try {
            $user = Yii::$container->get(Register\Handler::class)
                ->handle($command);

            return $this->apiSuccess();
        } catch (DomainException $e) {
            return $this->apiError([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function actionConfirm()
    {
        $json = $this->getJsonRest();
        if (!$json) {
            return $this->apiError([
                'status' => 'error',
                'message' => 'Ошибка параметров'
            ]);
        }

        $command = new Confirm\Command();
        $command->code = $json->code;

        $handler = Yii::$container->get(Confirm\Handler::class);
        try {
            $user = $handler->handle($command);
            Yii::$app->user->login(User::findIdentity($user->getId()));

            return $this->apiSuccess();
        } catch (DomainException $e) {
            return $this->apiError([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function actionLogin()
    {
        $json = $this->getJsonRest();
        if (!$json) {
            return $this->apiError();
        }

        if (!Yii::$app->user->isGuest) {
            return $this->apiError([
                'status' => 'error',
                'message' => 'Вы уже авторизованы'
            ]);
        }

        $loginParams = [
            'LoginForm' => [
                'email' => $json->email,
                'password' => $json->password,
                'rememberMe' => true
            ]
        ];

        $model = new LoginForm();
        if (!$model->load($loginParams)) {
            return $this->apiError([
                'status' => 'error',
                'message' => 'Ошибка параметров'
            ]);
        }
        if (!$model->validate()) {
            Yii::$app->response->statusCode = 401;

            return [
                'status' => 'error',
                'message' => implode(',', $model->getFirstErrors()),
            ];
        }
        if (!$model->login()) {
            return $this->apiError([
                'status' => 'error',
                'message' => 'Ошибка авторизации попробуйте позже'
            ]);
        }

        $user = $this->users->findUser(Yii::$app->user->id);
        $item = new Item(
            $user,
            new UserTransformer()
        );
        return (new Manager())
            ->createData($item)
            ->toArray();
    }

    public function actionSendMail()
    {
        $json = $this->getJsonRest();

        $command = new TestEmailSend\Command();
        $command->text = $json->newMail;

        try {
            Yii::$container->get(TestEmailSend\Handler::class)
                ->handle($command);

            return $this->apiSuccess();
        } catch (DomainException $e) {
            return $this->apiError([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
