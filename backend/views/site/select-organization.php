<?php

use common\models\Association;
use common\models\Team;
use yii\bootstrap5\Html;
use yii\helpers\Url; ?>

<div style="display: flex; justify-content: space-evenly">

    <?= Html::a(Yii::t('core_system', 'Create team'), '/team/create-team', ['class' => 'btn btn-primary mr-3']);
    ?>
    <?= Html::a(Yii::t('core_system', 'Create association'), '/association/create-association', ['class' => 'btn btn-secondary mr-3']);
    ?>
</div>

<div style="display: flex; justify-content: space-around">
<div>
    <?php
/*    echo "<pre>";
    var_dump(Yii::$app->user->identity->teamList);
    echo "</pre>";*/

    foreach(Yii::$app->user->identity->teamList as $teamID=>$teamName) {
        echo Html::a($teamName, '/team/login-team', [
            'class' => 'btn btn-block btn-success',
            'data' => [
                    'method' => 'post',
                    'params' => ['teamID'=>$teamID]
            ],
        ]);
    }
    ?>
</div>

<div>
    <?php

    foreach(Yii::$app->user->identity->assocList as $assocID=>$assocName) {
        echo Html::a($assocName, '/association/login-association', [
            'class' => 'btn btn-block btn-success',
            'data' => [
                'method' => 'post',
                'params' => ['assocID'=>$assocID]
            ],
        ]);
    }

    ?>
</div>
</div>