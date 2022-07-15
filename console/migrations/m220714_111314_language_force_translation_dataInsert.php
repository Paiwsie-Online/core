<?php

use yii\db\Migration;

/**
 * Class m220714_111314_language_force_translation_dataInsert
 */
class m220714_111314_language_force_translation_dataInsert extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220714_111314_language_force_translation_dataInsert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220714_111314_language_force_translation_dataInsert cannot be reverted.\n";

        return false;
    }
    */
}
