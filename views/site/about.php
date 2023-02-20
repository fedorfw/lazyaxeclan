<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use telegram\sendTelegram;
use users\Domain\Entities\User;
use users\Domain\Interfaces\UserRepositoryInterface;
use Webmozart\Assert\Assert;
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

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>
    <div>
        <?=
        $varNul = null;
        $test = '';
        $test2 = $test." я тест2";
        echo $test2;
        echo "<br>";
        echo "<hr>";
        Assert::notNull($varNul, 'она же пустая');
//        if (!$varNul) {
//            $varNul = "была пустая";
//        }
        echo $varNul;
        echo "<hr>";


        ?>
    </div>
    <form id="telegramMessage">
        <label>Написать в телеграм
            <br>
            <input id="message" name="message" type="text" value="" />
        </label>
        <input id="btn" type="button" value="Отправить" />
    </form>

</div>

