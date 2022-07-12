<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\components\core;

use common\models\core\UserSetting;
use onmotion\apexcharts\ApexchartsWidget;
use Yii;
use yii\base\Component;

class makeGraphics extends Component {

    public function generateGraphics($array, $translation) {
        $userSettings = UserSetting::findOne(['user_id' => Yii::$app->user->identity->id, 'setting' => 'theme']);
        echo ApexchartsWidget::widget([
            'type' => 'area',
            'chartOptions' => [
                'colors' => [
                    '#775cdc',  //blue
                    '#28a745',  //green
                    '#17a2b8',  //light blue
                    '#ffc107',  //yellow
                    '#dc3545',  //red
                ],
                'chart' => [
                    'offsetY' => 20,
                    'toolbar' => [
                        'show' => true,
                        'autoSelected' => 'zoom',
                        'tools' => [
                            'download' => false,
                        ],
                    ],
                ],
                'xaxis' => [
                    'type' => 'datetime',
                    'labels' => [
                        'style' => [
                            'colors' => (isset($userSettings) && $userSettings->value === 'light' ? '#000000' : '#FFFFFF'),
                        ]
                    ],
                ],
                'yaxis' => [
                    'title' => [
                        'text' => $translation,
                        'style' => [
                            'color' => (isset($userSettings) && $userSettings->value === 'light' ? '#000000' : '#FFFFFF'),
                        ]
                    ],
                    'labels' => [
                        'style' => [
                            'colors' => (isset($userSettings) && $userSettings->value === 'light' ? '#000000' : '#FFFFFF'),
                        ]
                    ],
                ],
                'dataLabels' => [
                    'enabled' => false
                ],
                'tooltip' => [
                    'fillSeriesColor' => true,
                    'x' => [
                        'show' => false,
                    ],
                ],
                'stroke' => [
                    'show' => true,
                    'curve' => 'straight',  //smooth  'curve',
                    'width' => 2
                    //'colors' => ['transparent']   'border line'
                ],
                'legend' => [
                    'position' => 'top',
                    'horizontalAlign' => 'left',
                    'labels' => [
                        'colors' => (isset($userSettings) && $userSettings->value === 'light' ? '#000000' : '#FFFFFF'),
                    ],
                ],
            ],
            'series' => $array,
        ]);
    }

}