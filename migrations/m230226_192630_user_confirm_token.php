<?php

use yii\db\Migration;

/**
 * Class m230226_192630_user_confirm_token
 */
class m230226_192630_user_confirm_token extends Migration
{
    private $table = 'user_confirm_token';
    private $users = 'users';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => 'pk',
            'code' => 'VARCHAR(32) NOT NULL',
            'user_id' => 'INT NOT NULL',
            'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'expires' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);

        $this->createIndex('idx_code', $this->table, ['code']);

        $this->alterColumn($this->users, 'status', "ENUM('new', 'active', 'blocked', 'deleted')");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
        $this->alterColumn($this->users, 'status', "ENUM('active', 'blocked', 'deleted')");
        echo "m230226_192630_user_confirm_token cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230226_192630_user_confirm_token cannot be reverted.\n";

        return false;
    }
    */
}
