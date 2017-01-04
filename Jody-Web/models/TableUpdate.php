<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "table_update".
 *
 * @property integer $table_update_id
 * @property string $table_name
 * @property string $updated_date
 */
class TableUpdate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'table_update';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_name'], 'required'],
            [['updated_date'], 'safe'],
            [['table_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'table_update_id' => 'Table Update ID',
            'table_name' => 'Table Name',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * @inheritdoc
     * @return TableUpdateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TableUpdateQuery(get_called_class());
    }
}
