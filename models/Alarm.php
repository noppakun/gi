<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alarm".
 *
 * @property integer $id
 * @property integer $hour
 * @property integer $minute
 * @property integer $period
 * @property integer $active
 * @property string $note
 * @property integer $inout
 */
class Alarm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'x_alarm';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hour', 'minute', 'period', 'active', 'inout'], 'integer'],
            [['note'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hour' => 'Hour',
            'minute' => 'Minute',
            'period' => 'Period',
            'active' => 'Active',
            'note' => 'Note',
            'inout' => 'o:in 1:out',
        ];
    }
}
