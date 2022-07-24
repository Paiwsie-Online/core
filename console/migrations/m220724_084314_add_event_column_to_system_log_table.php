<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%system_log}}`.
 */
class m220724_084314_add_event_column_to_system_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%system_log}}', 'event', $this->string(128)->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%system_log}}', 'event');
    }
}
