<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Driver]].
 *
 * @see Driver
 */
class DriverQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Driver[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Driver|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}