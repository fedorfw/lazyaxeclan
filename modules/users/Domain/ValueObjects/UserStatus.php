<?php

namespace users\Domain\ValueObjects;


class UserStatus
{
    const ACTIVE = 'active';
    const BLOCKED = 'blocked';
    const DELETED = 'deleted';

    private $value;

    public function __construct()
    {
        $this->value = self::ACTIVE;
    }

    public function getValue(): string
    {
        return $this->value;
    }


}
