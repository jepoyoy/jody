<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle".
 *
 * @property integer $vehicle_id
 * @property string $description
 * @property string $platenum
 * @property integer $isactive
 * @property integer $capacity
 *
 * @property Schedule[] $schedules
 * @property Trip[] $trips
 */
class Vehicle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehicle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'platenum'], 'required'],
            [['isactive', 'capacity'], 'integer'],
            [['description'], 'string', 'max' => 150],
            [['platenum'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vehicle_id' => 'Vehicle ID',
            'description' => 'Description',
            'platenum' => 'Platenum',
            'isactive' => 'Isactive',
            'capacity' => 'Capacity',
        ];
    }

    public function getVehicleDesc(){
        return $this->description.' -'.$this->platenum;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['vehicle_id' => 'vehicle_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrips()
    {
        return $this->hasMany(Trip::className(), ['vehicle_id' => 'vehicle_id']);
    }

    /**
     * @inheritdoc
     * @return VehicleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VehicleQuery(get_called_class());
    }
}
