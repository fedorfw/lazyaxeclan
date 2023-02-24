<?php

namespace users\Domain\UseCases\Update;

use Doctrine\ORM\EntityManager;
use telegrams\Domain\Services\SendTelegramService;
use users\Domain\Entities\User;
use users\Domain\Interfaces\UserRepositoryInterface;
use Yii;

class Handler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
   {
       $this->userRepository = $userRepository;
   }

    public function handle(Command $command)
    {
        $user = Yii::$container->get(UserRepositoryInterface::class)->findUser($command->id);
        $user->setName($command->name);
        $user->setEmail($command->email);
        $user->setPhone($command->phone);

        $this->userRepository->save($user);

//        $text = "Был зарегистрирован новый пользователь (". $user->getName() . ").";
//        $method = 'sendMessage';
//        $send_data['text'] = $text;
//        SendTelegramService::sendMessage( $method, $send_data);

        return $user;
    }

}
