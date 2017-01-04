<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EventLog]].
 *
 * @see EventLog
 */
class EvQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return EventLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EventLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}