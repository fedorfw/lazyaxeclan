<?php

/** @var yii\web\View $this */

$this->title = 'Login';

$js = <<<JS
var login = new Vue({
  el: '#login',
  data: {
    // dev - ''  /  prod = '/web'
    isProd: '',
    email: '',
    password: ''
  },
  methods: {
      goToRegisterPage() {
          window.location.href = './register';
      },
      login() {
          let data = {
              'email': this.email,
              'password': this.password
          };
          axios.post(this.isProd +'/users/user/login', data).then( res => {
              this.password = '';
              this.email = '';
              window.location.href = './';
          })
        }
      }
//
//   },
     // computed: {
     //    userEmail: function (){
     //        return this.email
     //    }
     //  }
     //
  // mounted() {
  //     this.userEmail();
  // }
});
JS;

$this->registerJs($js);

?>
<div id="login" class="site-login w-600px">
    <div class="d-flex flex-column  justify-content-center align-items-center p-0">
        <div>
        <div class="mb-2">
             <span class="form-label"> Почта </span>
                <input v-model="email" type="email" class="form-control"  aria-describedby="emailHelp" required>
        </div>
        <div class="mb-2">
            <span > Пароль </span>
                <input v-model="password" type="password" class="form-control" required>
        </div>

        <button @click="login" class="btn btn-primary">Войти</button>
        <button @click="goToRegisterPage" class="btn btn-secondary">Регистрация</button>
        </div>

    </div>

</div>
