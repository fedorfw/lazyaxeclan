<?php
$crutch = require_once __DIR__.'/../../config/crutch.php';
$isProd = $crutch['isProd'];
/** @var yii\web\View $this */

$this->title = 'Клан Ленивого Топора';
$js = <<<JS
var myProducts = new Vue({
    el: '#myProducts',
    data: {
        myProducts: null,
        title: '',
        text: '',
        price: '',
        quantity: '',
        fileReady: false,
        url: null,
        newFile: null,
        errorMessage: null,
        successMessage: null
        
    },
    methods: {
            loadMyProducts(){
                axios.get('$isProd' +'/products/my/list').then( res => {
                    this.myProducts = res.data.data
                });
            },
            onFileChangeNew(e) {
                this.fileReady = true;
                this.errorMessage = null;
                const file = e.target.files[0];
                this.url = URL.createObjectURL(file);
            },
            uploadNew() {
                    var s = this
                    const dataFile = new FormData()
                    var imagefile = document.querySelector('#file')
                    let extension = imagefile.files[0].type
                    let fileSize = imagefile.files[0].size
                    console.log(imagefile.files[0])
                    if (extension in {'image/jpeg': 1, 'image/gif': 1, 'image/png': 1} &&
                    fileSize <= 5242880 ) { 
                        dataFile.append('file', imagefile.files[0])
                        dataFile.append('title', this.title)
                        dataFile.append('text', this.text)
                        dataFile.append('quantity', this.quantity)
                        dataFile.append('price', this.price)
                        axios.post('$isProd' + '/products/my/create', dataFile, {
                        headers: {
                        'Content-Type': 'multipart/form-data'
                        }
                        }).then(response => {
                            this.loadMyProducts();
                            this.closeCollapse();
                            this.title = '';
                            this.text = '';
                            this.quantity = '';
                            this.price = '';
                            this.successMessage = 'Товар добавален'
                            setTimeout(() => {
                                this.successMessage = null
                            }, 3000)
                            console.log(response)
                        }).catch(error => {
                            console.log(error.response.message)
                        })
                    } else {
                    this.errorMessage = 'Не допустимый файл (разрещено .jpg .png .gif и размер файла не должен превышеть 3 Мб';
                    }
            },
            cruth(item) {
                return '$isProd' + item;
            },
            closeCollapse() {
                var bsCollapse = new bootstrap.Collapse(addNewProduct, {
                toggle: true
                })  
            }
     },
     computed: {
        isDisabled() {
            if (this.title !== '' &&
                this.text !== '' &&
                 this.price !== '' &&
                  this.quantity !== '' &&
                  this.fileReady) {
                return true
            }
            return false
        },
      },
  mounted() {
      this.loadMyProducts();
  }
});
JS;

$this->registerJs($js);
?>
<div id="myProducts" class="site-index">
    <div v-if="errorMessage" class="alert alert-danger"> {{ errorMessage }}</div>
    <div v-if="successMessage" class="alert alert-success"> {{ successMessage }}</div>

    <h1>Мои Товары</h1>
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#addNewProduct" aria-expanded="false" aria-controls="addNewProduct">
        Добавить товар
    </button>
    <hr>
        <div class="collapse" id="addNewProduct" >
            <div class="d-flex row">
                <div class="card card-body col-6 mx-2" >
                    <span class="alert alert-info mt-2"> все поля обязательны к заполнению </span>
                    <input v-model.trim="title" class="form-control mb-1" type="text" placeholder="Название" >
                    <input v-model.trim="text" class="form-control mb-1" type="text" placeholder="Описание" >
                    <input v-model.trim="price" class="form-control mb-1" type="number" placeholder="Цена" >
                    <input v-model.trim="quantity" class="form-control mb-1" type="number" placeholder="Количсетво" >
                    <div style="display: flex; flex-direction: column">
                            <div>
                                <label class="btn btn-outline-primary"> Изображение
                                    <input ref="file" class="" name="file" type="file" accept="image/jpeg, image/gif, image/png" id="file" @change="onFileChangeNew" />

                                </label>
                            </div>
                    </div>
                    <button @click="uploadNew" :disabled="!isDisabled" class="btn btn-primary mt-2">Добавить товар</button>
                </div>
                <div class="card card-body col-3">
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#productExample" aria-expanded="false" aria-controls="productExample">
                        Предпросмотр карточки товара
                    </button>
                    <div class="card m-2 collapse" style="max-width: 18rem;" id="productExample">
                        <img v-if="url" :src="url"  class="card-img-top img-fluid img-thumbnail" :title=title >
                        <div class="card-body bg-gradient bg-light">
                            <h4 class="card-title"> {{ title }} </h4>
                            <p class="card-text"> {{ text }} </p>
                            <p class="card-text"> Кол-во: {{ quantity }} </p>
                        </div>
                        <div class="card-footer bg-warning">
                            <span class="text-light text-black"> Цена: {{price}} руб. </span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="d-flex flex-wrap">
        <div v-for="product in myProducts" class="card m-2" style="width: 200px;">
            <img :src=cruth(product.image)  class="card-img-top img-fluid img-thumbnail" :title=product.title >
                <div class="card-body bg-gradient bg-light">
                    <h4 class="card-title"> {{ product.title }} </h4>
                    <hr>
                    <p class="card-text"> {{ product.text }} </p>
                    <p class="card-text"> Кол-во: {{ product.quantity }} </p>
                </div>
                <div class="card-footer bg-warning d-flex flex-column justify-content-between">
                    <div class="text-light text-black"> Цена: {{ product.price }} руб. </div>
                    <button disabled class="btn btn-sm btn-primary"> купить </button>
                </div>
            </div>
        </div>
        </div>

</div>


