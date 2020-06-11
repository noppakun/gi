<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Section".
 *
 * @property string $CompanyCode
 * @property string $Divisioncode
 * @property string $DeptCode
 * @property string $SectionCode
 * @property string $SectionName
 * @property string $ImmediateSuperior
 */
class Section extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'Divisioncode', 'DeptCode', 'SectionCode'], 'required'],
            [['CompanyCode', 'Divisioncode', 'DeptCode', 'SectionCode'], 'string', 'max' => 3],
            [['SectionName'], 'string', 'max' => 40],
            [['ImmediateSuperior'], 'string', 'max' => 10],
            [['CompanyCode', 'DeptCode', 'Divisioncode', 'SectionCode'], 'unique', 'targetAttribute' => ['CompanyCode', 'DeptCode', 'Divisioncode', 'SectionCode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'Divisioncode' => 'Divisioncode',
            'DeptCode' => 'Dept Code',
            'SectionCode' => 'Section Code',
            'SectionName' => 'Section Name',
            'ImmediateSuperior' => 'Immediate Superior',
        ];
    }
}
