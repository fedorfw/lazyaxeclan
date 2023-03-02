<?php

namespace products\Domain\UseCases\Create;

use products\Domain\Entities\Product;
use products\Domain\Interfaces\ProductRepositoryInterface;
use telegrams\Domain\Services\SendTelegramService;
use users\Domain\Interfaces\UserRepositoryInterface;
use Webmozart\Assert\Assert;

class Handler
{
    private ProductRepositoryInterface $products;
    private UserRepositoryInterface $users;

    public function __construct(ProductRepositoryInterface $products, UserRepositoryInterface $users)
    {
        $this->products = $products;
        $this->users = $users;
    }

    public function handle(Command $command)
    {
        $user = $this->users->findUser($command->actorUserId);
        Assert::notNull($user, 'Пользователь не найден');

        $product = new Product();
        $product->setTitle($command->title);
        $product->setText($command->text);
        $product->setQuantity($command->quantity);
        $product->setPrice($command->price);
        $product->setOwnerUserId($command->actorUserId);
        $product->setImage($command->addUrl);

        $this->products->save($product);


        $textMessage = "На сайте был создан новый товар $command->title - $command->text посмотреть все товары можно на странице ".'https://lazyaxeclan.site/web/';
        $method = 'sendMessage';
        $send_data['text'] = $textMessage;
        SendTelegramService::sendMessage($method, $send_data);

        return $product;
    }
}
