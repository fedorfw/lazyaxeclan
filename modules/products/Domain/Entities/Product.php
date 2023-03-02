<?php

namespace products\Domain\Entities;

use products\Domain\ValueObjects\ProductStatus;

class Product
{
    private int $id;
    private string $title;
    private string $text;
    private string $image = '';
    private string $tag = '';
    private string $price = '';
    private int $quantity = 1;
    private int $ownerUserId;

    public function __construct()
    {
        $this->status = new ProductStatus();
    }

    /**
     * @return int
     */
    public function getOwnerUserId(): int
    {
        return $this->ownerUserId;
    }

    /**
     * @param int $ownerUserId
     */
    public function setOwnerUserId(int $ownerUserId): void
    {
        $this->ownerUserId = $ownerUserId;
    }
    private ProductStatus $status;

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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag(string $tag): void
    {
        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return ProductStatus
     */
    public function getStatus(): ProductStatus
    {
        return $this->status;
    }

    /**
     * @param ProductStatus $status
     */
    public function setStatus(ProductStatus $status): void
    {
        $this->status = $status;
    }

}
