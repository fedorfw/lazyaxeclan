<?php

namespace users\Domain\Interfaces;

use users\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function findUser(int $userId):? User;

    public function findUserByEmail(string $email):? User;

    public function save(User $user);

    public function delete(User $user);

    public function testGet($hi): string;

}