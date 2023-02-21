<?php
$js = <<<JS
var app = new Vue({
  el: '#app',
  data: {
    message: 'Привет, Vue!1111',
    numbers: [1,3,4,6],
    user: Object,
    res: null
  },
  methods: {
      setFfw(){
          $.ajax({
            method: 'get',
            url: '/web/users/user/get-user',
            success: function (data){
                console.log(data);
                return this.res = data.data;
            }
        });
          this.user = res
      }
  }
});

$('#btnGetTo').on('click', function ()
    {
        var test = 'я кнопка тест'
        alert(test);
        // $.ajax({
        //     method: 'get',
        //     url: '/web/users/user/get-user',
        //     success: function(data){
        //         console.log(data.text);    /* выведет "Текст" */
        //         console.log(data.error);   /* выведет "Ошибка" */
        //     }
        // });
    });

JS;

$this->registerJs($js);

echo 'xx';
?>
<script type="module" src="newComponent.js"> </script>
чтото новое
<div id="app">
    {{ message }}
    {{ test }}
    <div v-for="item in numbers" >
        <p v-if="item != 3"> {{ item }} </p>
    </div>

    <input v-model="message" />
    <hr>
    <button id="btnGetTo">Кнопошкаsss</button>
    <button @click="setFfw">кнопка ffw</button>
    <div v-if="user">
        {{ user.name }}
    </div>



</div>



