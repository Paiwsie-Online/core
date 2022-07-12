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
use yii\grid\GridView;
use yii\helpers\Html;
use lajax\translatemanager\models\Language;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel lajax\translatemanager\models\searches\LanguageSearch */

//if (isset(Yii::$app->user->identity->user_level) && Yii::$app->user->identity->user_level === 'SystemAdmin') {
    $this->title = 'List of languages';
    ?>
    <div id="languages">

    <?php
    Pjax::begin([
    'id' => 'languages',
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' =>  'language_id',
                'label' => 'Short Language',
            ],
            [
                'attribute' =>  'name_ascii',
                'label' => 'Language',
            ],
            [
                'attribute' =>  'status',
                'label' => 'Status',
                'filter' => Language::getStatusNames(),
                'value' =>  function ($data) {
                    if ($data->status === 0) {
                        return "Inactive";
                    }
                    if ($data->status === 1) {
                        return "Active";
                    }
                    if ($data->status === 2) {
                        return "Beta";
                    }
                },
            ],
            [
                'format' => 'raw',
                'attribute' => 'Statistic',
                'content' => function ($language) {
                    return '<span class="statistic"><span style="width:' . $language->gridStatistic . '%"></span><i>' . $language->gridStatistic . '%</i></span>';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {translate}',
                'buttons' => [
                    'translate' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['language/translate', 'language_id' => $model->language_id], [
                            'title' => 'Translate',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
        ],
        'emptyText' => ' <i class="fas fa-info-circle fs-5"></i>' . ' ' . Yii::t('core_system', 'No result found'),
    ]);
    Pjax::end();
?>
</div>
<?php
/*} else {
    echo 'You dont have access.';
}*/