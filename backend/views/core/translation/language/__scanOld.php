<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.4
 */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $oldDataProvider \yii\data\ArrayDataProvider */

?>
<?php if ($oldDataProvider->totalCount > 1) : ?>

    <?= Html::button('Select all', ['id' => 'select-all', 'class' => 'btn btn-primary']) ?>

    <?= Html::button('Delete selected', ['id' => 'delete-selected', 'class' => 'btn btn-danger']) ?>

<?php endif ?>

<?php if ($oldDataProvider->totalCount > 0) : ?>

    <?=

    GridView::widget([
        'id' => 'delete-source',
        'dataProvider' => $oldDataProvider,
        'columns' => [
            [
                'format' => 'raw',
                'attribute' => '#',
                'content' => function ($languageSource) {
                    return Html::checkbox('LanguageSource[]', false, ['value' => $languageSource['id'], 'class' => 'language-source-cb']);
                },
            ],
            'id',
            'category',
            'message',
            'languages',
            [
                'format' => 'raw',
                'attribute' => 'Action',
                'content' => function ($languageSource) {
                    return Html::a('Delete', Url::toRoute('/translatemanager/language/delete-source'), ['data-id' => $languageSource['id'], 'class' => 'delete-item btn btn-xs btn-danger']);
                },
            ],
        ],
    ]);

    ?>

<?php endif ?>