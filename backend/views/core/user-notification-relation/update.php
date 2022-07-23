<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\UserNotificationRelation */

$this->title = Yii::t('app', 'Update User Notification Relation: {name}', [
    'name' => $model->notification_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Notification Relations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->notification_id, 'url' => ['view', 'notification_id' => $model->notification_id, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-notification-relation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
