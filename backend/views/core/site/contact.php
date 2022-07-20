<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model common\models\core\ContactForm */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Yii::t('core_system', 'Contact');
$form = ActiveForm::begin(['id' => 'contact-form']);
?>

<?php
if (Yii::$app->session->hasFlash('contactFormSubmitted')) {
    ?>
    <div class="alert alert-success">
        <?=Yii::t('core_system', 'Thank you for contacting us. We will respond to you as soon as possible.')?>
    </div>
<?php
}
?>

<div class="col-12 mb-4">
    <?=Yii::$app->guides->guideAndHintButton(str_replace(['-', '/'], '', $this->context->module->requestedRoute), false, false) ?>
    <h2><?=$this->title?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h6><?=Yii::t('core_system', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.')?></h6>
        </div>
        <div class="card-body borderTop">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'email') ?>
                    <!--< ?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>-->
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'subject') ?>
                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
                </div>
                <div class="col-12">
                    <?= Html::submitButton(Yii::t('core_quick_payment', 'Send'), ['class' => 'btn btn-warning', 'name' => 'contact-button']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>