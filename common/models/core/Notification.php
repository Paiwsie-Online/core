<?php
/*THE DEFAULT NOTIFICATION DATA LOOKS AS FOLLOWS

$data = [
    'image' => 'https://back.core.test/img/users/avatar-2.jpg',
    'heading' => 'Angela Bernier',
    'message' => 'Answered to your comment on the cash flow.',
    'link' => '#!'
];
 */


namespace common\models\core;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property string $category
 * @property string $priority
 * @property string $notification_data
 * @property string $status
 * @property int|null $status_changed
 * @property int|null $status_changed_by
 * @property int|null $created_at
 *
 * @property User $statusChangedBy
 * @property UserNotificationRelation[] $userNotificationRelations
 * @property User[] $users
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'notification_data'], 'required'],
            [['category', 'priority', 'notification_data', 'status'], 'string'],
            [['status_changed', 'status_changed_by', 'created_at'], 'integer'],
            [['status_changed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['status_changed_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'priority' => Yii::t('app', 'Priority'),
            'notification_data' => Yii::t('app', 'Notification Data'),
            'status' => Yii::t('app', 'Status'),
            'status_changed' => Yii::t('app', 'Status Changed'),
            'status_changed_by' => Yii::t('app', 'Status Changed By'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[StatusChangedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatusChangedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'status_changed_by']);
    }

    /**
     * Gets query for [[UserNotificationRelations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserNotificationRelations()
    {
        return $this->hasMany(UserNotificationRelation::className(), ['notification_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_notification_relation', ['notification_id' => 'id']);
    }
}
