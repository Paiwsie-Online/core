<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use lajax\translatemanager\helpers\Language;
use lajax\translatemanager\models\Language as Lang;

/* @var $this \yii\web\View */
/* @var $language_id string */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel lajax\translatemanager\models\searches\LanguageSourceSearch */
/* @var $searchEmptyCommand string */

$this->title = 'Translation into ' . $language_id;
$this->params['breadcrumbs'][] = ['label' => 'List of languages', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::hiddenInput('language_id', $language_id, ['id' => 'language_id', 'data-url' => Yii::$app->urlManager->createUrl('/translatemanager/language/save')]); ?>

<div id="translates" class="<?= $language_id ?>">
    <?php
    Pjax::begin([
        'id' => 'translates',
    ]);
    $form = ActiveForm::begin([
        'method' => 'get',
        'id' => 'search-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
    ]);
    echo '<div class="row">
            <div class="col-md-5">';
    echo $form->field($searchModel, 'source')->dropDownList(['' => 'Original'] + Lang::getLanguageNames(true))->label('Source language');
    echo '</div>
          </div>';
    ActiveForm::end();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'format' => 'raw',
                'filter' => Language::getCategories(),
                'attribute' => 'category',
                'filterInputOptions' => ['class' => 'form-control', 'id' => 'category'],
            ],
            [
                'format' => 'raw',
                'attribute' => 'message',
                'filterInputOptions' => ['class' => 'form-control', 'id' => 'message'],
                'label' => 'Source',
                'content' => function ($data) {
                    return Html::textarea('LanguageSource[' . $data->id . ']', $data->source, ['class' => 'form-control source', 'readonly' => 'readonly']);
                },
            ],
            [
                'format' => 'raw',
                'attribute' => 'translation',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'id' => 'translation',
                    'placeholder' => $searchEmptyCommand ? 'Enter ' . $searchEmptyCommand . ' to search for empty translations.' : '',
                ],
                'label' => 'Translation',
                'content' => function ($data) {
                    return Html::textarea('LanguageTranslate[' . $data->id . ']', $data->translation, ['class' => 'form-control translation', 'data-id' => $data->id, 'tabindex' => $data->id]);
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Action',
                'content' => function ($data) {
                    return Html::button('Save', ['type' => 'button', 'data-id' => $data->id, 'class' => 'btn btn-lg btn-success']);
                },
            ],
        ],
        'emptyText' => ' <i class="fas fa-info-circle fs-5"></i>' . ' ' . Yii::t('core_system', 'No result found'),
    ]);
    Pjax::end();
    ?>

</div>