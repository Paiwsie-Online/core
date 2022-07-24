<?php

use yii\db\Schema;
use yii\db\Migration;

class m220724_092508_address extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable('{{%address}}',[
            'id'=> $this->primaryKey(11),
            'address'=> $this->text()->notNull(),
            'zip_code'=> $this->bigInteger(20)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->null()->defaultValue(null),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('zip_code','{{%address}}',['zip_code','created_by','updated_by'],false);
        $this->createIndex('created_by','{{%address}}',['created_by'],false);
        $this->createIndex('updated_by','{{%address}}',['updated_by'],false);
        $this->addForeignKey(
            'fk_address_created_by',
            '{{%address}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_address_updated_by',
            '{{%address}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_address_zip_code',
            '{{%address}}', 'zip_code',
            '{{%enumeration}}', 'id',
            'RESTRICT', 'CASCADE'
        );
    }

    public function safeDown()
    {
            $this->dropForeignKey('fk_address_created_by', '{{%address}}');
            $this->dropForeignKey('fk_address_updated_by', '{{%address}}');
            $this->dropForeignKey('fk_address_zip_code', '{{%address}}');
            $this->dropTable('{{%address}}');
    }
}
