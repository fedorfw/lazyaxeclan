<?php

namespace users\Domain\Interfaces;

use users\Domain\Entities\ConfirmToken;
use users\Domain\Entities\User;

interface ConfirmTokenRepositoryInterface
{
    public function getByCode(string $code):? ConfirmToken;

    public function remove(ConfirmToken $token);

    public function save(ConfirmToken $token);

    public function clearRecoveryTokens(User $user);
}