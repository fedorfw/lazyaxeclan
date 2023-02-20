<?php

namespace users\Domain\UseCases\GetList;

use Doctrine\ORM\EntityManager;
use users\Domain\Entities\User;
use users\Domain\Interfaces\UserRepositoryInterface;

class Handler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
   {
       $this->userRepository = $userRepository;
   }

    public function handler(Command $command): string
    {
        return  $this->userRepository->findUserByEmail($command->hi);
    }

}
