<?php

namespace users\Domain\Entities;

use DateTime;

class ConfirmToken
{
    const TOKEN_LENGTH = 6;

    private int $id;
    private string $code;
    private DateTime $expires;
    private User $user;

    public function __construct(User $user)
    {
        $this->code = $this->generateCode();
        $this->expires = (new DateTime())->modify('+1 day');
        $this->user = $user;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getExpires(): DateTime
    {
        return $this->expires;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    private function generateCode(): string
    {
        return substr(md5(uniqid('lazyaxeclan', true)), 0, self::TOKEN_LENGTH);
    }
}
