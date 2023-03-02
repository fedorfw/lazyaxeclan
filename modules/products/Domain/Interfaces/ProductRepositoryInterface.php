<?php

namespace products\Domain\Interfaces;

use products\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    public function findById(int $productId):? Product;

    public function getMyList(int $userId);

    public function getList();

    public function save(Product $product);

    public function delete(Product $product);

    public function getProductsByUser(int $userId);
}