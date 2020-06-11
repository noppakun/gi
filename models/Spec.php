<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Spec".
 *
 * @property string $Item_Number
 * @property string $SpecNo
 * @property string $EffectiveDate
 * @property string $SamplingMethod
 * @property string $Description
 * @property string $Material
 * @property string $Dimension
 * @property string $Package
 * @property string $Remark
 * @property resource $SpecPicture
 * @property int $SpecCancel
 * @property string $RetestInterval
 * @property string $StorageCondition
 * @property string $ShortStorageCondition
 * @property int $ReviseNo
 * @property string $SpecFile
 * @property string $DescForAnalysis
 * @property string $UserName
 * @property string $LastUpdate
 */
class Spec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Spec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Item_Number', 'SpecNo', 'EffectiveDate', 'SpecCancel'], 'required'],
            [['Item_Number', 'SpecNo', 'SamplingMethod', 'Description', 'Material', 'Dimension', 'Package', 'Remark', 'SpecPicture', 'StorageCondition', 'ShortStorageCondition', 'SpecFile', 'DescForAnalysis', 'UserName'], 'string'],
            [['EffectiveDate', 'LastUpdate'], 'safe'],
            [['SpecCancel', 'ReviseNo'], 'integer'],
            [['RetestInterval'], 'number'],
            [['EffectiveDate', 'Item_Number', 'SpecNo'], 'unique', 'targetAttribute' => ['EffectiveDate', 'Item_Number', 'SpecNo']],
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
            'SamplingMethod' => 'Sampling Method',
            'Description' => 'Description',
            'Material' => 'Material',
            'Dimension' => 'Dimension',
            'Package' => 'Package',
            'Remark' => 'Remark',
            'SpecPicture' => 'Spec Picture',
            'SpecCancel' => 'Spec Cancel',
            'RetestInterval' => 'Retest Interval',
            'StorageCondition' => 'Storage Condition',
            'ShortStorageCondition' => 'Short Storage Condition',
            'ReviseNo' => 'Revise No',
            'SpecFile' => 'Spec File',
            'DescForAnalysis' => 'Desc For Analysis',
            'UserName' => 'User Name',
            'LastUpdate' => 'Last Update',
        ];
    }
}
