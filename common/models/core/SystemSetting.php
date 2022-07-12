<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use DateTime;
use Yii;

/**
 * @property int $id
 * @property string $setting
 * @property string $value
 */

class SystemSetting extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'system_setting';
    }

    public function rules() {
        return [
            [['setting', 'value'], 'required'],
            [['value'], 'string'],
            [['setting'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'setting' => Yii::t('core_model', 'Setting'),
            'value' => Yii::t('core_model', 'Value'),
        ];
    }

    //RETURN ARRAY WITH VALUES OF DATES
    public static function getOptionsDates() {
        $array = [];
        $array[] = [
            'value' => json_encode([
                'start' => date('Y-m-d', strtotime('monday this week')),
                'end' => date('Y-m-d', strtotime('sunday this week')),
            ]),
            'label' => 'This Week'
        ];
        $array[] = [
            'value' => json_encode([
                'start' => date('Y-m-d', strtotime('first day of this month')),
                'end' => date('Y-m-d', strtotime('last day of this month')),
            ]),
            'label' => 'This Month'
        ];
        $currentQuarter = ceil(date('n') / 3);
        $array[] = [
            'value' => json_encode([
                'start' => date('Y-m-d', strtotime(date('Y') . '-' . (($currentQuarter * 3) - 2) . '-1')),
                'end' => date('Y-m-t', strtotime(date('Y') . '-' . (($currentQuarter * 3)) . '-1')),
            ]),
            'label' => 'This Quarter'
        ];
        $array[] = [
            'value' => json_encode([
                'start' => date('Y-m-d', strtotime('first day of January this year')),
                'end' => date('Y-m-d', strtotime('last day of December this year')),
            ]),
            'label' => 'This Year'
        ];
        $array[] = [
            'value' => json_encode([
                'start' => date('Y-m-d', strtotime('monday last week')),
                'end' => date('Y-m-d', strtotime('sunday last week')),
            ]),
            'label' => 'Last Week'
        ];
        $array[] = [
            'value' => json_encode([
                'start' => date('Y-m-d', strtotime('first day of last month')),
                'end' => date('Y-m-d', strtotime('last day of last month')),
            ]),
            'label' => 'Last Month'
        ];
        $array[] = [
            'value' => json_encode([
                'start' => (new DateTime('first day of -' . (((date('n') - 1) % 3) + 3) . ' month'))->format('Y-m-d'),
                'end' => (new DateTime('last day of -' . (((date('n') - 1) % 3) + 1) . ' month'))->format('Y-m-d'),
            ]),
            'label' => 'Last Quarter'
        ];
        $array[] = [
            'value' => json_encode([
                'start' => date('Y-m-d', strtotime('first day of January last year')),
                'end' => date('Y-m-d', strtotime('last day of December last year')),
            ]),
            'label' => 'Last Year'
        ];
        $array[] = [
            'value' => 'other',
            'label' => 'Other'
        ];
        return $array;
    }

}