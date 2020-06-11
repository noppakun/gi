<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Depart".
 *
 * @property string $Companycode
 * @property string $DivisionCode
 * @property string $DeptCode
 * @property string $DeptName
 * @property string $ImmediateSuperior
 */
class Depart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Depart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Companycode', 'DivisionCode', 'DeptCode', 'DeptName'], 'required'],
            [['Companycode', 'DivisionCode', 'DeptCode', 'DeptName', 'ImmediateSuperior'], 'string'],
            [['Companycode', 'DeptCode', 'DivisionCode'], 'unique', 'targetAttribute' => ['Companycode', 'DeptCode', 'DivisionCode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Companycode' => 'Companycode',
            'DivisionCode' => 'Division Code',
            'DeptCode' => 'รหัสแผนก',
            'DeptName' => 'แผนก',
            'ImmediateSuperior' => 'Immediate Superior',
        ];
    }
}
