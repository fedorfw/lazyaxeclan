<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */


use telegram\sendTelegram;
use users\Domain\Entities\User;
use users\Domain\Interfaces\UserRepositoryInterface;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$js = <<<JS
    $('#btn').on('click', function()
     {
        let text = $('#message').val()
        console.log("Попытка отправить сообщение " + text);
        $('#message').val("");
        $.ajax({
            url: '/modules/telegram/messageSandler.php',
            data: {telegramMessage: text},
            type: 'POST'
        })
    });
JS;

$this->registerJs($js);


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

//
//$method = 'sendMessage';
//$send_data = [
//    'text'   => "Привет со странички сайта Клан Ленивого Топора"
//];
//$send_data['chat_id'] = '@lazyAxeClan';
//$res = sendTelegram::sendTelegramMessage($method, $send_data);
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        This is the About page. You may modify the following file to customize its content:
        <?= $_POST['telegramMessage'] ?>
    </p>
<!--    <form action=about.php method="post">-->
<!--        <label>Введите сообщение-->
<!--        <br>-->
<!--        <input type="text" name="sendText" placeholder="привет всем" />-->
<!--        </label>-->
<!--        <input type="submit" value="Отправить">-->
<!--    </form>-->
    <form id="telegramMessage">
        <label>Написать в телеграм
            <br>
            <input id="message" name="message" type="text" value="" />
        </label>
        <input id="btn" type="button" value="Отправить" />
    </form>

</div>

