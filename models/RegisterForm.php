<?php

namespace app\models;

use yii\base\Model;

class RegisterForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'length' => [6,50]]
        ];
    }

    public function validatePassword($attribute, $param)
    {
        if (mb_strlen($this->password) <= 5 ){
            $this->addError('password', 'Пароль должен быть не короче 6 символов');
            return;
        }
    }
}
