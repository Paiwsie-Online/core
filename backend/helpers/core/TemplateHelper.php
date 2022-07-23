<?php


namespace backend\helpers\core;


use common\models\core\Language;
use Imagine\Image\ManipulatorInterface;
use Yii;
use yii\bootstrap5\Html;

class TemplateHelper
{
    public function organizationSelection()
    {
        echo "<li class='menu-title'><span data-key='t-menu'>" . Yii::t("core", "Organization") . "</span></li>";
        if (count(Yii::$app->user->identity->organizationList) !== 0) {
            echo "<li class='nav-item'>";
            if (!isset(Yii::$app->user->identity->selectedOrganization)) {
                echo "<a href='#selectOrgMenu' class='nav-link menu-link' data-bs-toggle='collapse' role='button' aria-expanded='false' aria-controls='selectOrgMenu'><i class='mdi mdi-store'></i><span data-key='t-orgSelectMenu'>".Yii::t('core', 'Select organization')."</span></a>";
            } else {
                if (count(Yii::$app->user->identity->organizationList) === 1) {
                    echo "<a href='/site/index' class='nav-link menu-link'><i class='mdi mdi-store'></i><span data-key='t-orgSelectMenu'>".Yii::$app->user->identity->selectedOrganization['name']."</span></a>";
                }
                else {
                    echo "<a href='#selectOrgMenu' class='nav-link menu-link' data-bs-toggle='collapse' role='button' aria-expanded='false' aria-controls='selectOrgMenu'><i class='mdi mdi-store'></i><span data-key='t-orgSelectMenu'>".Yii::$app->user->identity->selectedOrganization['name']."</span></a>";
                }
            }
            if (!isset(Yii::$app->user->identity->selectedOrganization) || count(Yii::$app->user->identity->organizationList) > 1) {
                echo "<div class='collapse menu-dropdown' id='selectOrgMenu'>";
                echo "<ul class='nav nav-sm flex-column'>";
                foreach (Yii::$app->user->identity->organizationList as $id => $name) {
                    if (!isset(Yii::$app->user->identity->selectedOrganization) || Yii::$app->user->identity->selectedOrganization['id'] !== $id) {
                        echo "<li class='nav-item'>";
                        echo Html::a($name, ['organization/change-active'], [
                            'data'=>[
                                'method' => 'post',
                                'params'=>['id'=>$id],
                            ],
                            'class' => 'nav-link menu-link'
                        ]);
                        echo "</li>";
                    }
                }
                echo "</ul>";
                echo "</div>";
            }
            echo "</li>";

        }
        if (!isset(Yii::$app->user->identity->selectedOrganization) && count(Yii::$app->user->identity->organizationList) === 0) {

            echo "<li class='nav-item'><a href='/organization/register-organization' class='nav-link menu-link".((Yii::$app->controller->id === 'organization' && Yii::$app->controller->action->id === 'register-organization') ? ' open active' : '')."'><i class='mdi mdi-plus-circle'></i><span data-key='t-orgSelectMenu'>" . Yii::t('core', 'Add Organization') . "</span></a></li>";
        }
    }

    public function mainNavigation($navigation)
    {
        foreach ($navigation as $nav) {
            if ((isset($nav['visible']) && $nav['visible'] === true) || (!isset($nav['visible']))) {
                if (isset($nav['title'])) {
                    echo "<li class='menu-title'><span data-key='t-menu'>" . ($nav['title'] ?? 'title') . "</span></li>";
                }
                if (isset($nav['items'])) {
                    foreach ($nav['items'] as $item) {
                        if ((isset($item['visible']) && $item['visible'] === true) || (!isset($item['visible']))) {
                            echo "<li class='nav-item'>
                                            <a " . (!isset($item['items']) ? "href='" . ($item['href'] ?? '#') . "'" : "href='#" . str_replace(' ', '', $item['title']) . "'") . " class='nav-link menu-link " . ((isset($item['active']) && $item['active']) ? ' open active' : '') . "' " . (isset($item['items']) ? "data-bs-toggle='collapse' role='button' aria-expanded='false' aria-controls='" . str_replace(' ', '', $item['title']) . "'" : "") . ">";
                            if (isset($item['icon'])) {
                                echo "<i class='{$item['icon']}'></i>";
                            }
                            echo "<span data-key='t-" . ($item['title'] ?? 'title') . "'>" . ($item['title'] ?? 'title') . "</span></a>";
                            if (isset($item['items'])) {
                                ?>
                            <div class="collapse menu-dropdown <?= ((isset($item['active']) && $item['active']) ? ' show' : '') ?>" id="<?= str_replace(' ', '', $item['title']) ?>">
                                    <ul class="nav nav-sm flex-column">
                                <?php
                                foreach ($item['items'] as $navLink) {
                                    if ((isset($navLink['visible']) && $navLink['visible'] === true) || (!isset($navLink['visible']))) {
                                        echo "<li class='nav-item'>
                                                                    <a href='" . ($navLink['href'] ?? '#') . "' class='nav-link " . ((isset($navLink['active']) && $navLink['active']) ? ' active' : '') . "'>";
                                        if (isset($navLink['icon'])) {
                                            echo "<i class='{$navLink['icon']}'></i>";
                                        }
                                        echo "<span data-key='t-" . ($item['title'] ?? 'title') . "'>" . ($navLink['title'] ?? 'title') . "</span>
                                                                    </a>
                                                                </li>";
                                    }
                                }
                                echo "</ul>
                                                </div>";
                            }
                            echo "</li>";
                        }
                    }
                }
            }
        }
    }

