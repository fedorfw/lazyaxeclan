<?php


use users\Domain\Interfaces\UserRepositoryInterface;

echo $hostUser = Yii::$container->get(UserRepositoryInterface::class)->testGet('hi');


foreach ($users as $user) {
    echo $user->name;
}
?>


