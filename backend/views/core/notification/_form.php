<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\core\Notification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category')->dropDownList([ 'alert' => 'Alert', 'message' => 'Message', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'priority')->dropDownList([ 'low' => 'Low', 'medium' => 'Medium', 'high' => 'High', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'notification_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'unread' => 'Unread', 'seen' => 'Seen', 'clicked' => 'Clicked', 'deleted' => 'Deleted', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status_changed')->textInput() ?>

    <?= $form->field($model, 'status_changed_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
