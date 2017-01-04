<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[RouteReceipts]].
 *
 * @see RouteReceipts
 */
class RouteReceiptsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return RouteReceipts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RouteReceipts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}