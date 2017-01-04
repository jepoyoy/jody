<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "driver".
 *
 * @property integer $driver_id
 * @property string $fname
 * @property string $lname
 * @property string $mname
 * @property string $schedule
 * @property string $mobile
 *
 * @property Trip[] $trips
 */
class Driver extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'driver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fname', 'lname', 'mobile'], 'required'],
            [['fname', 'lname', 'mname'], 'string', 'max' => 100],
            [['schedule'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'driver_id' => 'Driver ID',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'mname' => 'Mname',
            'schedule' => 'Schedule',
            'mobile' => 'Mobile',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrips()
    {
        return $this->hasMany(Trip::className(), ['driver_id' => 'driver_id']);
    }

    /**
     * @inheritdoc
     * @return DriverQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DriverQuery(get_called_class());
    }
}
