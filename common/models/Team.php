<?php

namespace common\models;

use common\models\core\OrganizationDetail;
use common\models\core\User;
use phpDocumentor\Reflection\Types\Parent_;
use Yii;


/**
 * @property string $sport
 */

class Team extends core\Organization
{

    public function attributeLabels() {
        $teamLabels = [
            'name' => Yii::t('core_model', 'Team name'),
            'sport' => Yii::t('core_model', 'Sport'),
            'id'=> Yii::t('core_model', 'teamID'),
            'kyc'   =>  Yii::t('core_model', 'Team agreement'),
            'kyc_status_changed' => Yii::t('core_model', 'Team agreement status changed'),
        ];
        return array_replace_recursive(parent::attributeLabels(), $teamLabels);
    }

    public function setSport($sport)
    {
        $detail = new OrganizationDetail();
        $detail->organization_id = $this->id;
        $detail->detail = 'sport';
        $detail->value = $sport;
        $detail->save();
    }

    public function getSport() {
        return OrganizationDetail::find()->where(['organization_id' => $this->id])->andWhere(['detail' => 'sport'])->one();
    }
}