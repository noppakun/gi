<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SpecRaw".
 *
 * @property string $Item_Number
 * @property string $SpecNo
 * @property string $EffectiveDate
 * @property string $SpecificationDesc
 * @property string $StorageCondition
 * @property string $RetestInterval
 * @property integer $SpecCancel
 * @property string $DescForAnalysis
 * @property string $DescForCertificate
 * @property string $ShortStorageCondition
 * @property integer $ReviseNo
 * @property string $UserName
 * @property string $LastUpdate
 */
class SpecRaw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SpecRaw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Item_Number', 'SpecNo', 'EffectiveDate', 'SpecCancel'], 'required'],
            [['Item_Number', 'SpecNo', 'SpecificationDesc', 'StorageCondition', 'DescForAnalysis', 'DescForCertificate', 'ShortStorageCondition', 'UserName'], 'string'],
            [['EffectiveDate', 'LastUpdate'], 'safe'],
            [['RetestInterval'], 'number'],
            [['SpecCancel', 'ReviseNo'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Item_Number' => 'Item  Number',
            'SpecNo' => 'Spec No',
            'EffectiveDate' => 'Effective Date',
            'SpecificationDesc' => 'Specification Desc',
            'StorageCondition' => 'Storage Condition',
            'RetestInterval' => 'Retest Interval',
            'SpecCancel' => 'Spec Cancel',
            'DescForAnalysis' => 'Desc For Analysis',
            'DescForCertificate' => 'Desc For Certificate',
            'ShortStorageCondition' => 'Short Storage Condition',
            'ReviseNo' => 'Revise No',
            'UserName' => 'User Name',
            'LastUpdate' => 'Last Update',
        ];
    }
}
