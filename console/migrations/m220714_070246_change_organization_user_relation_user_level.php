<?php

use yii\db\Migration;

/**
 * Class m220714_070246_change_organization_user_relation_user_level
 */
class m220714_070246_change_organization_user_relation_user_level extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $query = "ALTER TABLE organization_user_relation MODIFY user_level ENUM('superadmin','cashier','admin','legalGuardian', 'user') default 'user'";
        $this->execute($query);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220714_070246_change_organization_user_relation_user_level cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220714_070246_change_organization_user_relation_user_level cannot be reverted.\n";

        return false;
    }
    */
}
