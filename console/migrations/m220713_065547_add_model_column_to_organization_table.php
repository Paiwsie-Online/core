<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%organization}}`.
 */
class m220713_065547_add_model_column_to_organization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%organization}}', 'model', $this->string(512)->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%organization}}', 'model');
    }
}
