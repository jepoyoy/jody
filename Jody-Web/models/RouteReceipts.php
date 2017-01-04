<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "route_receipts".
 *
 * @property integer $trip_receipt_id
 * @property integer $employee_id
 * @property integer $schedule_id
 * @property string $created_date
 *
 * @property Employee $employee
 * @property Schedule $schedule
 */
class RouteReceipts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'route_receipts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'schedule_id'], 'required'],
            [['employee_id', 'schedule_id'], 'integer'],
            [['created_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'trip_receipt_id' => 'Trip Receipt ID',
            'employee_id' => 'Employee ID',
            'schedule_id' => 'Schedule ID',
            'created_date' => 'Created Date',
        ];
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
    public function getSchedule()
    {
        return $this->hasOne(Schedule::className(), ['schedule_id' => 'schedule_id']);
    }

    /**
     * @inheritdoc
     * @return RouteReceiptsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RouteReceiptsQuery(get_called_class());
    }
}
