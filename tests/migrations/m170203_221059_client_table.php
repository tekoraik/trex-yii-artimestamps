<?php

use yii\db\Migration;

class m170203_221059_client_table extends Migration
{
    public function up()
    {
        $this->createTable('client', [
            'id' => 'pk',
            'name' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ]);
    }

    public function down()
    {
        echo "m170203_221059_client_table cannot be reverted.\n";

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
