<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TableUpdate]].
 *
 * @see TableUpdate
 */
class TableUpdateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TableUpdate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TableUpdate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}