<?php

use yii\db\Migration;

class m220714_110634_language_force_translation extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable('{{%language_force_translation}}',[
            'value'=> $this->text()->notNull(),
        ], $tableOptions);

        $this->createIndex('value','{{%language_force_translation}}',['value'],true);
    }

    public function safeDown()
    {
            $this->dropTable('{{%language_force_translation}}');
    }
}
