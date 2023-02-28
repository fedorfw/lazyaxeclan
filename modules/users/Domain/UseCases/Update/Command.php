<?php

namespace users\Domain\UseCases\Update;

class Command
{
    public int $id;
    public string $name;
    public string $lastName;
    public string $email;
    public string $phone;
    public string $pass;
    public string $role;
    public string $status;

}
