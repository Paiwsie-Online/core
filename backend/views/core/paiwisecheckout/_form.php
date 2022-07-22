<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\core\PaiwiseCheckout */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paiwise-checkout-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model_id')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'checkout_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'created' => 'Created', 'reserved' => 'Reserved', 'reserve released' => 'Reserve released', 'paid' => 'Paid', 'refunded' => 'Refunded', 'revoked' => 'Revoked', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status_changed')->textInput() ?>

    <?= $form->field($model, 'checkout_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
