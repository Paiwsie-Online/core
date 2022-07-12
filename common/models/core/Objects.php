<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use Yii;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "objects".
 *
 * @property int $id
 * @property string $model
 *
 * @property ObjectDetail[] $objectDetails
 * @property ObjectParticipant[] $objectParticipants
 */
class Objects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model'], 'required'],
            [['model'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('core_model', 'ID'),
            'model' => Yii::t('core_model', 'Model'),
        ];
    }

    /**
     * Gets query for [[ObjectDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjectDetails()
    {
        return $this->hasMany(ObjectDetail::className(), ['object' => 'id']);
    }

    // Used by standard CRUD - Index
   /* public static function find()
    {
        if (!Yii::$app->user->identity) {
            throw new ServerErrorHttpException(Yii::t('core_system', 'No logged user'));
        } elseif (isset(Yii::$app->request->headers['authorization'])) {
            $bearerToken = explode(' ', Yii::$app->request->headers['authorization'])[1];
            $numPath = count(explode('/', Yii::$app->request->pathInfo));
            $user_id = User::findIdentityByAccessToken($bearerToken);*/

/*            $userModel = new Yii::$app->controller->modelClass;
            $columns = $userModel->rules()[0][0];
            $aaa = [];

            $bbb = [];
            $i = 0;
            foreach ($columns as $column) {
                $values = ObjectDetail::findAll(['detail' => $column]);
                foreach ($values as $value) {
                    $ii = 0;
                    foreach ($value as $key => $item) {

                        $aaa[$ii] = [
                            $key => $item
                        ];
                        $ii++;
                    }
                    $bbb[$i] = $aaa;
                }
                $i++;
            }*/

           /* $condition = 0;
            if ($numPath > 1) {
                $condition = explode('/', Yii::$app->request->pathInfo)[$numPath - 1];
                $participants = ObjectParticipant::findAll(['object' => (int)$condition]);
                foreach ($participants as $p) {
                    $actualModel = ucfirst(explode('\\', $p->model)[count(explode('\\', $p->model)) - 1]);
                    if ($actualModel === 'User') {
                        $userModel = new $p->model;
                        $user = $userModel::findOne($p->model_id);
                        $action = Yii::$app->controller->action->id;
                        if ($user->id === $p->model_id) {
                            //$rights = 
                        }
                    } elseif ($actualModel === 'Organization') {
                        $organizationModel = new $p->model;
                        $organization = $organizationModel::findOne($p->model_id);
                    } else {
                        throw new ServerErrorHttpException(Yii::t('core_system', 'Something went wrong with the request'));
                    }
                }
            } else {
                $participants = ObjectParticipant::findAll(['model' => '\common\models\user', 'model_id' => $user_id->id]);
                //$modelUsed = Yii::$app->controller->modelClass;
                //$returnArr = [];
                foreach ($participants as $p) {
                    $actualModel = ucfirst(explode('\\', $p->model)[count(explode('\\', $p->model)) - 1]);
                    if ($actualModel === 'User') {
                        $rightArr = json_decode($p->level0->value);
                        if ($rightArr->right_read === true) {
                            $connection = Yii::$app->getDb();
                            $command = $connection->createCommand('SELECT * FROM Objects');
                        }
                        return $command->query();
                    } elseif ($actualModel === 'Organization') {
                        $organizationModel = new $p->model;
                        $organization = $organizationModel::findOne($p->model_id);
                    } else {
                        throw new ServerErrorHttpException(Yii::t('core_system', 'Something went wrong with the request'));
                    }
                }*/
                /*$pp =  htmlspecialchars('\\') . $modelUsed;
                $sss = new self;
                $objectList = $sss::findAll(['model' => $pp]);*/
            /*}
            echo 'Index';
            //throw new ServerErrorHttpException(Yii::t('core_system', 'This user is not authorized to do that'));
        } else {
            throw new ServerErrorHttpException(Yii::t('core_system', 'Something went wrong with the request'));
        }
        return parent::find(); // TODO: Change the autogenerated stub
    }*/

    // Used by standard CRUD - View
    public static function findOne($condition)
    {
        if (!Yii::$app->user->identity) {
            throw new ServerErrorHttpException(Yii::t('core_system', 'No logged user'));
        } elseif (isset(Yii::$app->request->headers['authorization'])) {
            $bearerToken = explode(' ', Yii::$app->request->headers['authorization'])[1];
            return parent::findOne($condition);
            /*
            $participants = ObjectParticipant::findAll(['object' => (int)$condition]);
            $user_id = User::findIdentityByAccessToken($bearerToken);
            foreach ($participants as $p) {
                $actualModel = ucfirst(explode('\\', $p->model)[count(explode('\\', $p->model)) - 1]);
                if ($actualModel === 'User') {
                    $userModel = new $p->model;
                    $user = $userModel::findOne($p->model_id);
                    $action = Yii::$app->controller->action->id;
                    if ($user->id === $p->model_id) {
                        //$rights = 
                    }
                } elseif ($actualModel === 'Organization') {
                    $organizationModel = new $p->model;
                    $organization = $organizationModel::findOne($p->model_id);
                } else {
                    throw new ServerErrorHttpException(Yii::t('core_system', 'Something went wrong with the request'));
                }
            }
            */
            //return $this;
            //throw new ServerErrorHttpException(Yii::t('core_system', 'This user is not authorized to do that'));
        } else {
            throw new ServerErrorHttpException(Yii::t('core_system', 'Something went wrong with the request'));
        }
        //return parent::findOne($condition); // TODO: Change the autogenerated stub
    }

    // RETURNS FROM object_detail THE REQUESTED DETAIL FOR THE CURRENT OBJECT ID
    public function getValue($detail) {
        $name = ObjectDetail::findOne(['object' => $this->id, 'detail' => $detail]);
        if ($name !== null) {
            return $name->value;
        }
        return null;
    }

    // RETURNS MODEL NAME
    public function getModelname() {
        $nameArr = explode('\\', $this->model);
        $name = $nameArr[count($nameArr) - 1];
        $exists = $this->model;
        return $name;
    }

    /**
     * Gets query for [[ObjectParticipants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjectParticipants()
    {
        return $this->hasMany(ObjectParticipant::class, ['id' => 'object']);
    }


}
