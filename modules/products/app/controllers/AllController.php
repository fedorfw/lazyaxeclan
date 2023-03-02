<?php

namespace products\app\controllers;

use app\modules\common\components\BaseApiController;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use products\app\transformers\ProductTransformer;
use products\Domain\Interfaces\ProductRepositoryInterface;
use Yii;

class AllController extends BaseApiController
{
    public function actionList()
    {
        $products = Yii::$container->get(ProductRepositoryInterface::class);
        $productList = $products->getList();

        $collection = new Collection(
            $productList,
            new ProductTransformer()
        );
        return (new Manager())
            ->createData($collection)
            ->toArray();
    }
}
