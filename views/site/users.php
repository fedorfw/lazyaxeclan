<?php


use users\Domain\Interfaces\UserRepositoryInterface;

echo $hostUser = UserRepositoryInterface::testGet();


foreach ($users as $user) {
    echo $user->name;
}
?>


