<?php


use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use users\app\transformers\UserTransformer;
use users\Domain\Interfaces\UserRepositoryInterface;
use Yii;
use app\modules\common\components\BaseApiController;

try {
    $users = Yii::$container->get(UserRepositoryInterface::class)
        ->testGet('hi');
} catch (\Exception $e) {
    return $this->apiError();
}

$collection = new Collection(
    $users,
    new UserTransformer()
);
return (new Manager())
    ->createData($collection)
    ->toArray();



foreach ($users as $user) {
    echo $user->name;
}
?>


