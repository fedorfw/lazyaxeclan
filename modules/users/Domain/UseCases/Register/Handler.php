<?php

namespace users\Domain\UseCases\Register;

use Doctrine\ORM\EntityManager;
use users\Domain\Entities\ConfirmToken;
use users\Domain\Entities\User;
use users\Domain\Interfaces\ConfirmTokenRepositoryInterface;
use users\Domain\Interfaces\EmailServiceInterface;
use users\Domain\Interfaces\UserRepositoryInterface;

class Handler
{
    private UserRepositoryInterface $user;
    private ConfirmTokenRepositoryInterface $tokens;
    private EntityManager $entityManager;
    private EmailServiceInterface $emailService;

    public function __construct(
        UserRepositoryInterface $user,
        ConfirmTokenRepositoryInterface $tokens,
        EntityManager $entityManager,
        EmailServiceInterface $emailService
    )
    {
        $this->user = $user;
        $this->tokens = $tokens;
        $this->entityManager = $entityManager;
        $this->emailService = $emailService;
    }

    public function handle(Command $command): User
    {
        $user = $this->user->findUserByEmail($command->email);
        if ($user) {
            throw new \DomainException('Такой пользовтель уже зарегистрирован.');
        }
        $user = new User();

        $user->setName($command->email);
        $user->setEmail($command->email);
        $user->setPass(md5($command->password));
        $user->setLastname('none');
        $user->setPhone('none');

        $this->entityManager->beginTransaction();
        try {
            $this->user->save($user);

            $token = new ConfirmToken($user);
            $this->tokens->save($token);

            $this->emailService->sendRegistration($user->getEmail(), $token->getCode());

            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
        }

        return $user;
    }
}
