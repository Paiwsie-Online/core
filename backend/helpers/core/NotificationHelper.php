<?php


namespace backend\helpers\core;


use common\models\core\User;
use Yii;

class NotificationHelper
{
    public $user;
    public $newNotifications;
    public $newNotificationsCount;
    public $newMessages;
    public $newMessagesCount;
    public $newAlerts;
    public $newAlertsCount;

    public function __construct()
    {
        $this->user = User::findOne(Yii::$app->user->identity->id);
        $this->newNotifications = $this->user->notifications;
        $this->newNotificationsCount = count($this->newNotifications);
        $this->newMessages = $this->user->getNotifications('message');
        $this->newMessagesCount = count($this->newMessages);
        $this->newAlerts = $this->user->getNotifications('alert');
        $this->newAlertsCount = count($this->newAlerts);
    }

    public function alertBell()
    {
        ob_start();
        ?>
        <div class='dropdown topbar-head-dropdown ms-1 header-item'>
                        <button type='button' class='btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none' id='page-header-notifications-dropdown' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='bx bx-bell fs-22'></i>
                            <?php
        if ($this->newNotificationsCount !== 0) {
            echo "<span class='position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger' id='notificationBellBadge'><span id='notificationBellBadgeCount'>".$this->newNotificationsCount."</span><span class='visually-hidden'>unread messages</span></span>";
        }
        ?>
        </button>
                        <div class='dropdown-menu dropdown-menu-lg dropdown-menu-end p-0' aria-labelledby='page-header-notifications-dropdown' id='notificationDropdownDiv'>
        <h2>Loading...</h2>
        </div></div>
        <?php
        return ob_get_clean();
    }

    public function alertDropdownContent()
    {
        ob_start();
        ?>
        <div class='dropdown-head bg-primary bg-pattern rounded-top'>
                                <div class='p-3'>
                                    <div class='row align-items-center'>
                                        <div class='col'>
                                            <h6 class='m-0 fs-16 fw-semibold text-white'> Notifications </h6>
                                        </div>
                                        <div class='col-auto dropdown-tabs'>
                                            <span class='badge badge-soft-light fs-13' id="totalNotificationsBadge" style="display:none"> <span id="totalNotificationsBadgeNumber"><?=$this->newNotificationsCount?></span> New</span>
                                        </div>
                                    </div>
                                </div>
                                <div class='px-2 pt-2'>
                                    <ul class='nav nav-tabs dropdown-tabs nav-tabs-custom' data-dropdown-tabs='true' id='notificationItemsTab' role='tablist'>
                                        <li class='nav-item waves-effect waves-light'>
                                            <a class='nav-link<?= ($this->newMessagesCount !== 0 || $this->newAlertsCount === 0 ? ' active' : '') ?>' data-bs-toggle='tab' href='#messages-tab' role='tab' aria-selected='true'>Messages<span id="messageCounterSpan"><?= ($this->newMessagesCount !== 0 ? " ({$this->newMessagesCount})" : "") ?></span></a>
                                        </li>
                                        <li class='nav-item waves-effect waves-light'>
                                            <a class='nav-link<?= ($this->newAlertsCount !== 0 && $this->newMessagesCount === 0 ? ' active': '') ?>' data-bs-toggle='tab' href='#alerts-tab' role='tab' aria-selected='false'>Alerts <span id="alertCounterSpan"><?= ($this->newAlertsCount !== 0 ? " ({$this->newAlertsCount})" : "") ?></span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class='tab-content' id='notificationItemsTabContent'>

                                <div class='tab-pane fade py-2 ps-2<?= ($this->newMessagesCount !== 0 || $this->newAlertsCount === 0 ? ' show active' : '') ?>' id='messages-tab' role='tabpanel' aria-labelledby='messages-tab'>
                                    <div data-simplebar style='max-height: 300px;' class='pe-2'>

                                        <?php
                                        if ($this->newMessagesCount !== 0) {
                                            foreach ($this->newMessages as $notification) {
                                                echo $this->notificationItem($notification);
                                            }

                                        } else {
                                            ?>
                                            <div class='w-25 w-sm-50 pt-3 mx-auto'>
                                                <img src='/img/svg/bell.svg' class='img-fluid' alt='user-pic'>
                                            </div>
                                            <div class='text-center pb-5 mt-2'>
                                                <h6 class='fs-18 fw-semibold lh-base'>Hey! You have no new messages </h6>
                                            </div>
                                            <?php
                                        }

                                        ?>
                                        <div class='my-3 text-center'>
                                            <button type='button' class='btn btn-soft-success waves-effect waves-light'>View
                                                All Messages <i class='ri-arrow-right-line align-middle'></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class='tab-pane fade p-4<?= ($this->newAlertsCount !== 0 && $this->newMessagesCount === 0 ? ' show active': '') ?>' id='alerts-tab' role='tabpanel' aria-labelledby='alerts-tab'>
                                    <?php
                                    if ($this->newAlertsCount !== 0) {
                                        foreach ($this->newAlerts as $notification) {
                                            echo $this->notificationItem($notification);
                                        }

                                    } else {
                                    ?>
                                    <div class='w-25 w-sm-50 pt-3 mx-auto'>
                                        <img src='/img/svg/bell.svg' class='img-fluid' alt='user-pic'>
                                    </div>
                                    <div class='text-center pb-5 mt-2'>
                                        <h6 class='fs-18 fw-semibold lh-base'>Hey! You have no new notifications </h6>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <div class='my-3 text-center'>
                                        <button type='button' class='btn btn-soft-success waves-effect waves-light'>View
                                            All Alerts <i class='ri-arrow-right-line align-middle'></i></button>
                                    </div>
                                </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function notificationItem($notification)
    {
        $data = [
            'image' => 'https://back.core.test/img/users/avatar-2.jpg',
            'heading' => 'Angela Bernier',
            'message' => 'Answered to your comment on the cash flow forecast\'s graph 🔔.',
            'link' => '#!'
        ];
        $data = json_decode($notification->notification_data);
        ob_start();
        ?>
        <div class='text-reset notification-item d-block dropdown-item position-relative' onmouseover="setRead(<?=$notification->id?>)">
            <div class='d-flex'>
                <img src='<?= $data->image ?>' class='me-3 rounded-circle avatar-xs' alt='user-pic'>
                <div class='flex-1'>
                    <a href='<?= $data->link ?>' class='stretched-link'>
                        <h6 class='mt-0 mb-1 fs-13 fw-semibold'><?= $data->heading ?></h6>
                    </a>
                    <div class='fs-13 text-muted'>
                        <p class='mb-1'><?= $data->message ?></p>
                    </div>
                    <p class='mb-0 fs-11 fw-medium text-uppercase text-muted'>
                        <span><i class='mdi mdi-clock-outline'></i> 48 min ago</span>
                    </p>
                </div>
                <div class='px-2 fs-15'>
                    <?php
                    $icon = ($notification->category === "message" ? "mdi mdi-email" : "mdi mdi-bell-alert-outline");
                    echo "<i class='{$icon}'></i>";
                    ?>

                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}