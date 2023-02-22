<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use app\models\Users;
use telegram\sendTelegram;
use users\Domain\Entities\User;
use users\Domain\Interfaces\UserRepositoryInterface;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Клан Ленивого Топора';
$js = <<<JS
var index = new Vue({
  el: '#index',
  data: {
    message: 'Привет, Vue!1111',
    numbers: [1,3,4,6],
    user: null,
    data: null,
    testResp: null
  },
  methods: {
      setFfw(){
          this.user = $.getJSON({
            url: '/modules/users/user/list'
          }).done(function (data){
              console.log(data);
          });
          setTimeout(this.updateUser, 1000)
      },
      updateUser(a) {
          this.testResp = this.user.responseJSON.data
      }
  },
  computed: {
    
  },
  mounted() {
      this.setFfw();
  ;
  }
});

    $('#btn').on('click', function()
     {
        let telegram = $('#textTelegram').val()
        console.log("Попытка отправить сообщение " + telegram);
        $('#textTelegram').val("");
        $.ajax({
            url: '/modules/telegram/messageSandler.php',
            data: {telegramMessage: telegram},
            type: 'POST'
        })
    });
JS;

$this->registerJs($js);
?>
<div id="index" class="site-index">
 тут наша страничка
    <br>
    <br>
    <form id="telegramMessage">
        <label>Написать в телеграм
            <br>
            <input id="textTelegram" name="textTelegram" type="text" value="" />
        </label>
        <input id="btn" type="button" value="Отправить" />
    </form>
    <br>
{{ message }}
    <button @click="setFfw" >Кнопошкаsss</button>
    <div v-if="user">
        <br>
        <br>
        <div v-for="item in testResp">
        <span>почта - {{ item.email }} </span>
        <span>имя - {{ item.name }} </span>
        </div>
        <br>
    </div>
</div>


