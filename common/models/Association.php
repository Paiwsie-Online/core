<?php

namespace common\models;

use common\models\core\OrganizationDetail;
use Yii;

/**
 * @property string $address
 * @property string $street
 * @property string $zip
 * @property string $city
 */

class Association extends core\Organization
{
    public function attributeLabels() {
        $assocLabels = [
            'name' => Yii::t('core_model', 'Association name'),
            'street' =>  Yii::t('core_model', 'Street address'),
            'zip' =>  Yii::t('core_model', 'Zip Code'),
            'city' =>  Yii::t('core_model', 'City'),
            'id' => Yii::t('core_model', 'assocID'),
            'kyc'   =>  Yii::t('core_model', 'Association agreement'),
            'kyc_status_changed' => Yii::t('core_model', 'Association agreement status changed'),
        ];
        return array_replace_recursive(parent::attributeLabels(), $assocLabels);
    }

    public function setAddress($address)
    {
        $detail = new OrganizationDetail();
        $detail->organization_id = $this->id;
        $detail->detail = 'address';
        $detail->value = json_encode($address);
        $detail->save();
    }

    public function getAddress() {
        return OrganizationDetail::find()->where(['organization_id' => $this->id])->andWhere(['detail' => 'address'])->one();
    }
}