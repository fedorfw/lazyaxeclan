<?php

namespace products\Domain\UseCases\Create;

class Command
{
    public $actorUserId;
    public $addUrl;
    public string $title;
    public string $text;
    public int $quantity;
    public string $price;
}
