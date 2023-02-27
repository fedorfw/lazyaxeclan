<?php

namespace users\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use users\Domain\Entities\ConfirmToken;
use users\Domain\Entities\User;
use users\Domain\Interfaces\ConfirmTokenRepositoryInterface;

class ConfirmTokenRepository implements ConfirmTokenRepositoryInterface
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getByCode(string $code): ?ConfirmToken
    {
        return $this->em->getRepository(ConfirmToken::class)
            ->findOneBy([
                'code' => $code
            ]);
    }

    public function remove(ConfirmToken $token)
    {
        $this->em->remove($token);
        $this->em->flush();
    }
    public function save(ConfirmToken $token)
    {
        $this->em->persist($token);
        $this->em->flush();
    }

    public function clearRecoveryTokens(User $user)
    {
        $this->em->createQueryBuilder()
            ->delete(ConfirmToken::class, 'c')
            ->where('IDENTITY(c.user) = :user_id')
            ->setParameter('user_id', $user->getId())
            ->getQuery()
            ->execute();
    }
}
