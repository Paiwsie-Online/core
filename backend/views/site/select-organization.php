<?php

use yii\bootstrap4\Html; ?>
<div style="display: flex; justify-content: space-evenly">

    <?= Html::a(Yii::t('core_system', 'Create team'), 'create-team', ['class' => 'btn btn-primary mr-3']);
    ?>
    <?= Html::a(Yii::t('core_system', 'Create association'), 'create-assoc', ['class' => 'btn btn-secondary mr-3']);
    ?>



</div>