<?php

namespace users\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use users\Domain\Entities\User;
use users\Domain\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function testGet($hi): string
    {
        if ($hi == "hi") {
            return "ответ хай";
        }
        return "нет ответа";
    }

    public function findUser(int $userId):? User
    {
        return $this->entityManager->getRepository(User::class)
            ->find($userId);
    }

    public function findUserByEmail(string $email):? User
    {
        var_dump('x');
        die;
        return $this->entityManager->getRepository(User::class)
            ->findOneBy([
                'email' => $email
            ]);
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function delete(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

}