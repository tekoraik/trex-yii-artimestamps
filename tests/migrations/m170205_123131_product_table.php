<?php

use yii\db\Migration;

class m170205_123131_product_table extends Migration
{
    public function up()
    {
        $this->createTable('product', [
            'id' => 'pk',
            'name' => 'string',
            'createdAt' => 'string',
            'updatedAt' => 'string'
        ]);
    }

    public function down()
    {
        echo "m170205_123131_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
