<?php
$crutch = require_once __DIR__.'/../../config/crutch.php';
$isProd = $crutch['isProd'];
/** @var yii\web\View $this */

$this->title = 'Клан Ленивого Топора';
$js = <<<JS
var index = new Vue({
    el: '#index',
    data: {
       products: null
    },
    methods: {
        loadProducts(){
            axios.get('$isProd' +'/products/all/list').then( res => {
                this.products = res.data.data
            });
        },
        cruth(item) {
            return '$isProd' + item;
        },
        buyProductButton(product) {
            alert('Покупка товара ' + product.title + ' в разработке!')
        }
     },
     computed: {
        //
      },
    mounted() {
      this.loadProducts();
  }
});
JS;

$this->registerJs($js);
?>
<div id="index" class="site-index">
    <h1>Продукты</h1>
    <hr>
    <div class="d-flex flex-wrap">
        <div v-for="product in products" class="card m-2" style="width: 200px;">
            <img :src=cruth(product.image)  class="card-img-top img-fluid img-thumbnail" :title=product.title >
            <div class="card-body bg-gradient bg-light">
                <h4 class="card-title"> {{ product.title }} </h4>
                <hr>
                <p class="card-text"> {{ product.text }} </p>
                <p class="card-text"> Кол-во: {{ product.quantity }} </p>
            </div>
            <div class="card-footer bg-warning d-flex flex-column justify-content-between">
                <div class="text-light text-black"> Цена: {{ product.price }} руб. </div>
                <button @click="buyProductButton(product)" class="btn btn-sm btn-primary"> купить </button>
            </div>
        </div>
    </div>
</div>


