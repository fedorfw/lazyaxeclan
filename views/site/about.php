<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use app\models\Users;
use telegrams\sendTelegram;
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

    $('#btnGet').on('click', function ()
    {
        $.ajax({
            method: 'get',
            url: '/web/users/user/get-user',
            success: function(data){
                console.log(data.text);    /* выведет "Текст" */
                console.log(data.error);   /* выведет "Ошибка" */
    }
        });
    });
JS;

$this->registerJs($js);
//VueJsAsset::register($this);
//$users = Users::find()->all();
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <form id="telegramMessage">
        <label>Написать в телеграм
            <br>
            <input id="message" name="message" type="text" value="" />
        </label>
        <input id="btn" type="button" value="Отправить" />
    </form>
    <br>
    <br>
    <br>
    <hr>
    <h4>Проверка ajax</h4>
    <button id="btnGet">Кнопошкаsss</button>
    <hr>
    <div>юзерсы</div>

</div>

