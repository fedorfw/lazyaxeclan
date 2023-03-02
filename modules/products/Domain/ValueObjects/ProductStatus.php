<?php

namespace products\Domain\ValueObjects;

use Webmozart\Assert\Assert;

class ProductStatus
{
    const DRAFT = 'draft';
    const PUBLISHED = 'published';
    const CANCELED = 'canceled';
    const SOLD = 'sold';

    private string $value;

    public function __construct()
    {
        $this->value = self::DRAFT;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setSold()
    {
        if ($this->value != self::PUBLISHED) {
            throw new \DomainException('Продать можно только опубликованный товар');
        }
        $this->value = self::SOLD;
    }

    public function setPublish()
    {
        if ($this->value != self::DRAFT) {
            throw new \DomainException('Опубликовать можно только черновик');
        }
        $this->value = self::PUBLISHED;
    }

    public function setCancel()
    {
        if ($this->value != self::DRAFT || $this->value != self::PUBLISHED) {
            throw new \DomainException('Отменить можно только черновик или опубликованный товар');
        }
        $this->value = self::CANCELED;
    }
}
