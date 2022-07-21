<?php

use yii\db\Schema;
use yii\db\Migration;

class m220721_071045_paiwise_checkout extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable('{{%paiwise_checkout}}',[
            'id'=> $this->primaryKey(11),
            'model'=> $this->string(512)->notNull(),
            'model_id'=> $this->integer(11)->notNull(),
            'amount'=> $this->decimal(11, 2)->notNull(),
            'checkout_id'=> $this->string(45)->notNull(),
            'status'=> "enum('created', 'reserved', 'reserve released', 'paid', 'refunded', 'revoked') NOT NULL DEFAULT 'created'",
            'status_changed'=> $this->integer(11)->null()->defaultValue(null),
            'checkout_data'=> $this->text()->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

    }

    public function safeDown()
    {
            $this->dropTable('{{%paiwise_checkout}}');
    }
}
