<?php

namespace users\Domain\ValueObjects;


use Webmozart\Assert\Assert;

class UserStatus
{
    const NEW = 'new';
    const ACTIVE = 'active';
    const BLOCKED = 'blocked';
    const DELETED = 'deleted';

    private string $value;

    public function __construct()
    {
        $this->value = self::NEW;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setActive()
    {
        if ($this->value != self::NEW) {
            throw new \DomainException('Код уже был подтвержден');
        }
        $this->value = self::ACTIVE;
    }

    public function isActive(): bool
    {
        return $this->value == self::ACTIVE;
    }

    public function change(string $status)
    {
        Assert::oneOf($status, [self::NEW, self::ACTIVE, self::BLOCKED, self::DELETED]);
        $this->value = $status;
    }

}
