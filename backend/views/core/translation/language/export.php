<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use lajax\translatemanager\models\ExportForm;
use lajax\translatemanager\models\Language;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;

/* @var $this yii\web\View */
/* @var $model ExportForm */

$this->title = 'Export';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="language-export">
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'exportLanguages')->listBox(ArrayHelper::map(Language::find()->all(), 'language_id', 'name_ascii'), [
                'multiple' => true,
                'size' => 20,
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'format')->radioList([
                Response::FORMAT_JSON => Response::FORMAT_JSON,
                Response::FORMAT_XML => Response::FORMAT_XML,
            ]) ?>
            <?= Html::submitButton('Export', ['class' => 'btn btn-primary']) ?>
       </div>
    </div>
</div>
<?php ActiveForm::end(); ?>