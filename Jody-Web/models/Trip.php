<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trip".
 *
 * @property integer $trip_id
 * @property string $notes
 * @property integer $is_validity_enabled
 * @property string $created_date
 * @property string $updated_date
 * @property integer $schedule_id
 * @property integer $route_id
 * @property integer $driver_id
 * @property integer $vehicle_id
 * @property string $start_time
 * @property string $end_time
 *
 * @property Driver $driver
 * @property Route $route
 * @property Schedule $schedule
 * @property Vehicle $vehicle
 * @property TripEmployee[] $tripEmployees
 */
class Trip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_validity_enabled', 'schedule_id', 'route_id', 'driver_id', 'vehicle_id'], 'integer'],
            [['created_date', 'updated_date', 'start_time', 'end_time'], 'safe'],
            [['schedule_id', 'route_id', 'driver_id', 'vehicle_id'], 'required'],
            [['notes'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'trip_id' => 'Trip ID',
            'notes' => 'Notes',
            'is_validity_enabled' => 'Is Validity Enabled',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'schedule_id' => 'Schedule ID',
            'route_id' => 'Route ID',
            'driver_id' => 'Driver ID',
            'vehicle_id' => 'Vehicle ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(Driver::className(), ['driver_id' => 'driver_id']);
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
    public function getSchedule()
    {
        return $this->hasOne(Schedule::className(), ['schedule_id' => 'schedule_id']);
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
    public function getTripEmployees()
    {
        return $this->hasMany(TripEmployee::className(), ['trip_id' => 'trip_id']);
    }

    /**
     * @inheritdoc
     * @return TripQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TripQuery(get_called_class());
    }
}
