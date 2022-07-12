<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\Organization;
use common\models\core\Picture;
use common\models\core\SystemContent;
use common\models\core\SystemLog;
use Yii;
use common\models\core\OrganizationSetting;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class OrganizationSettingController extends BaseController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['organization-details', 'save-setting', 'delete-logo', 'bank-info', 'content', 'delete'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect('/site/loginqr');
                    } else {
                        throw new ForbiddenHttpException('');
                    }
                },
                'rules' => [
                    [
                        'actions' => ['organization-details', 'bank-info', 'delete-logo', 'content', 'delete'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->checkUserLevel() === true) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['save-setting'],
                        'allow' => isset(Yii::$app->user->identity, Yii::$app->user->identity->selectedOrganization->id),
                        'matchCallback' => function ($rule, $action) {
                            $hasAccess = false;
                            if (Yii::$app->user->identity->hasAccess('quickPayment', 'update')) {
                                $hasAccess = true;
                            }
                            return $hasAccess;
                        },
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'organization-details' => ['GET', 'POST'],
                    'save-setting' => ['GET', 'POST', 'PUT', 'PATCH'],
                    'delete-logo' => ['GET', 'POST', 'DELETE'],
                    'bank-info' => ['GET', 'POST'],
                    'content' => ['GET', 'POST', 'PUT', 'PATCH'],
                    'delete' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    public function actionSaveSetting() {
        $setting = $_POST['setting'];
        $value = $_POST['value'];
        $organization_id = ($_POST['organizationId'] ?? Yii::$app->user->identity->selectedOrganization['id']);
        $model = OrganizationSetting::find()->where(['organization_id' => $organization_id, 'setting' => $setting])->one();
        if (!$model) {
            $model = new OrganizationSetting();
            $model->organization_id = $organization_id;
            $model->setting = $setting;
        }
        $model->value = $value;
        if ($model->save()) {
            $systemLog = new SystemLog();
            $systemLog->user_id = Yii::$app->user->identity->id;
            $systemLog->organization_id = $organization_id;
            $systemLog->instance = Yii::$app->user->identity->instance;
            $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed setting: ' . $model->setting;
            $systemLog->message = (Yii::$app->user->identity->first_name ?? '') . ' ' . (Yii::$app->user->identity->last_name ?? '') . ' changed setting: ' . $model->setting . ' to: ' . ($model->value ?? 'Error');
            $dataFormat = [
                'event' => 'changedSetting',
                'user' => Yii::$app->user->identity->id,
                'organization' => $model->organization_id,
                'setting' => $model->setting,
                'value' => $model->value,
            ];
            $systemLog->data_format = json_encode($dataFormat);
            $systemLog->save();
        }
    }

    public function actionDeleteLogo($id, $setting, $logo) {
        $model = OrganizationSetting::findOne(['organization_id' => $id, 'setting' => $setting]);
        $valueDecoded = json_decode($model->value);
        $valueDecoded->organization_logo = '';
        $valueEncoded = json_encode($valueDecoded);
        $model->value = $valueEncoded;
        $model->save();
        $picture = Picture::findOne(['id' => $logo]);
        unlink(__DIR__ . '/../../web' . $picture->uri);
        $picture->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findModel($organization_id, $setting) {
        if (($model = OrganizationSetting::findOne(['organization_id' => $organization_id, 'setting' => $setting])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('core_system', 'The requested page does not exist'));
    }

    public function actionOrganizationDetails() {
        $id = Yii::$app->user->identity->selectedOrganization->id;
        $model = OrganizationSetting::findOne(['organization_id' => $id, 'setting' => 'organizationDetails']);
        if (!isset($model)) {
            $model = new OrganizationSetting();
            $model->organization_id = $id;
            $model->setting = 'organizationDetails';
            $valueArray = [
                'sms_name' => '',
                'contact_email' => [
                    '',
                ],
                'contact_phone' => '',
                'website' => '',
                'billing_address' => '',
                'visiting_address' => '',
                'organization_logo' => ''
            ];
            $valueEncoded = json_encode($valueArray);
            $model->value = $valueEncoded;
            $model->save();
        }
        if ($model->load(Yii::$app->request->post())) {
            $organizationSetting = OrganizationSetting::findOne(['organization_id' => $id, 'setting' => 'organizationDetails']);
            $value = json_decode($organizationSetting->value, true);
            if (empty($_POST['sms_name']) || !isset($_POST['sms_name']) || $_POST['sms_name'] === ' ') {
                $sms_name = $value['sms_name'];
            } else {
                $sms_name = $_POST['sms_name'];
            }
            if (empty($_POST['contact_email']) || !isset($_POST['contact_email'])) {
                if ($value['contact_email'] !== '') {
                    $contact_email = '';
                } else {
                    $contact_email = $value['contact_email'];
                }
            } elseif ($_POST['contact_email'] === ' ') {
                $contact_email = $value['contact_email'];
            } elseif ((!empty($_POST['contact_email']) || isset($_POST['contact_email'])) && $_POST['contact_email'] !== ' ') {
                if (is_array($value['contact_email'])) {
                    foreach ($value['contact_email'] as $cm) {
                        if ($cm !== '') {
                            $checkPluralEmails = strpos($_POST['contact_email'], ',');
                            if ($checkPluralEmails !== false) {
                                $emailsArray = explode(',', strtolower($_POST['contact_email']));
                                $contact_email = $emailsArray;
                            } else {
                                $contact_email = [
                                    strtolower($_POST['contact_email']),
                                ];
                            }
                        } else {
                            $contact_email = [
                                strtolower($_POST['contact_email']),
                            ];
                        }
                    }
                } else {
                    $contact_email = [
                        strtolower($_POST['contact_email']),
                    ];
                }
            }
            if (empty($model->contact_phone) || !isset($model->contact_phone)) {
                if ($value['contact_phone'] !== '') {
                    $contact_phone = '';
                } else {
                    $contact_phone = $model->contact_phone;
                }
            } elseif ($model->contact_phone === ' ') {
                $contact_phone = $model->contact_phone;
            } elseif ((!empty($model->contact_phone) || isset($model->contact_phone)) && $model->contact_phone !== ' ') {
                $contact_phone = $model->contact_phone;
            }
            if (empty($_POST['website']) || !isset($_POST['website']) || $_POST['website'] === ' ') {
                $website = $value['website'];
            } else {
                $website = $_POST['website'];
            }
            if (empty($_POST['billing_address']) || !isset($_POST['billing_address']) || $_POST['billing_address'] === ' ') {
                $billing_address = $value['billing_address'];
            } else {
                $billing_address = $_POST['billing_address'];
            }
            if (empty($_POST['visiting_address']) || !isset($_POST['visiting_address']) || $_POST['visiting_address'] === ' ') {
                $visiting_address = $value['visiting_address'];
            } else {
                $visiting_address = $_POST['visiting_address'];
            }
            $filesTemp = UploadedFile::getInstances($model, 'file');
            if (isset($filesTemp) && !empty($filesTemp) && $model->validate()) {
                $date = date('YmdHis');
                foreach ($filesTemp as $file) {
                    $fileName = str_replace(' ', '-', $file->baseName);
                    if (!file_exists(__DIR__ . '/../../web/uploads/organizationLogo/')) {
                        mkdir(__DIR__ . '/../../web/uploads/organizationLogo/', 0777, true);
                    }
                    $file->saveAs(__DIR__ . '/../../web/uploads/organizationLogo/' . $date . '_' . $fileName . '.' . $file->extension);
                    if ($value['organization_logo'] === '') {
                        $files = new Picture();
                    } else {
                        $files = Picture::findOne(['id' => $value['organization_logo']]);
                    }
                    $files->uri = '/uploads/organizationLogo/' . $date . '_' . $fileName . '.' . $file->extension;
                    $files->uploaded_by = Yii::$app->user->identity->id;
                    $files->save();
                }
                $organization_logo = $files->id;
            } else {
                $organization_logo = $value['organization_logo'];
            }
            $valueArray = [
                'sms_name' => $sms_name,
                'contact_email' => $contact_email,
                'contact_phone' => $contact_phone,
                'website' => $website,
                'billing_address' => $billing_address,
                'visiting_address' => $visiting_address,
                'organization_logo' => $organization_logo,
            ];
            $valueEncoded = json_encode($valueArray);
            $model->value = $valueEncoded;
            if ($model->save()) {
                $organization = Organization::findOne(['id' => Yii::$app->user->identity->selectedOrganization->id]);
                if (empty($_POST['public_name']) || !isset($_POST['public_name']) || $_POST['public_name'] === ' ') {
                    $public_name = $organization->name;
                } else {
                    $public_name = $_POST['public_name'];
                }
                if (empty($_POST['legal_name']) || !isset($_POST['legal_name']) || $_POST['legal_name'] === ' ') {
                    $legal_name = $organization->legal_name;
                } else {
                    $legal_name = $_POST['legal_name'];
                }
                $organization->name = $public_name;
                $organization->legal_name = $legal_name;
                $organization->save();
                /*$systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = $id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' changed setting: ' . $model->setting;
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' changed setting: ' . $model->setting .' to: ' . ($model->value ?? 'Error');
                $dataFormat = [
                    'event' =>  'changedSetting',
                    'user'  =>  Yii::$app->user->identity->id,
                    'organization'   =>  $model->organization_id,
                    'setting'  =>  $model->setting,
                    'value' => $model->value,
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();*/
                return $this->redirect('organization-details');
            }
        }
        return $this->render('organization_details', [
            'model' => $this->findModel($id, 'organizationDetails'),
        ]);
    }

    public function actionBankInfo() {
        $id = Yii::$app->user->identity->selectedOrganization->id;
        $model = OrganizationSetting::findOne(['organization_id' => $id, 'setting' => 'bankInfo']);
        if (!isset($model)) {
            $model = new OrganizationSetting();
            $model->organization_id = $id;
            $model->setting = 'bankInfo';
            $valueArray = [
                'bank_name' => '',
                'clearing_number' => '',
                'account_number' => '',
            ];
            $valueEncoded = json_encode($valueArray);
            $model->value = $valueEncoded;
            $model->save();
        }
        if (!empty($_POST)) {
            $organizationSetting = OrganizationSetting::findOne(['organization_id' => $id, 'setting' => 'bankInfo']);
            $value = json_decode($organizationSetting->value, true);
            if ($_POST['bank_name'] === ' ') {
                $bank_name = $value['bank_name'];
            } else {
                $bank_name = $_POST['bank_name'];
            }
            if ($_POST['clearing_number'] === ' ') {
                $clearing_number = $value['clearing_number'];
            } else {
                $clearing_number = $_POST['clearing_number'];
            }
            if ($_POST['account_number'] === ' ') {
                $account_number = $value['account_number'];
            } else {
                $account_number = $_POST['account_number'];
            }
            $valueArray = [
                'bank_name' => $bank_name,
                'clearing_number' => $clearing_number,
                'account_number' => $account_number,
            ];
            $valueEncoded = json_encode($valueArray);
            $model->value = $valueEncoded;
            if ($model->save()) {
                /*
                $systemLog = new SystemLog();
                $systemLog->user_id = Yii::$app->user->identity->id;
                $systemLog->organization_id = $id;
                $systemLog->instance = Yii::$app->user->identity->instance;
                $systemLog->message_short = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' changed setting: ' . $model->setting;
                $systemLog->message = (Yii::$app->user->identity->first_name ?? '').' '.(Yii::$app->user->identity->last_name ?? '').' changed setting: ' . $model->setting .' to: ' . ($model->value ?? 'Error');
                $dataFormat = [
                    'event' =>  'changedSetting',
                    'user'  =>  Yii::$app->user->identity->id,
                    'organization'   =>  $model->organization_id,
                    'setting'  =>  $model->setting,
                    'value' => $model->value,
                ];
                $systemLog->data_format = json_encode($dataFormat);
                $systemLog->save();
                */
                return $this->redirect('bank-info');
            }
        }
        return $this->render('bank_info', [
            'model' => $this->findModel($id, 'bankInfo'),
        ]);
    }

    public function actionContent() {
        if (!empty($_POST)) {
            if (isset($_POST['OrganizationSetting']['signature'])) {
                $organizationSettings = OrganizationSetting::findOne(['organization_id' => Yii::$app->user->identity->selectedOrganization->id, 'setting' => 'content_email_signature']);
                if (isset($organizationSettings)) {
                    $model = $organizationSettings;
                } else {
                    $model = new OrganizationSetting();
                }
                if ($_POST['OrganizationSetting']['signature'] !== '') {
                    $model->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                    $model->setting = 'content_email_signature';
                    $model->value = $_POST['OrganizationSetting']['signature'];
                    $model->save();
                } else {
                    $model->delete();
                }
            }
            if (isset($_POST['OrganizationSetting']['inviteUser'])) {
                $organizationSettings = OrganizationSetting::findOne(['organization_id' => Yii::$app->user->identity->selectedOrganization->id, 'setting' => 'content_email_inviteUser']);
                if (isset($organizationSettings)) {
                    $model = $organizationSettings;
                } else {
                    $model = new OrganizationSetting();
                }
                if ($_POST['OrganizationSetting']['inviteUser'] !== '') {
                    $model->organization_id = Yii::$app->user->identity->selectedOrganization->id;
                    $model->setting = 'content_email_inviteUser';
                    $model->value = $_POST['OrganizationSetting']['inviteUser'];
                    $model->save();
                } else {
                    $model->delete();
                }
            }
        }
        $model = new OrganizationSetting();
        $signature = OrganizationSetting::findOne(['organization_id' => Yii::$app->user->identity->selectedOrganization->id, 'setting' => 'content_email_signature']);
        if (isset($signature)) {
            $model->signature = $signature->value;
        } else {
            $defaultSignature = SystemContent::findOne(['instance' => 'default', 'content' => 'content_email_signature']);
            $model->signature = Yii::t('system_content', $defaultSignature->value);
        }
        $inviteUser = OrganizationSetting::findOne(['organization_id' => Yii::$app->user->identity->selectedOrganization->id, 'setting' => 'content_email_inviteUser']);
        if (isset($inviteUser)) {
            $model->inviteUser = $inviteUser->value;
        } else {
            $defaultInviteUser = SystemContent::findOne(['instance' => 'default', 'content' => 'content_email_inviteUser']);
            $model->inviteUser = Yii::t('system_content', $defaultInviteUser->value);
        }
        return $this->render('content', [
            'model' => $model,
        ]);
    }

}