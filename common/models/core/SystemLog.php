<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int|null $user_id
 * @property int|null $organization_id
 * @property string|null $instance
 * @property string|null $message_short
 * @property string|null $message
 * @property string|null $data_format
 * @property string $log_time

 * @property Organization $organization
 * @property User $user
 */

class SystemLog extends \yii\db\ActiveRecord {

    public $organization_name;
    public $user_name;

    public static function tableName() {
        return 'system_log';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['log_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
        ];
    }

    public function rules() {
        return [
            [['user_id', 'organization_id'], 'integer'],
            [['message', 'data_format'], 'string'],
            [['log_time', 'instance'], 'safe'],
            [['message_short'], 'string', 'max' => 512],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'user_id' => Yii::t('core_model', 'User ID'),
            'organization_id' => Yii::t('core_model', 'Organization ID'),
            'message_short' => Yii::t('core_model', 'Message Short'),
            'message' => Yii::t('core_model', 'Message'),
            'data_format' => Yii::t('core_model', 'Data Format'),
            'log_time' => Yii::t('core_model', 'Log Time'),
            'organization_name'  =>  Yii::t('core_model', 'Organization'),
            'user_name'  =>  Yii::t('core_model', 'User'),
            'instance'  =>  Yii::t('core_model', 'Instance'),
        ];
    }

    public function getOrganization() {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    // CREATE SYSTEM LOG
    public static function saveSystemLog($action, $values, $userId = null, $instance = null, $organizationID = null) {
        if (isset($userId)) {
            $user = User::findOne($userId);
            $userName = $user->first_name . ' ' . $user->last_name;
        } elseif (isset(Yii::$app->user)) {
            $userName = Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name;
        }
        $systemLog = new SystemLog();
        $systemLog->user_id = ($userId ?? (Yii::$app->user->identity->id ?? null));
        $systemLog->instance = ($instance ?? (Yii::$app->user->identity->instance ?? null));
        $systemLog->organization_id = ($organizationID ?? (Yii::$app->user->identity->selectedOrganization->id ?? null));
        $systemLog->message_short = ($userName ?? '') . ' ' . $action;
        $systemLog->message = ($userName ?? '') . ' ' . $action . ': ' . $values;
        $dataFormat = [
            'event' => str_replace(' ', '', $action),
            'user' => ($userId ?? (Yii::$app->user->identity->id ?? '')),
            'value' => $values,
        ];
        $systemLog->data_format = json_encode($dataFormat);
        $systemLog->save();
    }
}