<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\core\PaiwiseCheckoutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Paiwise Checkouts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paiwise-checkout-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Paiwise Checkout', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'model',
            'model_id',
            'amount',
            'checkout_id',
            //'status',
            //'status_changed',
            //'checkout_data:ntext',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
