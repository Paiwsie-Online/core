<?php

namespace common\models\core;

/**
 * This is the ActiveQuery class for [[PaiwiseCheckout]].
 *
 * @see PaiwiseCheckout
 */
class PaiwiseCheckoutSearch extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PaiwiseCheckout[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PaiwiseCheckout|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
