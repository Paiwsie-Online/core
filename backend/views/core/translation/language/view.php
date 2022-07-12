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
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lajax\translatemanager\models\Language */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'List of languages', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-view col-sm-6">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'language_id',
            'language',
            'country',
            'name',
            'name_ascii',
            [
                'label' => 'Status',
                'value' => $model->getStatusName(),
            ],
            [
                'label' => 'Translation status',
                'value' => $model->getGridStatistic() . '%',
            ],
        ],
    ])
    ?>
    <p style="text-align: right">
        <?= Html::a('Update', ['update', 'id' => $model->language_id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->language_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
</div>