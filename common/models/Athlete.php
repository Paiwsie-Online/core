<?php

namespace common\models;
use common\models\core\Enumeration;
use common\models\core\ObjectDetail;
use common\models\core\ObjectParticipant;
use Yii;

/**
 * This is the model class for table "objects".
 *
 * @property string $first_name
 * @property string $last_name
 * @property Team   $team
 *
 *
 *
 */
class Athlete extends core\Objects
{
    public function rules()
    {
        $athleteRules = [
            [['first_name', 'last_name'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 64],
        ];
        return array_replace_recursive(parent::rules(), $athleteRules);
    }
    public function attributeLabels() {
        $athleteLabels = [
            'first_name' => Yii::t('core_model', 'First name'),
            'last_name' => Yii::t('core_model', 'Last name'),
        ];
        return array_replace_recursive(parent::attributeLabels(), $athleteLabels);
    }
    public function beforeSave($insert)
    {
        if ($insert === true) {
            $this->model = 'common\models\Athlete';
        }
        return parent::beforeSave($insert);
    }
    public function getFirst_name() {
        return $this->getValue('first_name');
    }
    public function getLast_name() {
        return $this->getValue('last_name');
    }
    public function setFirst_name($firstName) {
        $detail = ObjectDetail::findOne(['object' => $this->id, 'detail' => 'first_name']);
        if (!$detail) {
            $detail = new ObjectDetail();
            $detail->object = $this->id;
            $detail->detail = 'first_name';
        }
        $detail->value = (string)$firstName;
        $detail->save();
    }
    public function setLast_name($lastName) {
        $detail = ObjectDetail::findOne(['object' => $this->id, 'detail' => 'last_name']);
        if (!$detail) {
            $detail = new ObjectDetail();
            $detail->object = $this->id;
            $detail->detail = 'last_name';
        }
        $detail->value = (string)$lastName;
        $detail->save();
    }

    public function participantLevels()
    {
        return Enumeration::find()->where(['enumerator'=>'athlete_participant_level'])->all();
    }
    public function defaultParticipantLevel()
    {
        $default = Enumeration::find()->where(['enumerator'=>'athlete_participant_level'])->andWhere(['value'=>'default'])->one();
        return $default->id;
    }

    public function getTeam()
    {
        $relation = $this->hasOne(ObjectParticipant::className(), ['object' => 'id', 'model'=>'common\models\Team']);

    }
}