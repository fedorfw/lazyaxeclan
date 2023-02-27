<?php

use yii\db\Migration;

/**
 * Class m230226_155632_craete_user_token
 */
class m230226_155632_craete_user_token extends Migration
{
    private $table = 'user_token';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => 'pk',
            'user_id' => 'INT',
            'token' => 'VARCHAR(50)',
        ]);

        $this->createIndex('idx_token', $this->table, ['token']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
        echo "m230226_155632_craete_user_token cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230226_155632_craete_user_token cannot be reverted.\n";

        return false;
    }
    */
}
