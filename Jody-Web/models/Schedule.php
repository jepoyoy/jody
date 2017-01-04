<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $schedule_id
 * @property string $trip_start
 * @property string $trip_end
 * @property integer $route_id
 * @property integer $vehicle_id
 * @property integer $is_active
 *
 * @property RouteReceipts[] $routeReceipts
 * @property Route $route
 * @property Vehicle $vehicle
 * @property Trip[] $trips
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trip_start', 'trip_end', 'route_id', 'vehicle_id'], 'required'],
            [['trip_start', 'trip_end'], 'safe'],
            [['route_id', 'vehicle_id', 'is_active'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'schedule_id' => 'Schedule ID',
            'trip_start' => 'Trip Start',
            'trip_end' => 'Trip End',
            'route_id' => 'Route ID',
            'vehicle_id' => 'Vehicle ID',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRouteReceipts()
    {
        return $this->hasMany(RouteReceipts::className(), ['schedule_id' => 'schedule_id']);
    }

     public function getRouteReceiptsToday()
    {
        $yesterday = date('Y-m-d H:i:s',strtotime("-1 days"));
        $tomorrow = date('Y-m-d H:i:s',strtotime("tomorrow"));

        $receipts = RouteReceipts::find()->where(['schedule_id' => $this->schedule_id])
                        ->andFilterWhere(['between', 'created_date', $yesterday, $tomorrow])->all();

        return $receipts;

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoute()
    {
        return $this->hasOne(Route::className(), ['route_id' => 'route_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::className(), ['vehicle_id' => 'vehicle_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrips()
    {
        return $this->hasMany(Trip::className(), ['schedule_id' => 'schedule_id']);
    }

    /**
     * @inheritdoc
     * @return ScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScheduleQuery(get_called_class());
    }
}
