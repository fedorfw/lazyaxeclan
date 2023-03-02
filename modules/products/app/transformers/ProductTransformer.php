<?php

namespace products\app\transformers;

use League\Fractal\TransformerAbstract;
use products\Domain\Entities\Product;

class ProductTransformer extends TransformerAbstract
{
    public function transform(Product $product)
    {
        return [
            'id' => $product->getId(),
            'title' => $product->getTitle(),
            'text' => $product->getText(),
            'image' => $product->getImage(),
            'tag' => $product->getTag(),
            'price' => $product->getPrice(),
            'quantity' => $product->getQuantity(),
            'ownerUserId' => $product->getOwnerUserId(),
            'status' => $product->getStatus()->getValue(),
        ];
    }
}
