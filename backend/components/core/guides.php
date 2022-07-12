<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\components\core;

use Yii;
use yii\base\Component;

class guides extends Component {

    public function guideAndHintButton($fromView, $guide, $hints) {

        $content = '<div class="guides float-right">';
            $content .= $guide ? "<button type='button' onclick='show_guide(\"{$fromView}\")' class='btn text-warning buttonColor mr-3' id='guideBtn'><i class='fas fa-circle'></i> " . Yii::t('core_system', 'Guide') . "</button>" : "";
            $content .= $hints ? "<button type='button' onclick='show_hints(\"{$fromView}\")' class='btn text-warning buttonColor' id='hintsBtn'><i class='fas fa-circle'></i> " . Yii::t('core_system', 'Hints') . "</button>" : "";
        $content .= '</div>';

        return $content;
    }

}