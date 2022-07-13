<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\NotAcceptableHttpException;
use yii\web\ServerErrorHttpException;

/**
 * @property int $id
 * @property string $uri
 * @property int|null $uploaded_by
 * @property string $uploaded

 * @property User $uploadedBy
 */

class File extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'file';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['uploaded_by'],
                ],
            ],
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['uploaded'],
                ],
            ],
        ];
    }

    public function rules() {
        return [
            [['uri'], 'required'],
            [['id', 'uploaded_by'], 'integer'],
            [['uploaded'], 'safe'],
            [['uri'], 'string', 'max' => 512],
            [['uploaded_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uploaded_by' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'uri' => Yii::t('core_model', 'Uri') . '*',
            'uploaded_by' => Yii::t('core_model', 'Uploaded By'),
            'uploaded' => Yii::t('core_model', 'Uploaded'),
        ];
    }

    // RETURNS THE USER THAT UPLOADED THE FILE
    public function getUploadedBy() {
        return $this->hasOne(User::className(), ['id' => 'uploaded_by']);
    }

    // CHECK IF CURRENT USER HAVE RIGHTS TO PERFORM ACTION ON THIS FILE
    public static function userHaveRights($file_id = null) {
        $accessToken = explode(' ', Yii::$app->request->headers['authorization'])[1];
        $user_id = User::findIdentityByAccessToken($accessToken);
        if ($file_id === null) {
            if (isset($_GET)) {
                $file_id = (int)$_GET['id'];
            } else {
                throw new ServerErrorHttpException(Yii::t('core_system', 'Insurance not set'));
            }
        }
        if ($user_id) {
            $fileExists = File::find()->where(['uploaded_by' => $user_id, 'id' => $file_id])->one();
            if (!$fileExists) {
                throw new NotAcceptableHttpException(Yii::t('core_system', 'This file does not belong to this user'));
            }
            return true;
        } else {
            throw new NotAcceptableHttpException(Yii::t('core_system', 'Not a valid user'));
        }
    }
}