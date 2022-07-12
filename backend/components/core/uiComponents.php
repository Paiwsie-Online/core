<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\components\core;

use DateTime;
use DateTimeZone;
use Yii;
use yii\base\Component;

class uiComponents extends Component {

    public function organizationSettingsSidebar() {
        $navigation = [
            [
                'items'  => [
                    [
                        'title' =>  Yii::t('core_organization', 'Info'),
                        'href'  =>  '/organization-setting/organization-details',
                        'icon'  =>  'fas fa-edit',
                    ],
                    [
                        'title' =>  Yii::t('core_system', 'Bank Info'),
                        'href'  =>  '/organization-setting/bank-info',
                        'icon'  =>  'fas fa-university',
                    ],
                    [
                        'title' =>  Yii::t('core_system', 'Content'),
                        'href'  =>  '/organization-setting/content',
                        'icon'  =>  'fas fa-mail-bulk',
                    ],
                ]
            ],
        ];
        ?>
        <div class="card-header pb-2">
            <h4><?=Yii::t('core_organization', 'Organization Details')?></h4>
        </div>
        <div class="card-body borderTop">
            <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical col-md-12"> <!--theme-bg-white-->
                <ul class="sidenav-inner py-1">
                    <?php
                    foreach ($navigation as $nav) {
                        if ((isset($nav['visible']) && $nav['visible'] === true) || (!isset($nav['visible']))) {
                            if (isset($nav['title'])) {
                                echo "<li class='sidenav-header".($nav['css'] ?? '')."'>".($nav['title'] ?? 'title')."</li>";
                            }
                            if (isset($nav['items'])) {
                                foreach ($nav['items'] as $item) {
                                    if ((isset($item['visible']) && $item['visible'] === true) || (!isset($item['visible']))) {
                                        echo "<li class='sidenav-item ".($item['css'] ?? '')." ".((isset($item['active']) && $item['active']) ? ' open active' : '')."'>
                                                            <a href='".($item['href'] ?? '#')."' class='sidenav-link".(isset($item['items']) ? 'sidenav-toggle' : '')."'>";
                                        if (isset($item['icon'])) {
                                            echo "<i class='sidenav-icon {$item['icon']}'></i>";
                                        }
                                        echo "<div>".($item['title'] ?? 'title')."</div></a>";
                                        if (isset($item['items'])) {
                                            echo "<ul class='sidenav-menu'>";
                                            foreach ($item['items'] as $navLink) {
                                                if ((isset($navLink['visible']) && $navLink['visible'] === true) || (!isset($navLink['visible']))) {
                                                    echo "<li class='sidenav-item ".($navLink['css'] ?? '')." ".((isset($navLink['active']) && $navLink['active']) ? ' active' : '')."'>
                                                                        <a href='".($navLink['href'] ?? '#')."' class='sidenav-link'>";
                                                    if (isset($navLink['icon'])) {
                                                        echo "<i class='sidenav-icon {$navLink['icon']}'></i>";
                                                    }
                                                    echo "<div>".($navLink['title'] ?? 'title')."</div>
                                                                    </a>
                                                                </li>";
                                                }
                                            }
                                            echo "</ul>";
                                        }
                                        echo "</li>";
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    <?php
    }

    public function getSystemTime() {
        $dt = new DateTime('now', new DateTimeZone(Yii::$app->params['defaults']['systemTimeZone']));
        return $dt->format('Y-m-d H:i:s');
    }

}