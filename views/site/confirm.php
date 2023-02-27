<?php
$crutch = require_once __DIR__.'/../../config/crutch.php';
$isProd = $crutch['isProd'];

/** @var yii\web\View $this */

$this->title = 'Confirm';
$js = <<<JS
var confirm = new Vue({
  el: '#confirm',
  data: {
    code: ''
  },
  methods: {
      onConfirmButton() {
          let data = {
              'code': this.code
          };
          axios.post('$isProd' +'/users/user/confirm', data).then( res => {
              this.code = '';
              window.location.href = './';
          })
      }
  }
});

JS;

$this->registerJs($js);

?>
<div id="confirm" class="site-login w-600px">
    <div class="d-flex flex-column  justify-content-center align-items-center p-0">
        <div>
            <h3>Введите код подверждения</h3>
            <h5>код был отправлен вам на почту</h5>
        <div class="mb-2">
             <span class="form-label"> код </span>
                <input v-model="code" type="text" class="form-control" required>
        </div>
            <button @click="onConfirmButton" class="btn btn-primary">Отправить</button>
        </div>
    </div>

</div>
