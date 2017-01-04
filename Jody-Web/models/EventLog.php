<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event_log".
 *
 * @property integer $event_log_id
 * @property string $created_date
 * @property string $message
 * @property string $metadata
 */
class EventLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['message', 'metadata'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'event_log_id' => 'Event Log ID',
            'created_date' => 'Created Date',
            'message' => 'Message',
            'metadata' => 'Metadata',
        ];
    }

    /**
     * @inheritdoc
     * @return EventLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EventLogQuery(get_called_class());
    }
}
