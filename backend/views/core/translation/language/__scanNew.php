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

/* @var $this \yii\web\View */
/* @var $newDataProvider \yii\data\ArrayDataProvider */

use yii\grid\GridView;

?>

<?php if ($newDataProvider->totalCount > 0) : ?>

    <?=

    GridView::widget([
        'id' => 'added-source',
        'dataProvider' => $newDataProvider,
        'columns' => [
            'category',
            'message',
        ],
    ]);

    ?>

<?php endif ?>
