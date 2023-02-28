<?php

namespace users\Domain\Entities;

use users\Domain\ValueObjects\UserRole;
use users\Domain\ValueObjects\UserStatus;

class User
{
    private int $id;
    private string $email;
    private string $name;
    private string $phone;
    private string $lastName;
    private string $pass;
    private UserRole $role;
    private UserStatus $status;


    public function __construct()
    {
        $this->status = new UserStatus();
        $this->role = new UserRole();
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    /**
     * @return UserRole
     */
    public function getRole(): UserRole
    {
        return $this->role;
    }

    /**
     * @param UserRole $role
     */
    public function setRole(UserRole $role): void
    {
        $this->role = $role;
    }

    /**
     * @return UserStatus
     */
    public function getStatus(): UserStatus
    {
        return $this->status;
    }

    /**
     * @param UserStatus $status
     */
    public function setStatus(UserStatus $status): void
    {
        $this->status = $status;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastname(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function activate(): void
    {
        $this->status->setActive();
    }

}
