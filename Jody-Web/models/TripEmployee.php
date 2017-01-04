<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trip_employee".
 *
 * @property integer $trip_employee_id
 * @property string $created_date
 * @property integer $employee_id
 * @property integer $trip_id
 * @property integer $trip_receipt_id
 *
 * @property RouteReceipts $tripReceipt
 * @property Employee $employee
 * @property Trip $trip
 */
class TripEmployee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trip_employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['employee_id', 'trip_id', 'trip_receipt_id'], 'required'],
            [['employee_id', 'trip_id', 'trip_receipt_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'trip_employee_id' => 'Trip Employee ID',
            'created_date' => 'Created Date',
            'employee_id' => 'Employee ID',
            'trip_id' => 'Trip ID',
            'trip_receipt_id' => 'Trip Receipt ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripReceipt()
    {
        return $this->hasOne(RouteReceipts::className(), ['trip_receipt_id' => 'trip_receipt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['employee_id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrip()
    {
        return $this->hasOne(Trip::className(), ['trip_id' => 'trip_id']);
    }

    /**
     * @inheritdoc
     * @return TripEmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TripEmployeeQuery(get_called_class());
    }
}
