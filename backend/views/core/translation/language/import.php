<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use lajax\translatemanager\models\ImportForm;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ImportForm */

$this->title = 'Import';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="language-export col-sm-6">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->field($model, 'importFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>