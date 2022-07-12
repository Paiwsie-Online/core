<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;

/**
 * @property int $id
 * @property string $cronjob_id
 * @property string $started
 * @property string $ended
 * @property string|null $data
 *
 * @property Cronjob $cronjob
 */

class CronjobLog extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'cronjob_log';
    }

    public function rules() {
        return [
            [['cronjob_id', 'started'], 'required'],
            [['started', 'ended'], 'safe'],
            [['data', 'cronjob_id'], 'string'],
            [['cronjob_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cronjob::className(), 'targetAttribute' => ['cronjob_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'cronjob_id' => Yii::t('core_model', 'Cronjob ID'),
            'started' => Yii::t('core_model', 'Started'),
            'ended' => Yii::t('core_model', 'Ended'),
            'data' => Yii::t('core_model', 'Data'),
        ];
    }

    public function getCronjob() {
        return $this->hasOne(Cronjob::className(), ['id' => 'cronjob_id']);
    }

}