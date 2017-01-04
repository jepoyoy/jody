<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TripEmployee]].
 *
 * @see TripEmployee
 */
class TripEmployeeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TripEmployee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TripEmployee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}