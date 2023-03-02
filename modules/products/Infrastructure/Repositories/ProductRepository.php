<?php

namespace products\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use products\Domain\Entities\Product;
use products\Domain\Interfaces\ProductRepositoryInterface;
use yii\base\Theme;

class ProductRepository implements ProductRepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findById(int $productId):? Product
    {
        return $this->entityManager->getRepository(Product::class)
            ->find($productId);
    }

    public function getMyList(int $userId)
    {
        return $this->entityManager->getRepository(Product::class)
            ->findBy([
                'ownerUserId' => $userId
            ], ['id' => 'DESC']);
    }

    public function getList()
    {
        return $this->entityManager->getRepository(Product::class)
            ->findBy([], ['id' => 'DESC']);
    }

    public function save(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function delete(Product $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }

    public function getProductsByUser(int $userId)
    {
        return $this->entityManager->getRepository(Product::class)
            ->findBy([
                'ownerUserId' => $userId
            ]);
    }
}
