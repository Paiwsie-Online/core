<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\PaiwiseCheckout */

$this->title = 'Create Paiwise Checkout';
$this->params['breadcrumbs'][] = ['label' => 'Paiwise Checkouts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paiwise-checkout-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
