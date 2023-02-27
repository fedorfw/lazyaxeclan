<?php

namespace app\models;

use users\Domain\Interfaces\UserRepositoryInterface;
use Yii;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $email;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $userDB = Yii::$container->get(UserRepositoryInterface::class)->findUser($id);
        if (!$userDB) {
            return null;
        }
        return new static([
            'id' => $userDB->getId(),
            'email' => $userDB->getEmail(),
            'password' => $userDB->getPass(),
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    public static function findByEmail($email)
    {
        $userDB = Yii::$container->get(UserRepositoryInterface::class)->findUserByEmail($email);
        if (!$userDB) {
            return null;
        }

        if (!$userDB->getStatus()->isActive()) {
            return null;
        }

        return new static([
            'id' => $userDB->getId(),
            'email' => $userDB->getEmail(),
            'password' => $userDB->getPass(),
            // TODO: keys
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
}
