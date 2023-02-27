<?php

namespace users\Domain\UseCases\Confirm;

use users\Domain\Interfaces\ConfirmTokenRepositoryInterface;
use users\Domain\Interfaces\UserRepositoryInterface;

class Handler
{
    private ConfirmTokenRepositoryInterface $tokens;
    private UserRepositoryInterface $users;

    public function __construct(
        ConfirmTokenRepositoryInterface $tokens,
        UserRepositoryInterface $users
    )
    {
        $this->tokens = $tokens;
        $this->users = $users;
    }

    public function handle(Command $command)
    {
        $token = $this->tokens->getByCode($command->code);
        if (!$token) {
            throw new \DomainException('Код не найден');
        }
        if ($token->getExpires() <= (new \DateTime())) {
            throw new \DomainException('истек срок действия кода подтверждения. Попробуйте заного');
        }

        $user = $token->getUser();
        $user->activate();

        $this->tokens->remove($token);
        return $user;

    }
}
