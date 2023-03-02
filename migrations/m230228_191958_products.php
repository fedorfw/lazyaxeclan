<?php

use yii\db\Migration;

/**
 * Class m230228_191958_products
 */
class m230228_191958_products extends Migration
{
    private $table = 'products';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => 'pk',
            'title' => 'VARCHAR(250)',
            'text' => 'VARCHAR(250)',
            'image' => 'VARCHAR(100)',
            'tag' => 'VARCHAR(50)',
            'price' => 'DECIMAL(16,2)',
            'quantity' => 'INT',
            'owner_user_id' => 'INT',
            'status' => "ENUM('draft', 'published', 'canceled', 'sold')",
            'created' => 'datetime DEFAULT NOW()',
            'modified' => 'datetime ON UPDATE NOW()',
        ]);

        $this->createIndex('idx_title', $this->table, ['title']);
        $this->createIndex('idx_tag', $this->table, ['tag']);
        $this->createIndex('idx_owner_user_id', $this->table, ['owner_user_id']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
        echo "m230228_191958_products cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230228_191958_products cannot be reverted.\n";

        return false;
    }
    */
}
