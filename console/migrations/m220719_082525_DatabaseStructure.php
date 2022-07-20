<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
class m220719_082525_DatabaseStructure extends \yii\db\Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable('{{%api_key}}',[
            'id'=> $this->primaryKey(11),
            'key_type'=> "enum('organization', 'instance', 'system') NOT NULL",
            'key'=> $this->string(128)->notNull(),
            'instance'=> $this->string(64)->null()->defaultValue(null),
            'organization_id'=> $this->integer(11)->null()->defaultValue(null),
            'key_config'=> $this->text()->null()->defaultValue(null),
            'expiry_date'=> $this->date()->null()->defaultValue(null),
            'status'=> "enum('active', 'blocked', 'expired', 'deleted') NOT NULL DEFAULT 'active'",
            'type'=> "enum('live', 'test') NOT NULL",
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('fk_organizationid_table_organization_id','{{%api_key}}',['organization_id'],false);
        $this->createIndex('fk_createdby_table_user_id','{{%api_key}}',['created_by'],false);
        $this->createIndex('fk_updatedby_table_user_id','{{%api_key}}',['updated_by'],false);

        $this->createTable('{{%cronjob}}',[
            'id'=> $this->string(128)->notNull(),
            'name'=> $this->string(128)->notNull(),
            'description'=> $this->text()->notNull(),
            'url'=> $this->string(512)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_cronjob','{{%cronjob}}',['id']);

        $this->createTable('{{%cronjob_log}}',[
            'id'=> $this->primaryKey(11),
            'cronjob_id'=> $this->string(128)->notNull(),
            'started'=> $this->integer(11)->notNull(),
            'ended'=> $this->integer(11)->notNull(),
            'data'=> $this->text()->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('cronjob','{{%cronjob_log}}',['cronjob_id'],false);

        $this->createTable('{{%enumeration}}',[
            'id'=> $this->bigPrimaryKey(20),
            'parent'=> $this->bigInteger(20)->null()->defaultValue(null),
            'enumerator'=> $this->string(128)->null()->defaultValue(null),
            'value'=> $this->text()->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('parent','{{%enumeration}}',['parent'],false);

        $this->createTable('{{%file}}',[
            'id'=> $this->primaryKey(11),
            'uri'=> $this->string(512)->notNull(),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('file_ibfk_1','{{%file}}',['created_by'],false);

        $this->createTable('{{%graphdata}}',[
            'id'=> $this->bigPrimaryKey(20),
            'model'=> $this->string(512)->notNull(),
            'model_id'=> $this->integer(11)->notNull(),
            'property'=> $this->string(128)->notNull(),
            'value'=> $this->text()->null()->defaultValue(null),
            'unit'=> $this->string(128)->null()->defaultValue(null),
            'created_by'=> $this->integer(11)->null(),
            'created_at'=> $this->integer(11)->null(),
            'updated_by'=> $this->integer(11)->null(),
            'updated_at'=> $this->integer(11)->null(),
        ], $tableOptions);

        $this->createTable('{{%language}}',[
            'language_id'=> $this->string(5)->notNull(),
            'language'=> $this->string(3)->notNull(),
            'country'=> $this->string(3)->notNull(),
            'name'=> $this->string(32)->notNull(),
            'name_ascii'=> $this->string(32)->notNull(),
            'status'=> $this->smallInteger(6)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_language','{{%language}}',['language_id']);

        $this->createTable('{{%language_force_translation}}',[
            'value'=> $this->text()->notNull(),
        ], $tableOptions);

        //$this->createIndex('value','{{%language_force_translation}}',['value'],true);

        $this->createTable('{{%language_source}}',[
            'id'=> $this->primaryKey(11),
            'category'=> $this->string(32)->null()->defaultValue(null),
            'message'=> $this->text()->null()->defaultValue(null),
        ], $tableOptions);


        $this->createTable('{{%language_translate}}',[
            'id'=> $this->integer(11)->notNull(),
            'language'=> $this->string(5)->notNull(),
            'translation'=> $this->text()->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('language_translate_idx_language','{{%language_translate}}',['language'],false);
        $this->addPrimaryKey('pk_on_language_translate','{{%language_translate}}',['id','language']);

        $this->createTable('{{%module}}',[
            'id'=> $this->string(50)->notNull(),
            'name'=> $this->string(128)->notNull(),
            'description'=> $this->text()->null()->defaultValue(null),
            'additional_data'=> $this->text()->null()->defaultValue(null),
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_module','{{%module}}',['id']);

        $this->createTable('{{%objects}}',[
            'id'=> $this->bigPrimaryKey(20),
            'model'=> $this->string(512)->notNull(),
        ], $tableOptions);

        $this->createTable('{{%object_attachment}}',[
            'id'=> $this->primaryKey(11),
            'model'=> $this->string(512)->notNull(),
            'model_id'=> $this->integer(11)->notNull(),
            'object'=> $this->bigInteger(20)->notNull(),
        ], $tableOptions);

        $this->createTable('{{%object_detail}}',[
            'object'=> $this->bigInteger(20)->notNull(),
            'detail'=> $this->string(512)->notNull(),
            'value'=> $this->text()->null()->defaultValue(null)
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_object_detail','{{%object_detail}}',['object','detail']);

        $this->createTable('{{%object_log}}',[
            'id'=> $this->primaryKey(11),
            'object'=> $this->bigInteger(20)->notNull(),
            'data'=> $this->string(128)->notNull(),
            'value'=> $this->text()->null()->defaultValue(null),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createTable('{{%object_participant}}',[
            'id'=> $this->primaryKey(11),
            'model'=> $this->string(512)->notNull(),
            'model_id'=> $this->integer(11)->notNull(),
            'object'=> $this->bigInteger(20)->notNull(),
            'level'=> $this->bigInteger(20)->notNull(),
        ], $tableOptions);

        $this->createTable('{{%organization}}',[
            'id'=> $this->primaryKey(11),
            'name'=> $this->string(256)->notNull(),
            'tax_number'=> $this->string(64)->null()->defaultValue(null),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'instance'=> $this->string(128)->null()->defaultValue(null),
            'kyc'=> "enum('none', 'inProgress', 'pending', 'approved', 'denied', 'awaitingMoreInfo') NOT NULL DEFAULT 'none'",
            'kyc_status_changed'=> $this->integer(11)->null()->defaultValue(null),
            'legal_name'=> $this->string(256)->null()->defaultValue(null),
            'model' => $this->string(512)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('created_by','{{%organization}}',['created_by'],false);

        $this->createTable('{{%organization_api_key}}',[
            'id'=> $this->primaryKey(11),
            'key_id'=> $this->integer(11)->notNull(),
            'cmr_id'=> $this->bigInteger(20)->notNull(),
            'right_create'=> $this->tinyInteger(4)->notNull(),
            'right_read'=> $this->tinyInteger(4)->notNull(),
            'right_update'=> $this->tinyInteger(4)->notNull(),
            'right_delete'=> $this->tinyInteger(4)->notNull(),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('fk_cmrid_table_organization_module_relation_id','{{%organization_api_key}}',['cmr_id'],false);
        $this->createIndex('fk_keyid_table_api_key_id','{{%organization_api_key}}',['key_id'],false);
        $this->createIndex('fk_createdby_table_user_id','{{%organization_api_key}}',['created_by'],false);
        $this->createIndex('fk_updatedby_table_user_id','{{%organization_api_key}}',['updated_by'],false);

        $this->createTable('{{%organization_organization_group_right}}',[
            'id'=> $this->primaryKey(11),
            'group_id'=> $this->integer(11)->notNull(),
            'cc_relation_id'=> $this->integer(11)->notNull(),
            'right_create'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'right_read'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'right_update'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'right_delete'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'right_grant'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('group_id','{{%organization_organization_group_right}}',['group_id','cc_relation_id','created_by'],false);
        $this->createIndex('cc_relation_id','{{%organization_organization_group_right}}',['cc_relation_id'],false);
        $this->createIndex('created_by','{{%organization_organization_group_right}}',['created_by'],false);
        $this->createIndex('updated_by','{{%organization_organization_group_right}}',['updated_by'],false);

        $this->createTable('{{%organization_organization_relation}}',[
            'id'=> $this->primaryKey(11),
            'parent_organization'=> $this->integer(11)->notNull(),
            'child_organization'=> $this->integer(11)->notNull(),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('parent_organization','{{%organization_organization_relation}}',['parent_organization','child_organization','created_by'],false);
        $this->createIndex('child_organization','{{%organization_organization_relation}}',['child_organization'],false);
        $this->createIndex('created_by','{{%organization_organization_relation}}',['created_by'],false);
        $this->createIndex('updated_by','{{%organization_organization_relation}}',['updated_by'],false);

        $this->createTable('{{%organization_organization_user_right}}',[
            'id'=> $this->primaryKey(11),
            'cc_relation_id'=> $this->integer(11)->notNull(),
            'user_id'=> $this->integer(11)->notNull(),
            'right_create'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'right_read'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'right_update'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'right_delete'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'right_grant'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('cc_relation_id','{{%organization_organization_user_right}}',['cc_relation_id','user_id','created_by'],false);
        $this->createIndex('user_id','{{%organization_organization_user_right}}',['user_id'],false);
        $this->createIndex('created_by','{{%organization_organization_user_right}}',['created_by'],false);
        $this->createIndex('updated_by','{{%organization_organization_user_right}}',['updated_by'],false);

        $this->createTable('{{%organization_detail}}',[
            'organization_id'=> $this->integer(11)->notNull(),
            'detail'=> $this->string(128)->notNull(),
            'value'=> $this->text()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_organization_detail','{{%organization_detail}}',['organization_id','detail']);

        $this->createTable('{{%organization_group_module_right}}',[
            'id'=> $this->primaryKey(11),
            'group_id'=> $this->integer(11)->notNull(),
            'cmr_id'=> $this->bigInteger(20)->notNull(),
            'right_create'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'right_read'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'right_update'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'right_delete'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('group_id','{{%organization_group_module_right}}',['group_id'],false);
        $this->createIndex('created_by','{{%organization_group_module_right}}',['created_by'],false);
        $this->createIndex('updated_by','{{%organization_group_module_right}}',['updated_by'],false);
        $this->createIndex('cmr_id','{{%organization_group_module_right}}',['cmr_id'],false);

        $this->createTable('{{%organization_module_relation}}',[
            'id'=> $this->bigPrimaryKey(20),
            'organization_id'=> $this->integer(11)->notNull(),
            'module_id'=> $this->string(50)->notNull(),
        ], $tableOptions);

        $this->createIndex('organization_id','{{%organization_module_relation}}',['organization_id','module_id'],false);
        $this->createIndex('module_id','{{%organization_module_relation}}',['module_id'],false);

        $this->createTable('{{%organization_setting}}',[
            'organization_id'=> $this->integer(11)->notNull(),
            'setting'=> $this->string(128)->notNull(),
            'value'=> $this->text()->null()->defaultValue(null),
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_organization_setting','{{%organization_setting}}',['organization_id','setting']);

        $this->createTable('{{%organization_user_module_right}}',[
            'id'=> $this->primaryKey(11),
            'ou_relation_id'=> $this->integer(11)->notNull(),
            'cmr_id'=> $this->bigInteger(20)->notNull(),
            'right_create'=> $this->tinyInteger(1)->notNull()->defaultValue(2),
            'right_read'=> $this->tinyInteger(1)->notNull()->defaultValue(2),
            'right_update'=> $this->tinyInteger(1)->notNull()->defaultValue(2),
            'right_delete'=> $this->tinyInteger(1)->notNull()->defaultValue(2),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('organization_id','{{%organization_user_module_right}}',['ou_relation_id'],false);
        $this->createIndex('created_by','{{%organization_user_module_right}}',['created_by'],false);
        $this->createIndex('updated_by','{{%organization_user_module_right}}',['updated_by'],false);
        $this->createIndex('cmr_id','{{%organization_user_module_right}}',['cmr_id'],false);

        $this->createTable('{{%organization_user_relation}}',[
            'id'=> $this->primaryKey(11),
            'organization_id'=> $this->integer(11)->notNull(),
            'user_id'=> $this->integer(11)->null()->defaultValue(null),
            'title'=> $this->string(128)->null()->defaultValue(null),
            'user_level'=> "enum('owner', 'admin', 'user') NOT NULL DEFAULT 'user'",
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
            'status'=> "enum('pending', 'accepted', 'declined') NOT NULL DEFAULT 'pending'",
            'status_changed'=> $this->integer(11)->null()->defaultValue(null),
            'selected_organization'=> $this->tinyInteger(3)->null()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('organization_id','{{%organization_user_relation}}',['organization_id','user_id','created_by'],false);
        $this->createIndex('user_id','{{%organization_user_relation}}',['user_id'],false);
        $this->createIndex('created_by','{{%organization_user_relation}}',['created_by'],false);
        $this->createIndex('updated_by','{{%organization_user_relation}}',['updated_by'],false);

        $this->createTable('{{%organization_user_relation_invitation}}',[
            'id'=> $this->primaryKey(11),
            'sent_via'=> "enum('email', 'sms') NULL DEFAULT NULL",
            'sent_to'=> $this->string(256)->null()->defaultValue(null),
            'cid'=> $this->string(45)->null()->defaultValue(null),
            'our_id'=> $this->integer(11)->null()->defaultValue(null),
            'invite_params'=> $this->text()->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('our_id','{{%organization_user_relation_invitation}}',['our_id'],false);

        $this->createTable('{{%organization_usergroup}}',[
            'id'=> $this->primaryKey(11),
            'organization_id'=> $this->integer(11)->notNull(),
            'name'=> $this->string(128)->notNull(),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('organization_id','{{%organization_usergroup}}',['organization_id','created_by'],false);
        $this->createIndex('created_by','{{%organization_usergroup}}',['created_by'],false);
        $this->createIndex('updated_by','{{%organization_usergroup}}',['updated_by'],false);

        $this->createTable('{{%organization_usergroup_user_relation}}',[
            'id'=> $this->primaryKey(11),
            'ou_relation_id'=> $this->integer(11)->notNull(),
            'group_id'=> $this->integer(11)->notNull(),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('ou_relation_id','{{%organization_usergroup_user_relation}}',['ou_relation_id','group_id','created_by'],false);
        $this->createIndex('group_id','{{%organization_usergroup_user_relation}}',['group_id'],false);
        $this->createIndex('created_by','{{%organization_usergroup_user_relation}}',['created_by'],false);
        $this->createIndex('updated_by','{{%organization_usergroup_user_relation}}',['updated_by'],false);

        $this->createTable('{{%picture}}',[
            'id'=> $this->primaryKey(11),
            'uri'=> $this->string(512)->notNull(),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('created_by','{{%picture}}',['created_by'],false);

        $this->createTable('{{%siteadmin_api_key}}',[
            'id'=> $this->primaryKey(11),
            'key_id'=> $this->integer(11)->notNull(),
            'module_id'=> $this->string(50)->notNull(),
            'right_create'=> $this->tinyInteger(4)->notNull(),
            'right_read'=> $this->tinyInteger(4)->notNull(),
            'right_update'=> $this->tinyInteger(4)->notNull(),
            'right_delete'=> $this->tinyInteger(4)->notNull(),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('fk_siteadmin_api_key_key_id','{{%siteadmin_api_key}}',['key_id'],false);
        $this->createIndex('fk_siteadmin_api_key_module_id','{{%siteadmin_api_key}}',['module_id'],false);
        $this->createIndex('fk_siteadmin_api_key_created_by','{{%siteadmin_api_key}}',['created_by'],false);
        $this->createIndex('fk_siteadmin_api_key_updated_by','{{%siteadmin_api_key}}',['updated_by'],false);

        $this->createTable('{{%system_content}}',[
            'instance'=> $this->string(128)->notNull(),
            'content'=> $this->string(128)->notNull(),
            'value'=> $this->text()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_system_content','{{%system_content}}',['instance','content']);

        $this->createTable('{{%system_log}}',[
            'id'=> $this->primaryKey(11),
            'user_id'=> $this->integer(11)->null()->defaultValue(null),
            'organization_id'=> $this->integer(11)->null()->defaultValue(null),
            'instance'=> $this->string(128)->null()->defaultValue(null),
            'message_short'=> $this->string(512)->null()->defaultValue(null),
            'message'=> $this->text()->null()->defaultValue(null),
            'data_format'=> $this->text()->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('user_id','{{%system_log}}',['user_id','organization_id'],false);
        $this->createIndex('organization_id','{{%system_log}}',['organization_id'],false);
        $this->createIndex('created_by','{{%system_log}}',['created_by'],false);

        $this->createTable('{{%system_setting}}',[
            'id'=> $this->primaryKey(11),
            'setting'=> $this->string(128)->notNull(),
            'value'=> $this->text()->notNull(),
        ], $tableOptions);


        $this->createTable('{{%systemadmin_api_key}}',[
            'id'=> $this->primaryKey(11),
            'key_id'=> $this->integer(11)->notNull(),
            'module_id'=> $this->string(50)->notNull(),
            'right_create'=> $this->tinyInteger(4)->notNull(),
            'right_read'=> $this->tinyInteger(4)->notNull(),
            'right_update'=> $this->tinyInteger(4)->notNull(),
            'right_delete'=> $this->tinyInteger(4)->notNull(),
            'created_at'=> $this->integer(11)->notNull(),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'updated_at'=> $this->integer(11)->null()->defaultValue(null),
            'updated_by'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('fk_systemadmin_api_key_key_id','{{%systemadmin_api_key}}',['key_id'],false);
        $this->createIndex('fk_systemadmin_api_key_module_id','{{%systemadmin_api_key}}',['module_id'],false);
        $this->createIndex('fk_systemadmin_api_key_created_by','{{%systemadmin_api_key}}',['created_by'],false);
        $this->createIndex('fk_systemadmin_api_key_updated_by','{{%systemadmin_api_key}}',['updated_by'],false);

        $this->createTable('{{%user}}',[
            'id'=> $this->primaryKey(11),
            'first_name'=> $this->string(128)->null()->defaultValue(null),
            'last_name'=> $this->string(128)->null()->defaultValue(null),
            'country'=> $this->string(16)->null()->defaultValue(null),
            'pnr'=> $this->string(64)->null()->defaultValue(null),
            'email'=> $this->string(256)->null()->defaultValue(null),
            'email_status'=> "enum('unverified', 'verified') NULL DEFAULT NULL",
            'password'=> $this->string(512)->null()->defaultValue(null),
            'cid'=> $this->string(45)->notNull(),
            'status'=> "enum('registered', 'verified', 'blocked', '') NOT NULL DEFAULT 'registered'",
            'registered'=> $this->integer(11)->notNull(),
            'auth_key'=> $this->string(128)->notNull(),
            'access_token'=> $this->string(128)->notNull(),
            'instance'=> $this->string(128)->null()->defaultValue(null),
            'phone'=> $this->string(64)->null()->defaultValue(null),
            'phone_status'=> "enum('unverified', 'verified') NULL DEFAULT NULL",
        ], $tableOptions);


        $this->createTable('{{%user_login}}',[
            'id'=> $this->primaryKey(11),
            'user_id'=> $this->integer(11)->notNull(),
            'ip'=> $this->string(64)->null()->defaultValue(null),
            'logged'=> $this->integer(11)->notNull(),
            'expire'=> $this->integer(11)->null()->defaultValue(null),
            'session_id'=> $this->string(64)->null()->defaultValue(null),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->null()->defaultValue(null),
        ], $tableOptions);

        $this->createIndex('user_id','{{%user_login}}',['user_id'],false);
        $this->createIndex('created_by','{{%user_login}}',['created_by'],false);

        $this->createTable('{{%user_session}}',[
            'loginID'=> $this->primaryKey(11),
            'sessionID'=> $this->string(255)->notNull(),
            'uID'=> $this->integer(11)->notNull(),
            'created_by'=> $this->integer(11)->null()->defaultValue(null),
            'created_at'=> $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('uID','{{%user_session}}',['uID'],false);
        $this->createIndex('created_by','{{%user_session}}',['created_by'],false);

        $this->createTable('{{%user_detail}}',[
            'user_id'=> $this->integer(11)->notNull(),
            'detail'=> $this->string(128)->notNull(),
            'value'=> $this->text()->null()->defaultValue(null),
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_user_detail','{{%user_detail}}',['user_id','detail']);

        $this->createTable('{{%user_setting}}',[
            'user_id'=> $this->integer(11)->notNull(),
            'setting'=> $this->string(128)->notNull(),
            'value'=> $this->text()->null()->defaultValue(null),
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_user_setting','{{%user_setting}}',['user_id','setting']);

        // Start foreign key
        $this->addForeignKey(
            'fk_api_key_organization_id',
            '{{%api_key}}', 'organization_id',
            '{{%organization}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_api_key_created_by',
            '{{%api_key}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_api_key_updated_by',
            '{{%api_key}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_created_by',
            '{{%organization}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_api_key_cmr_id',
            '{{%organization_api_key}}', 'cmr_id',
            '{{%organization_module_relation}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_api_key_key_id',
            '{{%organization_api_key}}', 'key_id',
            '{{%api_key}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_api_key_created_by',
            '{{%organization_api_key}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_api_key_updated_by',
            '{{%organization_api_key}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_group_right_cc_relation_id',
            '{{%organization_organization_group_right}}', 'cc_relation_id',
            '{{%organization_organization_relation}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_group_right_group_id',
            '{{%organization_organization_group_right}}', 'group_id',
            '{{%organization_usergroup}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_group_right_created_by',
            '{{%organization_organization_group_right}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_group_right_updated_by',
            '{{%organization_organization_group_right}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_relation_created_by',
            '{{%organization_organization_relation}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_relation_updated_by',
            '{{%organization_organization_relation}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_relation_child_organization',
            '{{%organization_organization_relation}}', 'child_organization',
            '{{%organization}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_relation_parent_organization',
            '{{%organization_organization_relation}}', 'parent_organization',
            '{{%organization}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_user_right_cc_relation_id',
            '{{%organization_organization_user_right}}', 'cc_relation_id',
            '{{%organization_organization_relation}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_user_right_created_by',
            '{{%organization_organization_user_right}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_user_right_updated_by',
            '{{%organization_organization_user_right}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_organization_user_right_user_id',
            '{{%organization_organization_user_right}}', 'user_id',
            '{{%organization_user_relation}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_detail_organization_id',
            '{{%organization_detail}}', 'organization_id',
            '{{%organization}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_group_module_right_cmr_id',
            '{{%organization_group_module_right}}', 'cmr_id',
            '{{%organization_module_relation}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_group_module_right_group_id',
            '{{%organization_group_module_right}}', 'group_id',
            '{{%organization_usergroup}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_group_module_right_created_by',
            '{{%organization_group_module_right}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_group_module_right_updated_by',
            '{{%organization_group_module_right}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_module_relation_organization_id',
            '{{%organization_module_relation}}', 'organization_id',
            '{{%organization}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_module_relation_module_id',
            '{{%organization_module_relation}}', 'module_id',
            '{{%module}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_setting_organization_id',
            '{{%organization_setting}}', 'organization_id',
            '{{%organization}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_user_module_right_cmr_id',
            '{{%organization_user_module_right}}', 'cmr_id',
            '{{%organization_module_relation}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_user_module_right_ou_relation_id',
            '{{%organization_user_module_right}}', 'ou_relation_id',
            '{{%organization_user_relation}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_user_module_right_created_by',
            '{{%organization_user_module_right}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_user_module_right_updated_by',
            '{{%organization_user_module_right}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_user_relation_created_by',
            '{{%organization_user_relation}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_user_relation_updated_by',
            '{{%organization_user_relation}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_user_relation_organization_id',
            '{{%organization_user_relation}}', 'organization_id',
            '{{%organization}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_user_relation_user_id',
            '{{%organization_user_relation}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_user_relation_invitation_our_id',
            '{{%organization_user_relation_invitation}}', 'our_id',
            '{{%organization_user_relation}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_usergroup_organization_id',
            '{{%organization_usergroup}}', 'organization_id',
            '{{%organization}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_usergroup_created_by',
            '{{%organization_usergroup}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_usergroup_updated_by',
            '{{%organization_usergroup}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_usergroup_user_relation_created_by',
            '{{%organization_usergroup_user_relation}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_usergroup_user_relation_updated_by',
            '{{%organization_usergroup_user_relation}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_usergroup_user_relation_ou_relation_id',
            '{{%organization_usergroup_user_relation}}', 'ou_relation_id',
            '{{%organization_user_relation}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_organization_usergroup_user_relation_group_id',
            '{{%organization_usergroup_user_relation}}', 'group_id',
            '{{%organization_usergroup}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_cronjob_log_cronjob_id',
            '{{%cronjob_log}}', 'cronjob_id',
            '{{%cronjob}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_enumeration_parent',
            '{{%enumeration}}', 'parent',
            '{{%enumeration}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_file_created_by',
            '{{%file}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_graphdata_user',
            '{{%graphdata}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_language_translate_id',
            '{{%language_translate}}', 'id',
            '{{%language_source}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_language_translate_language',
            '{{%language_translate}}', 'language',
            '{{%language}}', 'language_id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_object_attachment_objects',
            '{{%object_attachment}}', 'object',
            '{{%objects}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_object_detail_objects',
            '{{%object_detail}}', 'object',
            '{{%objects}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_object_participant_objects',
            '{{%object_participant}}', 'object',
            '{{%objects}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_object_participant_enumeration',
            '{{%object_participant}}', 'level',
            '{{%enumeration}}', 'id',
            'RESTRICT', 'RESTRICT'
        );
        $this->addForeignKey(
            'fk_object_log_objects',
            '{{%object_log}}', 'object',
            '{{%objects}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_picture_created_by',
            '{{%picture}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_siteadmin_api_key_key_id',
            '{{%siteadmin_api_key}}', 'key_id',
            '{{%api_key}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_siteadmin_api_key_module_id',
            '{{%siteadmin_api_key}}', 'module_id',
            '{{%module}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_siteadmin_api_key_created_by',
            '{{%siteadmin_api_key}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_siteadmin_api_key_updated_by',
            '{{%siteadmin_api_key}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_system_log_organization_id',
            '{{%system_log}}', 'organization_id',
            '{{%organization}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_system_log_user_id',
            '{{%system_log}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_system_log_created_by',
            '{{%system_log}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_systemadmin_api_key_key_id',
            '{{%systemadmin_api_key}}', 'key_id',
            '{{%api_key}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_systemadmin_api_key_module_id',
            '{{%systemadmin_api_key}}', 'module_id',
            '{{%module}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_systemadmin_api_key_created_by',
            '{{%systemadmin_api_key}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_systemadmin_api_key_updated_by',
            '{{%systemadmin_api_key}}', 'updated_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_user_login_user_id',
            '{{%user_login}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_user_login_created_by',
            '{{%user_login}}', 'created_by',
            '{{%user}}', 'id',
            'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_user_session_uID',
            '{{%user_session}}', 'uID',
            '{{%user}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_user_detail_user_id',
            '{{%user_detail}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk_user_setting_user_id',
            '{{%user_setting}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE', 'CASCADE'
        );

        // Data insert
        $this->batchInsert('{{%module}}',
            ["id", "name", "description"],
            [
                [
                    'id' => 'digitalAccount',
                    'name' => 'Digital Account',
                    'description' => 'Module to fascilitate digital currency accounts',
                ],
                [
                    'id' => 'helpdesk',
                    'name' => 'Helpdesk',
                    'description' => 'Module to manage support tickets',
                ],
                [
                    'id' => 'invoicing',
                    'name' => 'Invoicing',
                    'description' => 'Module to make invoicing easy',
                ],
                [
                    'id' => 'quickPayment',
                    'name' => 'Quick Payment',
                    'description' => 'Module to make sending payment requests easy',
                ],
                [
                    'id' => 'siteAdmin',
                    'name' => 'Site Admin',
                    'description' => 'site administration module to administer a certain instance',
                ],
                [
                    'id' => 'subscriptions',
                    'name' => 'Subscriptions',
                    'description' => 'Module to manage subscriptions',
                ],
                [
                    'id' => 'systemAdmin',
                    'name' => 'System Admin',
                    'description' => 'system administration module',
                ],
            ]
        );

        // Update module dependencies
        $this->update('module', ['additional_data' => '{"dependencies":["digitalAccount"]}'], ['id' => 'invoicing']);
        $this->update('module', ['additional_data' => '{"dependencies":["digitalAccount"]}'], ['id' => 'quickPayment']);
        $this->update('module', ['additional_data' => '{"dependencies":["digitalAccount"]}'], ['id' => 'subscriptions']);
        $this->update('module', ['additional_data' => '{"dependencies":["siteAdmin"]}'], ['id' => 'helpdesk']);

        $this->batchInsert('{{%module}}',
            ["id", "name", "description", "additional_data"],
            [
                [
                    'id' => 'articles',
                    'name' => 'Articles',
                    'description' => 'Module to manage articles',
                    'additional_data' => '{"dependencies":["digitalAccount"]}',
                ],
                [
                    'id' => 'checkout',
                    'name' => 'Checkout',
                    'description' => 'Module to manage checkout',
                    'additional_data' => '{"dependencies":["digitalAccount"]}',
                ],
                [
                    'id' => 'clipcards',
                    'name' => 'Clip Cards',
                    'description' => 'Module to manage clip cards',
                    'additional_data' => '{"dependencies":["articles"]}',
                ],
            ]
        );
        $this->update('module', ['additional_data' => '{"dependencies":["articles"]}'], ['id' => 'subscriptions']);

        $this->batchInsert('{{%module}}', ["id", "name", "description"], [
            [
                'id' => 'refund',
                'name' => 'Refund',
                'description' => 'Module to facilitate refunds',
            ],
        ]);

        $this->batchInsert('{{%module}}', ["id", "name", "description", "additional_data"],
            [
                [
                    'id' => 'affiliate',
                    'name' => 'Affiliate',
                    'description' => 'Module to manage affiliates',
                    'additional_data' => null,
                ],
            ]
        );

        $this->batchInsert('{{%module}}', ["id", "name", "description", "additional_data"],
            [
                [
                    'id' => 'memberships',
                    'name' => 'Memberships',
                    'description' => 'Module to manage memberships',
                    'additional_data' => '{"dependencies":["digitalAccount","frontendPage"]}',
                ],
                [
                    'id' => 'frontendPage',
                    'name' => 'Frontend Page',
                    'description' => 'Module to manage Frontend Pages',
                    'additional_data' => null,
                ],
            ]
        );

        $this->batchInsert('{{%system_setting}}',
            ["id", "setting", "value"],
            [
                [
                    'id' => '2',
                    'setting' => 'membershipCounter',
                    'value' => '0',
                ],
            ]
        );

        $this->batchInsert('{{%enumeration}}',
            ["id", "parent", "enumerator", "value"],
            [
                [
                    'id' => '1',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Andorra',
                ],
                [
                    'id' => '2',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Dubai',
                ],
                [
                    'id' => '3',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Kabul',
                ],
                [
                    'id' => '4',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Antigua',
                ],
                [
                    'id' => '5',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Anguilla',
                ],
                [
                    'id' => '6',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Tirane',
                ],
                [
                    'id' => '7',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Yerevan',
                ],
                [
                    'id' => '8',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Luanda',
                ],
                [
                    'id' => '9',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Antarctica/McMurdo',
                ],
                [
                    'id' => '10',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Antarctica/Casey',
                ],
                [
                    'id' => '11',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Antarctica/Davis',
                ],
                [
                    'id' => '12',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Antarctica/DumontDUrville',
                ],
                [
                    'id' => '13',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Antarctica/Mawson',
                ],
                [
                    'id' => '14',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Antarctica/Palmer',
                ],
                [
                    'id' => '15',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Antarctica/Rothera',
                ],
                [
                    'id' => '16',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Antarctica/Syowa',
                ],
                [
                    'id' => '17',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Antarctica/Troll',
                ],
                [
                    'id' => '18',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Antarctica/Vostok',
                ],
                [
                    'id' => '19',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/Buenos_Aires',
                ],
                [
                    'id' => '20',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/Cordoba',
                ],
                [
                    'id' => '21',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/Salta',
                ],
                [
                    'id' => '22',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/Jujuy',
                ],
                [
                    'id' => '23',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/Tucuman',
                ],
                [
                    'id' => '24',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/Catamarca',
                ],
                [
                    'id' => '25',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/La_Rioja',
                ],
                [
                    'id' => '26',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/San_Juan',
                ],
                [
                    'id' => '27',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/Mendoza',
                ],
                [
                    'id' => '28',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/San_Luis',
                ],
                [
                    'id' => '29',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/Rio_Gallegos',
                ],
                [
                    'id' => '30',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Argentina/Ushuaia',
                ],
                [
                    'id' => '31',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Pago_Pago',
                ],
                [
                    'id' => '32',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Vienna',
                ],
                [
                    'id' => '33',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Australia/Lord_Howe',
                ],
                [
                    'id' => '34',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Antarctica/Macquarie',
                ],
                [
                    'id' => '35',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Australia/Hobart',
                ],
                [
                    'id' => '36',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Australia/Melbourne',
                ],
                [
                    'id' => '37',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Australia/Sydney',
                ],
                [
                    'id' => '38',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Australia/Broken_Hill',
                ],
                [
                    'id' => '39',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Australia/Brisbane',
                ],
                [
                    'id' => '40',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Australia/Lindeman',
                ],
                [
                    'id' => '41',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Australia/Adelaide',
                ],
                [
                    'id' => '42',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Australia/Darwin',
                ],
                [
                    'id' => '43',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Australia/Perth',
                ],
                [
                    'id' => '44',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Australia/Eucla',
                ],
                [
                    'id' => '45',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Aruba',
                ],
                [
                    'id' => '46',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Mariehamn',
                ],
                [
                    'id' => '47',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Baku',
                ],
                [
                    'id' => '48',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Sarajevo',
                ],
                [
                    'id' => '49',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Barbados',
                ],
                [
                    'id' => '50',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Dhaka',
                ],
                [
                    'id' => '51',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Brussels',
                ],
                [
                    'id' => '52',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Ouagadougou',
                ],
                [
                    'id' => '53',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Sofia',
                ],
                [
                    'id' => '54',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Bahrain',
                ],
                [
                    'id' => '55',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Bujumbura',
                ],
                [
                    'id' => '56',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Porto-Novo',
                ],
                [
                    'id' => '57',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/St_Barthelemy',
                ],
                [
                    'id' => '58',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Atlantic/Bermuda',
                ],
                [
                    'id' => '59',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Brunei',
                ],
                [
                    'id' => '60',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/La_Paz',
                ],
                [
                    'id' => '61',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Kralendijk',
                ],
                [
                    'id' => '62',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Noronha',
                ],
                [
                    'id' => '63',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Belem',
                ],
                [
                    'id' => '64',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Fortaleza',
                ],
                [
                    'id' => '65',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Recife',
                ],
                [
                    'id' => '66',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Araguaina',
                ],
                [
                    'id' => '67',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Maceio',
                ],
                [
                    'id' => '68',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Bahia',
                ],
                [
                    'id' => '69',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Sao_Paulo',
                ],
                [
                    'id' => '70',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Campo_Grande',
                ],
                [
                    'id' => '71',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Cuiaba',
                ],
                [
                    'id' => '72',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Santarem',
                ],
                [
                    'id' => '73',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Porto_Velho',
                ],
                [
                    'id' => '74',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Boa_Vista',
                ],
                [
                    'id' => '75',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Manaus',
                ],
                [
                    'id' => '76',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Eirunepe',
                ],
                [
                    'id' => '77',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Rio_Branco',
                ],
                [
                    'id' => '78',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Nassau',
                ],
                [
                    'id' => '79',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Thimphu',
                ],
                [
                    'id' => '80',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Gaborone',
                ],
                [
                    'id' => '81',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Minsk',
                ],
                [
                    'id' => '82',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Belize',
                ],
                [
                    'id' => '83',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/St_Johns',
                ],
                [
                    'id' => '84',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Halifax',
                ],
                [
                    'id' => '85',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Glace_Bay',
                ],
                [
                    'id' => '86',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Moncton',
                ],
                [
                    'id' => '87',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Goose_Bay',
                ],
                [
                    'id' => '88',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Blanc-Sablon',
                ],
                [
                    'id' => '89',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Toronto',
                ],
                [
                    'id' => '90',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Nipigon',
                ],
                [
                    'id' => '91',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Thunder_Bay',
                ],
                [
                    'id' => '92',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Iqaluit',
                ],
                [
                    'id' => '93',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Pangnirtung',
                ],
                [
                    'id' => '94',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Atikokan',
                ],
                [
                    'id' => '95',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Winnipeg',
                ],
                [
                    'id' => '96',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Rainy_River',
                ],
                [
                    'id' => '97',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Resolute',
                ],
                [
                    'id' => '98',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Rankin_Inlet',
                ],
                [
                    'id' => '99',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Regina',
                ],
                [
                    'id' => '100',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Swift_Current',
                ],
                [
                    'id' => '101',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Edmonton',
                ],
                [
                    'id' => '102',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Cambridge_Bay',
                ],
                [
                    'id' => '103',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Yellowknife',
                ],
                [
                    'id' => '104',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Inuvik',
                ],
                [
                    'id' => '105',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Creston',
                ],
                [
                    'id' => '106',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Dawson_Creek',
                ],
                [
                    'id' => '107',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Fort_Nelson',
                ],
                [
                    'id' => '108',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Whitehorse',
                ],
                [
                    'id' => '109',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Dawson',
                ],
                [
                    'id' => '110',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Vancouver',
                ],
                [
                    'id' => '111',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Indian/Cocos',
                ],
                [
                    'id' => '112',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Kinshasa',
                ],
                [
                    'id' => '113',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Lubumbashi',
                ],
                [
                    'id' => '114',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Bangui',
                ],
                [
                    'id' => '115',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Brazzaville',
                ],
                [
                    'id' => '116',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Zurich',
                ],
                [
                    'id' => '117',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Abidjan',
                ],
                [
                    'id' => '118',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Rarotonga',
                ],
                [
                    'id' => '119',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Santiago',
                ],
                [
                    'id' => '120',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Punta_Arenas',
                ],
                [
                    'id' => '121',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Easter',
                ],
                [
                    'id' => '122',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Douala',
                ],
                [
                    'id' => '123',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Shanghai',
                ],
                [
                    'id' => '124',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Urumqi',
                ],
                [
                    'id' => '125',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Bogota',
                ],
                [
                    'id' => '126',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Costa_Rica',
                ],
                [
                    'id' => '127',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Havana',
                ],
                [
                    'id' => '128',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Atlantic/Cape_Verde',
                ],
                [
                    'id' => '129',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Curacao',
                ],
                [
                    'id' => '130',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Indian/Christmas',
                ],
                [
                    'id' => '131',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Nicosia',
                ],
                [
                    'id' => '132',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Famagusta',
                ],
                [
                    'id' => '133',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Prague',
                ],
                [
                    'id' => '134',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Berlin',
                ],
                [
                    'id' => '135',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Busingen',
                ],
                [
                    'id' => '136',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Djibouti',
                ],
                [
                    'id' => '137',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Copenhagen',
                ],
                [
                    'id' => '138',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Dominica',
                ],
                [
                    'id' => '139',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Santo_Domingo',
                ],
                [
                    'id' => '140',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Algiers',
                ],
                [
                    'id' => '141',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Guayaquil',
                ],
                [
                    'id' => '142',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Galapagos',
                ],
                [
                    'id' => '143',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Tallinn',
                ],
                [
                    'id' => '144',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Cairo',
                ],
                [
                    'id' => '145',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/El_Aaiun',
                ],
                [
                    'id' => '146',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Asmara',
                ],
                [
                    'id' => '147',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Madrid',
                ],
                [
                    'id' => '148',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Ceuta',
                ],
                [
                    'id' => '149',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Atlantic/Canary',
                ],
                [
                    'id' => '150',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Addis_Ababa',
                ],
                [
                    'id' => '151',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Helsinki',
                ],
                [
                    'id' => '152',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Fiji',
                ],
                [
                    'id' => '153',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Atlantic/Stanley',
                ],
                [
                    'id' => '154',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Chuuk',
                ],
                [
                    'id' => '155',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Pohnpei',
                ],
                [
                    'id' => '156',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Kosrae',
                ],
                [
                    'id' => '157',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Atlantic/Faroe',
                ],
                [
                    'id' => '158',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Paris',
                ],
                [
                    'id' => '159',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Libreville',
                ],
                [
                    'id' => '160',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/London',
                ],
                [
                    'id' => '161',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Grenada',
                ],
                [
                    'id' => '162',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Tbilisi',
                ],
                [
                    'id' => '163',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Cayenne',
                ],
                [
                    'id' => '164',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Guernsey',
                ],
                [
                    'id' => '165',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Accra',
                ],
                [
                    'id' => '166',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Gibraltar',
                ],
                [
                    'id' => '167',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Nuuk',
                ],
                [
                    'id' => '168',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Danmarkshavn',
                ],
                [
                    'id' => '169',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Scoresbysund',
                ],
                [
                    'id' => '170',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Thule',
                ],
                [
                    'id' => '171',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Banjul',
                ],
                [
                    'id' => '172',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Conakry',
                ],
                [
                    'id' => '173',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Guadeloupe',
                ],
                [
                    'id' => '174',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Malabo',
                ],
                [
                    'id' => '175',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Athens',
                ],
                [
                    'id' => '176',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Atlantic/South_Georgia',
                ],
                [
                    'id' => '177',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Guatemala',
                ],
                [
                    'id' => '178',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Guam',
                ],
                [
                    'id' => '179',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Bissau',
                ],
                [
                    'id' => '180',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Guyana',
                ],
                [
                    'id' => '181',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Hong_Kong',
                ],
                [
                    'id' => '182',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Tegucigalpa',
                ],
                [
                    'id' => '183',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Zagreb',
                ],
                [
                    'id' => '184',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Port-au-Prince',
                ],
                [
                    'id' => '185',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Budapest',
                ],
                [
                    'id' => '186',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Jakarta',
                ],
                [
                    'id' => '187',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Pontianak',
                ],
                [
                    'id' => '188',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Makassar',
                ],
                [
                    'id' => '189',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Jayapura',
                ],
                [
                    'id' => '190',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Dublin',
                ],
                [
                    'id' => '191',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Jerusalem',
                ],
                [
                    'id' => '192',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Isle_of_Man',
                ],
                [
                    'id' => '193',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Kolkata',
                ],
                [
                    'id' => '194',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Indian/Chagos',
                ],
                [
                    'id' => '195',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Baghdad',
                ],
                [
                    'id' => '196',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Tehran',
                ],
                [
                    'id' => '197',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Atlantic/Reykjavik',
                ],
                [
                    'id' => '198',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Rome',
                ],
                [
                    'id' => '199',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Jersey',
                ],
                [
                    'id' => '200',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Jamaica',
                ],
                [
                    'id' => '201',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Amman',
                ],
                [
                    'id' => '202',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Tokyo',
                ],
                [
                    'id' => '203',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Nairobi',
                ],
                [
                    'id' => '204',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Bishkek',
                ],
                [
                    'id' => '205',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Phnom_Penh',
                ],
                [
                    'id' => '206',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Tarawa',
                ],
                [
                    'id' => '207',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Enderbury',
                ],
                [
                    'id' => '208',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Kiritimati',
                ],
                [
                    'id' => '209',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Indian/Comoro',
                ],
                [
                    'id' => '210',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/St_Kitts',
                ],
                [
                    'id' => '211',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Pyongyang',
                ],
                [
                    'id' => '212',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Seoul',
                ],
                [
                    'id' => '213',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Kuwait',
                ],
                [
                    'id' => '214',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Cayman',
                ],
                [
                    'id' => '215',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Almaty',
                ],
                [
                    'id' => '216',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Qyzylorda',
                ],
                [
                    'id' => '217',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Qostanay',
                ],
                [
                    'id' => '218',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Aqtobe',
                ],
                [
                    'id' => '219',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Aqtau',
                ],
                [
                    'id' => '220',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Atyrau',
                ],
                [
                    'id' => '221',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Oral',
                ],
                [
                    'id' => '222',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Vientiane',
                ],
                [
                    'id' => '223',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Beirut',
                ],
                [
                    'id' => '224',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/St_Lucia',
                ],
                [
                    'id' => '225',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Vaduz',
                ],
                [
                    'id' => '226',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Colombo',
                ],
                [
                    'id' => '227',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Monrovia',
                ],
                [
                    'id' => '228',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Maseru',
                ],
                [
                    'id' => '229',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Vilnius',
                ],
                [
                    'id' => '230',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Luxembourg',
                ],
                [
                    'id' => '231',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Riga',
                ],
                [
                    'id' => '232',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Tripoli',
                ],
                [
                    'id' => '233',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Casablanca',
                ],
                [
                    'id' => '234',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Monaco',
                ],
                [
                    'id' => '235',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Chisinau',
                ],
                [
                    'id' => '236',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Podgorica',
                ],
                [
                    'id' => '237',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Marigot',
                ],
                [
                    'id' => '238',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Indian/Antananarivo',
                ],
                [
                    'id' => '239',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Majuro',
                ],
                [
                    'id' => '240',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Kwajalein',
                ],
                [
                    'id' => '241',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Skopje',
                ],
                [
                    'id' => '242',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Bamako',
                ],
                [
                    'id' => '243',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Yangon',
                ],
                [
                    'id' => '244',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Ulaanbaatar',
                ],
                [
                    'id' => '245',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Hovd',
                ],
                [
                    'id' => '246',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Choibalsan',
                ],
                [
                    'id' => '247',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Macau',
                ],
                [
                    'id' => '248',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Saipan',
                ],
                [
                    'id' => '249',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Martinique',
                ],
                [
                    'id' => '250',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Nouakchott',
                ],
                [
                    'id' => '251',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Montserrat',
                ],
                [
                    'id' => '252',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Malta',
                ],
                [
                    'id' => '253',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Indian/Mauritius',
                ],
                [
                    'id' => '254',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Indian/Maldives',
                ],
                [
                    'id' => '255',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Blantyre',
                ],
                [
                    'id' => '256',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Mexico_City',
                ],
                [
                    'id' => '257',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Cancun',
                ],
                [
                    'id' => '258',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Merida',
                ],
                [
                    'id' => '259',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Monterrey',
                ],
                [
                    'id' => '260',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Matamoros',
                ],
                [
                    'id' => '261',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Mazatlan',
                ],
                [
                    'id' => '262',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Chihuahua',
                ],
                [
                    'id' => '263',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Ojinaga',
                ],
                [
                    'id' => '264',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Hermosillo',
                ],
                [
                    'id' => '265',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Tijuana',
                ],
                [
                    'id' => '266',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Bahia_Banderas',
                ],
                [
                    'id' => '267',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Kuala_Lumpur',
                ],
                [
                    'id' => '268',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Kuching',
                ],
                [
                    'id' => '269',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Maputo',
                ],
                [
                    'id' => '270',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Windhoek',
                ],
                [
                    'id' => '271',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Noumea',
                ],
                [
                    'id' => '272',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Niamey',
                ],
                [
                    'id' => '273',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Norfolk',
                ],
                [
                    'id' => '274',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Lagos',
                ],
                [
                    'id' => '275',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Managua',
                ],
                [
                    'id' => '276',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Amsterdam',
                ],
                [
                    'id' => '277',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Oslo',
                ],
                [
                    'id' => '278',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Kathmandu',
                ],
                [
                    'id' => '279',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Nauru',
                ],
                [
                    'id' => '280',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Niue',
                ],
                [
                    'id' => '281',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Auckland',
                ],
                [
                    'id' => '282',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Chatham',
                ],
                [
                    'id' => '283',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Muscat',
                ],
                [
                    'id' => '284',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Panama',
                ],
                [
                    'id' => '285',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Lima',
                ],
                [
                    'id' => '286',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Tahiti',
                ],
                [
                    'id' => '287',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Marquesas',
                ],
                [
                    'id' => '288',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Gambier',
                ],
                [
                    'id' => '289',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Port_Moresby',
                ],
                [
                    'id' => '290',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Bougainville',
                ],
                [
                    'id' => '291',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Manila',
                ],
                [
                    'id' => '292',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Karachi',
                ],
                [
                    'id' => '293',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Warsaw',
                ],
                [
                    'id' => '294',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Miquelon',
                ],
                [
                    'id' => '295',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Pitcairn',
                ],
                [
                    'id' => '296',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Puerto_Rico',
                ],
                [
                    'id' => '297',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Gaza',
                ],
                [
                    'id' => '298',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Hebron',
                ],
                [
                    'id' => '299',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Lisbon',
                ],
                [
                    'id' => '300',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Atlantic/Madeira',
                ],
                [
                    'id' => '301',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Atlantic/Azores',
                ],
                [
                    'id' => '302',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Palau',
                ],
                [
                    'id' => '303',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Asuncion',
                ],
                [
                    'id' => '304',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Qatar',
                ],
                [
                    'id' => '305',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Indian/Reunion',
                ],
                [
                    'id' => '306',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Bucharest',
                ],
                [
                    'id' => '307',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Belgrade',
                ],
                [
                    'id' => '308',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Kaliningrad',
                ],
                [
                    'id' => '309',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Moscow',
                ],
                [
                    'id' => '310',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Simferopol',
                ],
                [
                    'id' => '311',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Kirov',
                ],
                [
                    'id' => '312',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Volgograd',
                ],
                [
                    'id' => '313',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Astrakhan',
                ],
                [
                    'id' => '314',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Saratov',
                ],
                [
                    'id' => '315',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Ulyanovsk',
                ],
                [
                    'id' => '316',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Samara',
                ],
                [
                    'id' => '317',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Yekaterinburg',
                ],
                [
                    'id' => '318',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Omsk',
                ],
                [
                    'id' => '319',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Novosibirsk',
                ],
                [
                    'id' => '320',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Barnaul',
                ],
                [
                    'id' => '321',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Tomsk',
                ],
                [
                    'id' => '322',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Novokuznetsk',
                ],
                [
                    'id' => '323',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Krasnoyarsk',
                ],
                [
                    'id' => '324',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Irkutsk',
                ],
                [
                    'id' => '325',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Chita',
                ],
                [
                    'id' => '326',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Yakutsk',
                ],
                [
                    'id' => '327',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Khandyga',
                ],
                [
                    'id' => '328',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Vladivostok',
                ],
                [
                    'id' => '329',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Ust-Nera',
                ],
                [
                    'id' => '330',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Magadan',
                ],
                [
                    'id' => '331',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Sakhalin',
                ],
                [
                    'id' => '332',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Srednekolymsk',
                ],
                [
                    'id' => '333',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Kamchatka',
                ],
                [
                    'id' => '334',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Anadyr',
                ],
                [
                    'id' => '335',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Kigali',
                ],
                [
                    'id' => '336',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Riyadh',
                ],
                [
                    'id' => '337',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Guadalcanal',
                ],
                [
                    'id' => '338',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Indian/Mahe',
                ],
                [
                    'id' => '339',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Khartoum',
                ],
                [
                    'id' => '340',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Stockholm',
                ],
                [
                    'id' => '341',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Singapore',
                ],
                [
                    'id' => '342',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Atlantic/St_Helena',
                ],
                [
                    'id' => '343',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Ljubljana',
                ],
                [
                    'id' => '344',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Arctic/Longyearbyen',
                ],
                [
                    'id' => '345',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Bratislava',
                ],
                [
                    'id' => '346',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Freetown',
                ],
                [
                    'id' => '347',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/San_Marino',
                ],
                [
                    'id' => '348',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Dakar',
                ],
                [
                    'id' => '349',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Mogadishu',
                ],
                [
                    'id' => '350',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Paramaribo',
                ],
                [
                    'id' => '351',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Juba',
                ],
                [
                    'id' => '352',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Sao_Tome',
                ],
                [
                    'id' => '353',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/El_Salvador',
                ],
                [
                    'id' => '354',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Lower_Princes',
                ],
                [
                    'id' => '355',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Damascus',
                ],
                [
                    'id' => '356',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Mbabane',
                ],
                [
                    'id' => '357',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Grand_Turk',
                ],
                [
                    'id' => '358',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Ndjamena',
                ],
                [
                    'id' => '359',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Indian/Kerguelen',
                ],
                [
                    'id' => '360',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Lome',
                ],
                [
                    'id' => '361',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Bangkok',
                ],
                [
                    'id' => '362',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Dushanbe',
                ],
                [
                    'id' => '363',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Fakaofo',
                ],
                [
                    'id' => '364',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Dili',
                ],
                [
                    'id' => '365',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Ashgabat',
                ],
                [
                    'id' => '366',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Tunis',
                ],
                [
                    'id' => '367',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Tongatapu',
                ],
                [
                    'id' => '368',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Istanbul',
                ],
                [
                    'id' => '369',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Port_of_Spain',
                ],
                [
                    'id' => '370',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Funafuti',
                ],
                [
                    'id' => '371',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Taipei',
                ],
                [
                    'id' => '372',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Dar_es_Salaam',
                ],
                [
                    'id' => '373',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Kiev',
                ],
                [
                    'id' => '374',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Uzhgorod',
                ],
                [
                    'id' => '375',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Zaporozhye',
                ],
                [
                    'id' => '376',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Kampala',
                ],
                [
                    'id' => '377',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Midway',
                ],
                [
                    'id' => '378',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Wake',
                ],
                [
                    'id' => '379',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/New_York',
                ],
                [
                    'id' => '380',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Detroit',
                ],
                [
                    'id' => '381',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Kentucky/Louisville',
                ],
                [
                    'id' => '382',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Kentucky/Monticello',
                ],
                [
                    'id' => '383',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Indiana/Indianapolis',
                ],
                [
                    'id' => '384',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Indiana/Vincennes',
                ],
                [
                    'id' => '385',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Indiana/Winamac',
                ],
                [
                    'id' => '386',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Indiana/Marengo',
                ],
                [
                    'id' => '387',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Indiana/Petersburg',
                ],
                [
                    'id' => '388',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Indiana/Vevay',
                ],
                [
                    'id' => '389',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Chicago',
                ],
                [
                    'id' => '390',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Indiana/Tell_City',
                ],
                [
                    'id' => '391',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Indiana/Knox',
                ],
                [
                    'id' => '392',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Menominee',
                ],
                [
                    'id' => '393',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/North_Dakota/Center',
                ],
                [
                    'id' => '394',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/North_Dakota/New_Salem',
                ],
                [
                    'id' => '395',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/North_Dakota/Beulah',
                ],
                [
                    'id' => '396',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Denver',
                ],
                [
                    'id' => '397',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Boise',
                ],
                [
                    'id' => '398',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Phoenix',
                ],
                [
                    'id' => '399',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Los_Angeles',
                ],
                [
                    'id' => '400',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Anchorage',
                ],
                [
                    'id' => '401',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Juneau',
                ],
                [
                    'id' => '402',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Sitka',
                ],
                [
                    'id' => '403',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Metlakatla',
                ],
                [
                    'id' => '404',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Yakutat',
                ],
                [
                    'id' => '405',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Nome',
                ],
                [
                    'id' => '406',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Adak',
                ],
                [
                    'id' => '407',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Honolulu',
                ],
                [
                    'id' => '408',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Montevideo',
                ],
                [
                    'id' => '409',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Samarkand',
                ],
                [
                    'id' => '410',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Tashkent',
                ],
                [
                    'id' => '411',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Europe/Vatican',
                ],
                [
                    'id' => '412',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/St_Vincent',
                ],
                [
                    'id' => '413',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Caracas',
                ],
                [
                    'id' => '414',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/Tortola',
                ],
                [
                    'id' => '415',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'America/St_Thomas',
                ],
                [
                    'id' => '416',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Ho_Chi_Minh',
                ],
                [
                    'id' => '417',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Efate',
                ],
                [
                    'id' => '418',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Wallis',
                ],
                [
                    'id' => '419',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Pacific/Apia',
                ],
                [
                    'id' => '420',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Asia/Aden',
                ],
                [
                    'id' => '421',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Indian/Mayotte',
                ],
                [
                    'id' => '422',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Johannesburg',
                ],
                [
                    'id' => '423',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Lusaka',
                ],
                [
                    'id' => '424',
                    'parent' => null,
                    'enumerator' => 'timezone',
                    'value' => 'Africa/Harare',
                ],
            ]
        );

        $this->batchInsert('{{%system_content}}',
            ["instance", "content", "value"],
            [
                [
                    'instance' => 'default',
                    'content' => 'ForgotPWHeader',
                    'value' => 'DEFAULT FORGOT PASSWORD HEADER',
                ],
                [
                    'instance' => 'default',
                    'content' => 'ForgotPWHeaderContent',
                    'value' => 'Default forgot password header content.',
                ],
                [
                    'instance' => 'default',
                    'content' => 'LoginHeader',
                    'value' => 'Default login header content.',
                ],
                [
                    'instance' => 'default',
                    'content' => 'LoginHeaderContent',
                    'value' => 'Default login header content.',
                ],
                [
                    'instance' => 'default',
                    'content' => 'LoginQRHeader',
                    'value' => 'DEFAULT LOGIN QR HEADER',
                ],
                [
                    'instance' => 'default',
                    'content' => 'LoginQRHeaderContent',
                    'value' => 'Default login QR header content.',
                ],
                [
                    'instance' => 'default',
                    'content' => 'RegisterHeader',
                    'value' => 'DEFAULT REGISTER HEADER',
                ],
                [
                    'instance' => 'default',
                    'content' => 'RegisterHeaderContent',
                    'value' => 'Default register header content.',
                ],
                [
                    'instance' => 'default',
                    'content' => 'ResetPWHeader',
                    'value' => 'DEFAULT RESET PASSWORD HEADER',
                ],
                [
                    'instance' => 'default',
                    'content' => 'ResetPWHeaderContent',
                    'value' => 'Default reset password header content.',
                ],
            ]
        );

        $this->batchInsert('{{%language}}',
            ["language_id", "language", "country", "name", "name_ascii", "status"],
            [
                [
                    'language_id' => 'af-ZA',
                    'language' => 'af',
                    'country' => 'za',
                    'name' => 'Afrikaans',
                    'name_ascii' => 'Afrikaans',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ar-AR',
                    'language' => 'ar',
                    'country' => 'ar',
                    'name' => '‏العربية‏',
                    'name_ascii' => 'Arabic',
                    'status' => '0',
                ],
                [
                    'language_id' => 'az-AZ',
                    'language' => 'az',
                    'country' => 'az',
                    'name' => 'Azərbaycan dili',
                    'name_ascii' => 'Azerbaijani',
                    'status' => '0',
                ],
                [
                    'language_id' => 'be-BY',
                    'language' => 'be',
                    'country' => 'by',
                    'name' => 'Беларуская',
                    'name_ascii' => 'Belarusian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'bg-BG',
                    'language' => 'bg',
                    'country' => 'bg',
                    'name' => 'Български',
                    'name_ascii' => 'Bulgarian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'bn-IN',
                    'language' => 'bn',
                    'country' => 'in',
                    'name' => 'বাংলা',
                    'name_ascii' => 'Bengali',
                    'status' => '0',
                ],
                [
                    'language_id' => 'bs-BA',
                    'language' => 'bs',
                    'country' => 'ba',
                    'name' => 'Bosanski',
                    'name_ascii' => 'Bosnian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ca-ES',
                    'language' => 'ca',
                    'country' => 'es',
                    'name' => 'Català',
                    'name_ascii' => 'Catalan',
                    'status' => '0',
                ],
                [
                    'language_id' => 'cs-CZ',
                    'language' => 'cs',
                    'country' => 'cz',
                    'name' => 'Čeština',
                    'name_ascii' => 'Czech',
                    'status' => '0',
                ],
                [
                    'language_id' => 'cy-GB',
                    'language' => 'cy',
                    'country' => 'gb',
                    'name' => 'Cymraeg',
                    'name_ascii' => 'Welsh',
                    'status' => '0',
                ],
                [
                    'language_id' => 'da-DK',
                    'language' => 'da',
                    'country' => 'dk',
                    'name' => 'Dansk',
                    'name_ascii' => 'Danish',
                    'status' => '0',
                ],
                [
                    'language_id' => 'de-DE',
                    'language' => 'de',
                    'country' => 'de',
                    'name' => 'Deutsch',
                    'name_ascii' => 'German',
                    'status' => '0',
                ],
                [
                    'language_id' => 'el-GR',
                    'language' => 'el',
                    'country' => 'gr',
                    'name' => 'Ελληνικά',
                    'name_ascii' => 'Greek',
                    'status' => '0',
                ],
                [
                    'language_id' => 'en-GB',
                    'language' => 'en',
                    'country' => 'gb',
                    'name' => 'English (UK)',
                    'name_ascii' => 'English (UK)',
                    'status' => '0',
                ],
                [
                    'language_id' => 'en-PI',
                    'language' => 'en',
                    'country' => 'pi',
                    'name' => 'English (Pirate)',
                    'name_ascii' => 'English (Pirate)',
                    'status' => '0',
                ],
                [
                    'language_id' => 'en-UD',
                    'language' => 'en',
                    'country' => 'ud',
                    'name' => 'English (Upside Down)',
                    'name_ascii' => 'English (Upside Down)',
                    'status' => '0',
                ],
                [
                    'language_id' => 'en-US',
                    'language' => 'en',
                    'country' => 'us',
                    'name' => 'English (US)',
                    'name_ascii' => 'English (US)',
                    'status' => '1',
                ],
                [
                    'language_id' => 'eo-EO',
                    'language' => 'eo',
                    'country' => 'eo',
                    'name' => 'Esperanto',
                    'name_ascii' => 'Esperanto',
                    'status' => '0',
                ],
                [
                    'language_id' => 'es-ES',
                    'language' => 'es',
                    'country' => 'es',
                    'name' => 'Español (España)',
                    'name_ascii' => 'Spanish (Spain)',
                    'status' => '1',
                ],
                [
                    'language_id' => 'es-LA',
                    'language' => 'es',
                    'country' => 'la',
                    'name' => 'Español',
                    'name_ascii' => 'Spanish',
                    'status' => '0',
                ],
                [
                    'language_id' => 'et-EE',
                    'language' => 'et',
                    'country' => 'ee',
                    'name' => 'Eesti',
                    'name_ascii' => 'Estonian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'eu-ES',
                    'language' => 'eu',
                    'country' => 'es',
                    'name' => 'Euskara',
                    'name_ascii' => 'Basque',
                    'status' => '0',
                ],
                [
                    'language_id' => 'fa-IR',
                    'language' => 'fa',
                    'country' => 'ir',
                    'name' => '‏فارسی‏',
                    'name_ascii' => 'Persian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'fb-LT',
                    'language' => 'fb',
                    'country' => 'lt',
                    'name' => 'Leet Speak',
                    'name_ascii' => 'Leet Speak',
                    'status' => '0',
                ],
                [
                    'language_id' => 'fi-FI',
                    'language' => 'fi',
                    'country' => 'fi',
                    'name' => 'Suomi',
                    'name_ascii' => 'Finnish',
                    'status' => '0',
                ],
                [
                    'language_id' => 'fo-FO',
                    'language' => 'fo',
                    'country' => 'fo',
                    'name' => 'Føroyskt',
                    'name_ascii' => 'Faroese',
                    'status' => '0',
                ],
                [
                    'language_id' => 'fr-CA',
                    'language' => 'fr',
                    'country' => 'ca',
                    'name' => 'Français (Canada)',
                    'name_ascii' => 'French (Canada)',
                    'status' => '0',
                ],
                [
                    'language_id' => 'fr-FR',
                    'language' => 'fr',
                    'country' => 'fr',
                    'name' => 'Français (France)',
                    'name_ascii' => 'French (France)',
                    'status' => '0',
                ],
                [
                    'language_id' => 'fy-NL',
                    'language' => 'fy',
                    'country' => 'nl',
                    'name' => 'Frysk',
                    'name_ascii' => 'Frisian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ga-IE',
                    'language' => 'ga',
                    'country' => 'ie',
                    'name' => 'Gaeilge',
                    'name_ascii' => 'Irish',
                    'status' => '0',
                ],
                [
                    'language_id' => 'gl-ES',
                    'language' => 'gl',
                    'country' => 'es',
                    'name' => 'Galego',
                    'name_ascii' => 'Galician',
                    'status' => '0',
                ],
                [
                    'language_id' => 'he-IL',
                    'language' => 'he',
                    'country' => 'il',
                    'name' => '‏עברית‏',
                    'name_ascii' => 'Hebrew',
                    'status' => '0',
                ],
                [
                    'language_id' => 'hi-IN',
                    'language' => 'hi',
                    'country' => 'in',
                    'name' => 'हिन्दी',
                    'name_ascii' => 'Hindi',
                    'status' => '0',
                ],
                [
                    'language_id' => 'hr-HR',
                    'language' => 'hr',
                    'country' => 'hr',
                    'name' => 'Hrvatski',
                    'name_ascii' => 'Croatian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'hu-HU',
                    'language' => 'hu',
                    'country' => 'hu',
                    'name' => 'Magyar',
                    'name_ascii' => 'Hungarian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'hy-AM',
                    'language' => 'hy',
                    'country' => 'am',
                    'name' => 'Հայերեն',
                    'name_ascii' => 'Armenian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'id-ID',
                    'language' => 'id',
                    'country' => 'id',
                    'name' => 'Bahasa Indonesia',
                    'name_ascii' => 'Indonesian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'is-IS',
                    'language' => 'is',
                    'country' => 'is',
                    'name' => 'Íslenska',
                    'name_ascii' => 'Icelandic',
                    'status' => '0',
                ],
                [
                    'language_id' => 'it-IT',
                    'language' => 'it',
                    'country' => 'it',
                    'name' => 'Italiano',
                    'name_ascii' => 'Italian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ja-JP',
                    'language' => 'ja',
                    'country' => 'jp',
                    'name' => '日本語',
                    'name_ascii' => 'Japanese',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ka-GE',
                    'language' => 'ka',
                    'country' => 'ge',
                    'name' => 'ქართული',
                    'name_ascii' => 'Georgian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'km-KH',
                    'language' => 'km',
                    'country' => 'kh',
                    'name' => 'ភាសាខ្មែរ',
                    'name_ascii' => 'Khmer',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ko-KR',
                    'language' => 'ko',
                    'country' => 'kr',
                    'name' => '한국어',
                    'name_ascii' => 'Korean',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ku-TR',
                    'language' => 'ku',
                    'country' => 'tr',
                    'name' => 'Kurdî',
                    'name_ascii' => 'Kurdish',
                    'status' => '0',
                ],
                [
                    'language_id' => 'la-VA',
                    'language' => 'la',
                    'country' => 'va',
                    'name' => 'lingua latina',
                    'name_ascii' => 'Latin',
                    'status' => '0',
                ],
                [
                    'language_id' => 'lt-LT',
                    'language' => 'lt',
                    'country' => 'lt',
                    'name' => 'Lietuvių',
                    'name_ascii' => 'Lithuanian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'lv-LV',
                    'language' => 'lv',
                    'country' => 'lv',
                    'name' => 'Latviešu',
                    'name_ascii' => 'Latvian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'mk-MK',
                    'language' => 'mk',
                    'country' => 'mk',
                    'name' => 'Македонски',
                    'name_ascii' => 'Macedonian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ml-IN',
                    'language' => 'ml',
                    'country' => 'in',
                    'name' => 'മലയാളം',
                    'name_ascii' => 'Malayalam',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ms-MY',
                    'language' => 'ms',
                    'country' => 'my',
                    'name' => 'Bahasa Melayu',
                    'name_ascii' => 'Malay',
                    'status' => '0',
                ],
                [
                    'language_id' => 'nb-NO',
                    'language' => 'nb',
                    'country' => 'no',
                    'name' => 'Norsk (bokmål)',
                    'name_ascii' => 'Norwegian (bokmal)',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ne-NP',
                    'language' => 'ne',
                    'country' => 'np',
                    'name' => 'नेपाली',
                    'name_ascii' => 'Nepali',
                    'status' => '0',
                ],
                [
                    'language_id' => 'nl-NL',
                    'language' => 'nl',
                    'country' => 'nl',
                    'name' => 'Nederlands',
                    'name_ascii' => 'Dutch',
                    'status' => '0',
                ],
                [
                    'language_id' => 'nn-NO',
                    'language' => 'nn',
                    'country' => 'no',
                    'name' => 'Norsk (nynorsk)',
                    'name_ascii' => 'Norwegian (nynorsk)',
                    'status' => '0',
                ],
                [
                    'language_id' => 'pa-IN',
                    'language' => 'pa',
                    'country' => 'in',
                    'name' => 'ਪੰਜਾਬੀ',
                    'name_ascii' => 'Punjabi',
                    'status' => '0',
                ],
                [
                    'language_id' => 'pl-PL',
                    'language' => 'pl',
                    'country' => 'pl',
                    'name' => 'Polski',
                    'name_ascii' => 'Polish',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ps-AF',
                    'language' => 'ps',
                    'country' => 'af',
                    'name' => '‏پښتو‏',
                    'name_ascii' => 'Pashto',
                    'status' => '0',
                ],
                [
                    'language_id' => 'pt-BR',
                    'language' => 'pt',
                    'country' => 'br',
                    'name' => 'Português (Brasil)',
                    'name_ascii' => 'Portuguese (Brazil)',
                    'status' => '0',
                ],
                [
                    'language_id' => 'pt-PT',
                    'language' => 'pt',
                    'country' => 'pt',
                    'name' => 'Português (Portugal)',
                    'name_ascii' => 'Portuguese (Portugal)',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ro-RO',
                    'language' => 'ro',
                    'country' => 'ro',
                    'name' => 'Română',
                    'name_ascii' => 'Romanian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ru-RU',
                    'language' => 'ru',
                    'country' => 'ru',
                    'name' => 'Русский',
                    'name_ascii' => 'Russian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'sk-SK',
                    'language' => 'sk',
                    'country' => 'sk',
                    'name' => 'Slovenčina',
                    'name_ascii' => 'Slovak',
                    'status' => '0',
                ],
                [
                    'language_id' => 'sl-SI',
                    'language' => 'sl',
                    'country' => 'si',
                    'name' => 'Slovenščina',
                    'name_ascii' => 'Slovenian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'sq-AL',
                    'language' => 'sq',
                    'country' => 'al',
                    'name' => 'Shqip',
                    'name_ascii' => 'Albanian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'sr-RS',
                    'language' => 'sr',
                    'country' => 'rs',
                    'name' => 'Српски',
                    'name_ascii' => 'Serbian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'sv-SE',
                    'language' => 'sv',
                    'country' => 'se',
                    'name' => 'Svenska',
                    'name_ascii' => 'Swedish',
                    'status' => '1',
                ],
                [
                    'language_id' => 'sw-KE',
                    'language' => 'sw',
                    'country' => 'ke',
                    'name' => 'Kiswahili',
                    'name_ascii' => 'Swahili',
                    'status' => '0',
                ],
                [
                    'language_id' => 'ta-IN',
                    'language' => 'ta',
                    'country' => 'in',
                    'name' => 'தமிழ்',
                    'name_ascii' => 'Tamil',
                    'status' => '0',
                ],
                [
                    'language_id' => 'te-IN',
                    'language' => 'te',
                    'country' => 'in',
                    'name' => 'తెలుగు',
                    'name_ascii' => 'Telugu',
                    'status' => '0',
                ],
                [
                    'language_id' => 'th-TH',
                    'language' => 'th',
                    'country' => 'th',
                    'name' => 'ภาษาไทย',
                    'name_ascii' => 'Thai',
                    'status' => '0',
                ],
                [
                    'language_id' => 'tl-PH',
                    'language' => 'tl',
                    'country' => 'ph',
                    'name' => 'Filipino',
                    'name_ascii' => 'Filipino',
                    'status' => '0',
                ],
                [
                    'language_id' => 'tr-TR',
                    'language' => 'tr',
                    'country' => 'tr',
                    'name' => 'Türkçe',
                    'name_ascii' => 'Turkish',
                    'status' => '0',
                ],
                [
                    'language_id' => 'uk-UA',
                    'language' => 'uk',
                    'country' => 'ua',
                    'name' => 'Українська',
                    'name_ascii' => 'Ukrainian',
                    'status' => '0',
                ],
                [
                    'language_id' => 'vi-VN',
                    'language' => 'vi',
                    'country' => 'vn',
                    'name' => 'Tiếng Việt',
                    'name_ascii' => 'Vietnamese',
                    'status' => '0',
                ],
                [
                    'language_id' => 'xx-XX',
                    'language' => 'xx',
                    'country' => 'xx',
                    'name' => 'Fejlesztő',
                    'name_ascii' => 'Developer',
                    'status' => '0',
                ],
                [
                    'language_id' => 'zh-CN',
                    'language' => 'zh',
                    'country' => 'cn',
                    'name' => '中文(简体)',
                    'name_ascii' => 'Simplified Chinese (China)',
                    'status' => '0',
                ],
                [
                    'language_id' => 'zh-HK',
                    'language' => 'zh',
                    'country' => 'hk',
                    'name' => '中文(香港)',
                    'name_ascii' => 'Traditional Chinese (Hong Kong)',
                    'status' => '0',
                ],
                [
                    'language_id' => 'zh-TW',
                    'language' => 'zh',
                    'country' => 'tw',
                    'name' => '中文(台灣)',
                    'name_ascii' => 'Traditional Chinese (Taiwan)',
                    'status' => '0',
                ],
            ]
        );
        $this->batchInsert('{{%system_content}}', ["instance", "content", "value"], [
            [
                'instance' => 'default',
                'content' => 'content_email_signature',
                'value' => '<i>This is an automatically generated message, please do not reply to this email.<br>If you wish to send us a message, please, use the contact form on the website.</i><br><br><b>Kind regards,</b><br>Administration<br>',
            ],
            [
                'instance' => 'default',
                'content' => 'content_email_inviteUser',
                'value' => '<strong>You have been invited to {platformName} by {inviterName} to join the organization {organizationName} as a {userLevel}</strong><br><br>To view the invitation click the link below and log in to your account.<br><br>If you do not already have an account you can register one after clicking the link.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_email_quickPaymentSend',
                'value' => '<b>Hi</b><br>You have received a payment request<p>{organization_name} has requested a payment for <b>{amount}</b>.</p><p>In order to complete the payment you must click the link below.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_sms_quickPaymentSend',
                'value' => '{organization_name} has sent you a payment request for {amount}, click the link to see the request.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_email_quickPaymentUpdated',
                'value' => '<b>Hi</b><br>Your payment request was updated<p>{organization_name} has requested a payment for <b>{amount}</b>.</p><p>In order to complete the payment you must click the link below.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_sms_quickPaymentUpdated',
                'value' => '{organization_name} has updated your payment request, for {amount}, click the link to see the request.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_email_quickPaymentReceipt',
                'value' => '<b>Hi</b><br>You have paid the payment request<p>{organization_name} thanks you for making the payment.</p><p>We attach the payment receipt, you can also see it in the following link.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_sms_quickPaymentReceipt',
                'value' => 'You have paid a payment request. {organization_name} thanks you for making the payment, click the link to see the receipt.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_email_subscriptionSend',
                'value' => '<b>Hi</b><br>To finalize your subscription click de following link.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_email_subscriptionNoPaid',
                'value' => '<b>Hi</b><br>An error has occurred with your subscription payout, or we can not charge your subscription.<br>You can renew your subscription in the following link.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_email_subscriptionReceipt',
                'value' => '<b>Hi</b><br>You have paid the payment request<p>{organization_name} thanks you for making the payment.</p><p>We attach the payment receipt, you can also see it in the following link.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_email_clipCardPreBought',
                'value' => '<b>Hi</b><br>To finalize your clip card click de following link.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_email_clipCardCollecting',
                'value' => '<b>Hi</b><br>To see your clip card click de following link.',
            ],
            [
                'instance' => 'default',
                'content' => 'content_email_clipCardReceipt',
                'value' => '<b>Hi</b><br>You have paid the payment request<p>{organization_name} thanks you for making the payment.</p><p>We attach the payment receipt, you can also see it in the following link.',
            ],
        ]);

        $this->batchInsert('{{%language_force_translation}}', ["value"],
            [
                [
                    'value' => 'owner',
                ],
                [
                    'value' => 'admin',
                ],
                [
                    'value' => 'user',
                ],
                [
                    'value' => 'pending',
                ],
                [
                    'value' => 'accepted',
                ],
                [
                    'value' => 'declined',
                ],
            ]
        );
    }



    public function safeDown()
    {
        echo 'This migration can not be reversed';
    }
}
