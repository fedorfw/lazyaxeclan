<?php

namespace users\Domain\UseCases\Create;

use Doctrine\ORM\EntityManager;
use telegrams\Domain\Services\SendTelegramService;
use users\Domain\Entities\User;
use users\Domain\Interfaces\UserRepositoryInterface;

class Handler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
   {
       $this->userRepository = $userRepository;
   }

    public function handle(Command $command)
    {
        $user = new User();
        $user->setName($command->name);
        $user->setLastname($command->lastName);
        $user->setEmail($command->email);
        $user->setPhone($command->phone);
        $user->setPass($command->pass);

        $this->userRepository->save($user);

        $text = "Был зарегистрирован новый пользователь (". $user->getName() . ").";
        $method = 'sendMessage';
        $send_data['text'] = $text;
        SendTelegramService::sendMessage( $method, $send_data);

        return $user;
    }

}
