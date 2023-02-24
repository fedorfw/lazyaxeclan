<?php

/** @var yii\web\View $this */

$this->title = 'Клан Ленивого Топора';
$js = <<<JS
var index = new Vue({
  el: '#index',
  data: {
    messageTelegram: '',
    numbers: [1,3,4,6],
    user: Object,
    data: null,
    testResp: null,
    addNewUser: false,
    showEditUser: false,
    name: '',
    email: '',
    phone: '',
    test: 'test'
  },
  methods: {
      setFfw(){
          this.user = $.getJSON({
            url: 'users/user/list'
          }).done(function (data){
          });
          setTimeout(this.updateUser, 1000)
      },
      updateUser(a) {
          this.testResp = this.user.responseJSON.data
      },
      sendMessageToTelegram() {
            $.post({
            url: '/web/telegrams/telegram/send',
            data: {telegramMessage: this.messageTelegram}
            });
            this.messageTelegram = '' 
      },
      onShowAddUserButton() {
          this.addNewUser = true;
      },
      onCancelAddUserButton() {
          this.addNewUser = false;
      },
      onAddUserButton() {
          if (this.canAddNewUser) {
              this.user = {
                  'name': this.name,
                  'email': this.email,
                  'phone': this.phone
              };
              var resp = $.post({
                url: '/web/users/user/add-user',
                data: {userData: this.user},
                dataType: 'json',
                    success: function (data) {
                    location.reload();
                    }
                })
           }
      },
      onEditUserButton(item) {
          this.showEditUser = true;
          this.test = item;
      },
      onConfirmEditUserButton() {
        var resp = $.post({
                url: '/web/users/user/update-user',
                data: {updatedUserData: this.test},
                dataType: 'json',
                success: function (data) {
                    location.reload();
                }
        })
      },
      onDeleteUserButton(item) {
          this.test = item;
      },
      onConfirmedDeleteUserButton() {
           var resp = $.get({
                url: '/web/users/user/delete-user',
                data: {userData: this.test.id},
                success: function (data) {
                    location.reload();
                }
           })
      }
    
  },
     computed: {
       canAddNewUser: function () {
           if (this.name !== '' && this.email !== '' && this.phone !== '') {
               return true
           }
           return false
      }
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
    <div  class="row g-2" >
        <h3>Отправить сообщение </h3>
        <label>на тестовый телеграм канал @lazyAxeClan
            <textarea rows="3" v-model="messageTelegram" class="form-control"   style="resize: none"></textarea>
            <button @click.prevent="sendMessageToTelegram" type="submit" class="btn btn-primary mt-1">Отправить</button>
        </label>
    </div>

    <br>
    <div v-if="user">
        <hr>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th class="col-1" scope="col">#</th>
                    <th class="col-3" scope="col">Name</th>
                    <th class="col-3" scope="col">Email</th>
                    <th class="col-4" scope="col">Phone</th>
                    <th class="col-1" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item, index in testResp" :key="index" >
                    <th scope="row">{{ index+1 }}</th>
                    <td>{{ item.name }} </td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.phone }}</td>
                    <td>
                        <button @click="onEditUserButton(item)"  data-bs-toggle="modal" data-bs-target="#editUser" class="btn btn-success btn-sm" title="Редактировать"><span class="mdi mdi-account-edit"></span></button>
                        <button @click="onDeleteUserButton(item)" data-bs-toggle="modal" data-bs-target="#deleteUser" class="btn btn-danger btn-sm ms-1" title="Удалить"><span class="mdi mdi-delete"></span></button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th><input v-if="addNewUser" v-model.trim="name" type="text" placeholder="имя" /></th>
                    <th><input v-if="addNewUser" v-model.trim="email" type="text" placeholder="почта" /></th>
                    <th><input v-if="addNewUser" v-model.trim="phone" type="text" placeholder="телефон" /></th>
                    <th class="text-end">
                        <button v-if="addNewUser" :disabled="!canAddNewUser" @click="onAddUserButton" title="Добавить пользователя"  class="btn btn-primary btn-sm ms-1"><span class="mdi mdi-plus"></span></button>
                        <button v-if="!addNewUser" @click="onShowAddUserButton" title="Добавить пользователя" class="btn btn-success btn-sm ms-1"><span class="mdi mdi-plus"></span></button>
                        <button v-if="addNewUser" @click="onCancelAddUserButton" title="Отмена" class="btn btn-success btn-sm ms-1"><span class="mdi mdi-cancel"></span></button>
                    </th>
                </tr>
            </tfoot>
        </table>

<!-- edit user popup -->
        <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Изменить данные пользователя</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-primary" role="alert">
                            Внимание !
                        </div>
                        <span>Имя</span>
                        <input class="form-control mt-1" v-model.trim="test.name" type="text" placeholder="имя" />
                        <span>Почта</span>
                        <input class="form-control mt-1" v-model.trim="test.email" type="text" placeholder="почта" />
                        <span>Телефон</span>
                        <input class="form-control mt-1" v-model.trim="test.phone" type="text" placeholder="телефон" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button @click="onConfirmEditUserButton" data-bs-dismiss="modal" type="button" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </div>
            </div>
        </div>
<!-- confirm delete user popup' -->
        <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Удалить пользователя</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert">
                            Внимание это действие удалит текущего пользователя !
                        </div>
                        <span>Имя</span>
                        <input disabled class="form-control mt-1" v-model.trim="test.name" type="text" placeholder="имя" />
                        <span>Почта</span>
                        <input disabled class="form-control mt-1" v-model.trim="test.email" type="text" placeholder="почта" />
                        <span>Телефон</span>
                        <input disabled class="form-control mt-1" v-model.trim="test.phone" type="text" placeholder="телефон" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button @click="onConfirmedDeleteUserButton"  type="button" class="btn btn-danger">Удалить</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


