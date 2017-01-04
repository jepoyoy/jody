<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "route".
 *
 * @property integer $route_id
 * @property string $pointA
 * @property string $pointB
 * @property string $route_code
 *
 * @property RouteReceipts[] $routeReceipts
 * @property Schedule[] $schedules
 * @property Trip[] $trips
 */
class Route extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'route';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pointA', 'pointB'], 'required'],
            [['pointA', 'pointB'], 'string', 'max' => 100],
            [['route_code'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'route_id' => 'Route ID',
            'pointA' => 'Point A',
            'pointB' => 'Point B',
            'route_code' => 'Route Code',
        ];
    }

    public function getCodeAsArray(){
        return explode("-", $this->route_code);
    }

    public function getRouteDesc(){
        return $this->pointA.' -> '.$this->pointB;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRouteReceipts()
    {
        return $this->hasMany(RouteReceipts::className(), ['route_id' => 'route_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['route_id' => 'route_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrips()
    {
        return $this->hasMany(Trip::className(), ['route_id' => 'route_id']);
    }

    /**
     * @inheritdoc
     * @return RouteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RouteQuery(get_called_class());
    }
}
