<?php

use yii\db\Schema;
use yii\db\Migration;

class m220723_180406_Notifications extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable('{{%notification}}',[
            'id'=> $this->bigPrimaryKey(20),
            'category'=> "enum('alert', 'message') NOT NULL",
            'priority'=> "enum('low', 'medium', 'high') NOT NULL DEFAULT 'low'",
            'notification_data'=> $this->text()->notNull(),
            'status'=> "enum('unread', 'seen', 'clicked', 'deleted') NOT NULL DEFAULT 'unread'",
            'status_changed'=> $this->integer(11)->null()->defaultValue(null),
            'status_changed_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('status_changed_by','{{%notification}}',['status_changed_by'],false);

        $this->createTable('{{%user_notification_relation}}',[
            'notification_id'=> $this->bigInteger(20)->notNull(),
            'user_id'=> $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('user_id','{{%user_notification_relation}}',['user_id'],false);
        $this->addPrimaryKey('pk_on_user_notification_relation','{{%user_notification_relation}}',['notification_id','user_id']);
        $this->addForeignKey(
            'fk_notification_status_changed_by',
            '{{%notification}}', 'status_changed_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_user_notification_relation_notification_id',
            '{{%user_notification_relation}}', 'notification_id',
            '{{%notification}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_user_notification_relation_user_id',
            '{{%user_notification_relation}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    public function safeDown()
    {
            $this->dropForeignKey('fk_notification_status_changed_by', '{{%notification}}');
            $this->dropForeignKey('fk_user_notification_relation_notification_id', '{{%user_notification_relation}}');
            $this->dropForeignKey('fk_user_notification_relation_user_id', '{{%user_notification_relation}}');
            $this->dropTable('{{%notification}}');
            $this->dropPrimaryKey('pk_on_user_notification_relation','{{%user_notification_relation}}');
            $this->dropTable('{{%user_notification_relation}}');
    }
}
