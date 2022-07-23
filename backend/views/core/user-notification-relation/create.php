<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\UserNotificationRelation */

$this->title = Yii::t('app', 'Create User Notification Relation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Notification Relations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-notification-relation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
