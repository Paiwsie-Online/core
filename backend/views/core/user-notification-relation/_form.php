<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\core\UserNotificationRelation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-notification-relation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'notification_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
