<?php
$crutch = require_once __DIR__.'/../../config/crutch.php';
$isProd = $crutch['isProd'];
/** @var yii\web\View $this */

$this->title = 'Клан Ленивого Топора';
$js = <<<JS
var telegram = new Vue({
        el: '#telegram',
    data: {
        messageTelegram: '',
        testResp: null,
        testTelegramMessage: null,
        isCount: true,
        timer: 0
    },
    methods: {
        sendMessageToTelegram() {
            axios.post('$isProd' +'/telegrams/telegram/send', {message: this.messageTelegram}).then( res => {
                this.messageTelegram = ''
            })
        },
        testTelegram() {
            axios.get('$isProd' +'/telegrams/telegram/get-message').then( res => {
                this.testTelegramMessage = res.data.data;
            });
        },
        startCount() {
            if (this.isCount) {
                this.timer = setInterval(this.timerFunc, 1000 * 3)
                this.isCount = false
            } else {
                clearInterval(this.timer)
                this.isCount = true
            }
        },
        timerFunc() {
            this.testTelegram();
        },
    },
    computed: {
        getCountState: function () {
            if (this.isCount) {
            return 'Стою курю'
            }
        return 'Работаю'
        }
    }
});
JS;

$this->registerJs($js);
?>
<div id="telegram" class="site-index">
    <hr>
    <div  class="row g-2" >
        <h3>Отправить сообщение </h3>
        <label>на тестовый телеграм канал @lazyAxeClan
            <textarea rows="3" v-model="messageTelegram" class="form-control"   style="resize: none"></textarea>
            <button @click.prevent="sendMessageToTelegram" type="submit" class="btn btn-primary mt-1">Отправить</button>
        </label>
    </div>
    <button @click="startCount" class="btn btn-dark mt-5"> Кнопка - {{ getCountState }} </button>
</div>