<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EmployeePosition".
 *
 * @property string $EmployeePositionCode
 * @property string $EmployeePositionName
 * @property int $EmployeePositionLevel
 */
class EmployeePosition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'EmployeePosition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EmployeePositionCode', 'EmployeePositionName'], 'required'],
            [['EmployeePositionCode', 'EmployeePositionName'], 'string'],
            [['EmployeePositionLevel'], 'integer'],
            [['EmployeePositionCode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'EmployeePositionCode' => 'Employee Position Code',
            'EmployeePositionName' => 'ตำแหน่ง',
            'EmployeePositionLevel' => 'Employee Position Level',
        ];
    }
}
