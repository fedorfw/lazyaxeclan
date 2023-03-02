<?php
$crutch = require_once __DIR__.'/../../config/crutch.php';
$isProd = $crutch['isProd'];
/** @var yii\web\View $this */

$this->title = 'register';

$js = <<<JS
var register = new Vue({
  el: '#register',
  data: {
    email: '',
    password: '',
    errorMessage: null
  },
  methods: {
      onRegisterButton() {
        if (this.isValid) {
            let data = {
                  'email': this.email,
                  'password': this.password
            };
            axios.post('$isProd' +'/users/user/register', data).then( res => {
                  this.password = '';
                  this.email = '';
                  window.location.href = './confirm';
            }).catch ( error => {
            this.errorMessage = error.response.data.message
            setTimeout(() => {
                this.errorMessage = null
            }, 2000)
          })
        }
      }
      ,
      login() {
          return true
      }
//
  },
     computed: {
        userEmail: function (){
            return this.email
        },
        isValid: function () {
            if (this.password.length >= 6) {
                return true
            }
            return false
        }
      }
  
  // mounted() {
  //     this.userEmail();
  // }
});
JS;

$this->registerJs($js);

?>
<div id="register" class="site-login w-600px">
    <div v-if="errorMessage" class="alert alert-danger"> {{ errorMessage }}</div>
    <div class="d-flex flex-column  justify-content-center align-items-center p-0">
        <div class="mb-2">
            <h4> Регистрация на сайте</h4>
            <h2> Клан Ленивого Топора </h2>

            <div class="mb-2">
                <span > Почта </span>
                <input v-model="email" type="email" class="form-control"  aria-describedby="emailHelp">
            </div>
            <div class="mb-2">
                <span class="form-label"> Пароль </span>
                <input v-model="password" type="password" class="form-control">
            </div>
            <button @click="onRegisterButton" :disabled="!isValid" class="btn btn-primary">Зарегистрироваться</button>

        </div>
        <div v-if="!isValid" class="alert alert-danger mt-8" role="alert" > пароль должен быть длинной минимум 6 символов</div>
    </div>
</div>
