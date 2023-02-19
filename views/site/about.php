<?php
require_once "../telegramBot/turtleBot.php";

/** @var yii\web\View $this */

use users\Domain\Entities\User;
use users\Domain\Interfaces\UserRepositoryInterface;
use yii\helpers\Html;

//class HandleUser
//{
//    private UserRepositoryInterface $userRepository;
//    public function __construct(UserRepositoryInterface $userRepository)
//    {
//        $this->userRepository = $userRepository;
//    }
//    public function getUserByEmail($email): string
//    {
//        $user = $this->userRepository->findUserByEmail($email)->getName();
//        return $user;
//    }
//}
//$a = Yii::$container->get(UserRepositoryInterface::class)->testGet("hi");
$email = "fedorfw@mail.ru";
$method = 'sendMessage';
$send_data = [
    'text'   => "Привет со странички сайта Клан Ленивого Топора"
];
$send_data['chat_id'] = '@lazyaxeclan';
sendTelegram($method, $send_data);
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

<!--    <div>--><?//= $a ?><!-- </div>-->
    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>
