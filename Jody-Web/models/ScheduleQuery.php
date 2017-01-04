<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Schedule]].
 *
 * @see Schedule
 */
class ScheduleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Schedule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Schedule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}