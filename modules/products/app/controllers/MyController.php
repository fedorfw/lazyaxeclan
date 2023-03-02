<?php

namespace products\app\controllers;

use app\modules\common\components\BaseApiController;
use Doctrine\ORM\EntityManager;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use products\app\transformers\ProductTransformer;
use products\Domain\Entities\Product;
use products\Domain\Interfaces\ProductRepositoryInterface;
use Webmozart\Assert\Assert;
use Yii;
use yii\web\ForbiddenHttpException;
use products\Domain\UseCases\Create;
use yii\web\UploadedFile;

class MyController extends BaseApiController
{
    protected function verbs()
    {
        return [
            'create' => ['post'],
        ];
    }

    public function actionList()
    {
        $userId = Yii::$app->user->id;
        if (!$userId) {
            return $this->apiError();
        }

        $products = Yii::$container->get(ProductRepositoryInterface::class);
        $productList = $products->getMyList($userId);

        $collection = new Collection(
            $productList,
            new ProductTransformer()
        );
        return (new Manager())
            ->createData($collection)
            ->toArray();
    }

    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException();
        }

        $file = UploadedFile::getInstanceByName('file');
        $title = $_POST['title'];
        $text = $_POST['text'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        Assert::oneOf($file->getExtension(), ['jpg', 'png', 'gif', 'jpeg'], 'недопутимый формать изображения');
        $fileName = uniqid('product');
        $url = "/files/products/{$fileName}.{$file->getExtension()}";

        $command = new Create\Command();
        $command->actorUserId = Yii::$app->user->id;
        $command->addUrl = $url;
        $command->title = $title;
        $command->text = $text;
        $command->quantity = $quantity;
        $command->price = $price;

        $handler = Yii::$container->get(Create\Handler::class);
        $em = Yii::$container->get(EntityManager::class);

        $em->beginTransaction();
        try {
            $handler->handle($command);
            $file->saveAs("@app/web/files/products/{$fileName}.{$file->getExtension()}");
            $em->commit();
        } catch (\Exception $e) {
            $em->rollback();
            return $this->apiError([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return $this->apiSuccess();
    }
}
