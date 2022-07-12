<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this \yii\web\View */
?>

<div class="col-12 mb-4">
    <h2><?=Yii::t('core_system','Test mode')?></h2>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <?=Yii::t('core_system', 'A organization will be able to leave testmode once a KYC has been approved.<br><br>Write content for what follows between test/live mode what livemode is for etc.<br>What follows:<br>')?>
            <ul>
                <li><?=Yii::t('core_organization', 'Users')?></li>
                <li><?=Yii::t('core_system', 'User rights')?></li>
                <li><?=Yii::t('core_organization', 'User groups')?></li>
                <li><?=Yii::t('core_organization', 'Organizations')?></li>
            </ul>
            <br>
            <?=Yii::t('core_system', 'What is separated')?>:<br>
            <ul>
                <li><?=Yii::t('core_system', 'Accounts')?></li>
                <li><?=Yii::t('core_system', 'Transactions')?></li>
                <li><?=Yii::t('core_quick_payment', 'Quick payments')?></li>
                <li><?=Yii::t('core_quick_payment', 'Settings for quick payments')?></li>
            </ul>
        </div>
    </div>
</div>