    public function languageSelect()
    {
        $currentLanguage = Language::findOne(Yii::$app->language);
        echo "<div class='dropdown ms-1 topbar-head-dropdown header-item'>
            <button type='button' class='btn btn-icon btn-topbar btn-ghost-secondary shadow-none' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <img src='/img/flags/{$currentLanguage->country}.png' alt='user-image' class='me-2' height='25'>
            </button>

            <div class='dropdown-menu dropdown-menu-end'>";

                foreach (Language::getLanguages() as $language) {
                    if ($language->language_id !== Yii::$app->language) {
                        echo Html::a('<img src="/img/flags/'.$language->country.'.png" alt="'.$language->country.' flag" class="me-2" height="25"> ' . $language->name . ($language->status === 2 ? ' <span class="text-warning">' . Yii::t('core_system', 'Beta') . '</span>' : ''), ['/user-setting/set', 'setting' => 'language', 'value' => $language->language_id], [
                            'class' => 'dropdown-item notify-item language',
                            'data' => [
                                'method' => 'post',
                            ],
                        ]);
                    }
                }
        echo "</div></div>";
    }

    public function userMenu($userMenu)
    {
        if (Yii::$app->user->isGuest) {
            echo "<div class='nav-item text-big font-weight-light mr-3 ml-1'><a href='/site/login' title='log in' data-filter-tags='log in'>
                        <i class='fas fa-sign-in-alt navbar-icon align-middle'></i> &nbsp;
                        <span class='nav-link-text'>" . Yii::t('core_system', 'Sign in') . "</span>
                    </a></div>";
        } else {
            echo "<div class='dropdown ms-sm-3 header-item topbar-user'>
                <a href='/site/index' type='button' class='btn shadow-none' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <span class='d-flex align-items-center'>
                        <img src='" . (isset(Yii::$app->user->identity->picture['uri']) ? Yii::$app->thumbnailer->get(Yii::$app->user->identity->picture['uri'], 30, 30, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true) : Yii::$app->thumbnailer->get('/img/avatars/1.png', 30, 30, 100, ManipulatorInterface::THUMBNAIL_OUTBOUND, true)) ."' alt class='d-block w-25 rounded-circle'>
                        <span class='text-start ms-xl-2'>
                            <span class='d-none d-xl-inline-block ms-1 fw-medium user-name-text'>". Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name . "</span>
                            <span class='d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text'>". (Yii::$app->user->identity->organizationUserLevel ? ucfirst(Yii::$app->user->identity->organizationUserLevel) : '') ."</span>
                        </span>

                    </span>
                </a>
                <div class='dropdown-menu dropdown-menu-end'>
                    <h6 class='dropdown-header'>". Yii::t('core_system', 'Welcome') . ' ' . Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name ."</h6>
                    <div class='dropdown-divider'></div>";
                    foreach ($userMenu as $uM) {
                        if ((isset($uM['visible']) && $uM['visible'] === true) || (!isset($uM['visible']))) {
                            echo "<a href='" . ($uM['href'] ?? '#') . "' class='dropdown-item'>";
                            if (isset($uM['icon'])) {
                                echo "<i class='{$uM['icon']} text-muted'></i>";
                            }
                            echo "<span class='align-middle'>" . ($uM['title'] ?? 'Title') . "</span></a>";
                        }
                    }

                    echo "<div class='dropdown-divider'></div>"
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        '<i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">' . Yii::t('core_system', 'Logout') . '</span>',
                        ['class' => 'dropdown-item']
                    )
                    . Html::endForm()
                . "</div>
            </div>";
        }
    }

    public function footerMenu($menuContent)
    {
        echo "<div class='text-sm-end d-none d-sm-block'>";
        foreach ($menuContent as $link) {
            if (!isset($link['visible']) || $link['visible']) {
                if (isset($link['href']) && isset($link['title'])) {
                    echo "<a href='{$link['href']}'>{$link['title']}</a> ";
                } else {
                    if (isset($link['title'])) {
                        echo "<span>{$link['title']}</span> ";
                    }
                }
            }
        }
        echo "</div>";
    }

}