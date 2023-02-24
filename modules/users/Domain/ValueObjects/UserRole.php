<?php

namespace users\Domain\ValueObjects;

class UserRole
{
    const USER = 'user';
    const ADMIN = 'admin';
    const BAN = 'ban';
    private $value;

    public function __construct()
    {
        $this->value = self::USER;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
