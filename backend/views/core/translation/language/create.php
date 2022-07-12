<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.3
 */

/* @var $this yii\web\View */
/* @var $model lajax\translatemanager\models\Language */

use lajax\translatemanager\models\Language;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create Language';
$this->params['breadcrumbs'][] = ['label' => 'List of languages', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['enableAjaxValidation' => true,]); ?>
<div class="language-create">
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'language_id')->textInput(['maxlength' => 5]) ?>
            <?= $form->field($model, 'language')->textInput(['maxlength' => 3]) ?>
            <?= $form->field($model, 'country')->textInput(['maxlength' => 3]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>
            <?= $form->field($model, 'name_ascii')->textInput(['maxlength' => 32]) ?>
            <?= $form->field($model, 'status')->dropDownList(Language::getStatusNames()) ?>
        </div>
    </div>
    <div class="row text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>