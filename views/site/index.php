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
    messageTelegram: '',
    numbers: [1,3,4,6],
    user: null,
    data: null,
    testResp: null
  },
  methods: {
      setFfw(){
          this.user = $.getJSON({
            url: '/web/users/user/list'
          }).done(function (data){
          });
          setTimeout(this.updateUser, 1000)
      },
      updateUser(a) {
          this.testResp = this.user.responseJSON.data
      },
      sendMessageToTelegram() {
            $.post({
                url: '/web/telegram/telegram/send',
                data: {telegramMessage: this.messageTelegram}
            });
            this.messageTelegram = '' 
        }
  },
  computed: {
    //
  },
  mounted() {
      this.setFfw();
  }
});
JS;

$this->registerJs($js);
?>
<div id="index" class="site-index">
    <hr>
    <h4>Отправить сообщение</h4>
    <input v-model="messageTelegram" value="" />
    <input @click="sendMessageToTelegram" type="button" value="Отправить" />
    <br>
    <div v-if="user">
        <br>
        <hr>
        <table class="table table-dark table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in testResp">
                <th scope="row">{{ item.id }}</th>
                <td>{{ item.name }} </td>
                <td>{{ item.email }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


