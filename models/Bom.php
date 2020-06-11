<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Bom".
 *
 * @property string $Assembly
 * @property string $Formula_No
 * @property string $SpecNo
 * @property string $ProcessRemark
 * @property string $TransferRecord1
 * @property string $TransferRecord2
 * @property string $TransferRecord3
 * @property string $StandardBatchSize
 * @property string $CompoundCode
 * @property string $Density
 * @property string $EffectiveDate
 * @property string $StandardYieldMin
 * @property string $StandardYieldMax
 * @property string $RegNo
 * @property string $ProductType
 */
class Bom extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Bom';
    }
    public function getCompound()
    {     
        return $this->hasOne(Item::className(), ['Item_Number' => 'CompoundCode']);
    }    
    public function getItem()
    {
     
        return $this->hasOne(Item::className(), ['Item_Number' => 'Assembly']);
    }
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('erpdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Assembly'], 'required'],
            [['Assembly', 'Formula_No', 'SpecNo', 'ProcessRemark', 'TransferRecord1', 'TransferRecord2', 'TransferRecord3', 'CompoundCode', 'RegNo', 'ProductType'], 'string'],
            [['StandardBatchSize', 'Density', 'StandardYieldMin', 'StandardYieldMax'], 'number'],
            [['EffectiveDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Assembly' => 'Assembly',
            'Formula_No' => 'Formula  No',
            'SpecNo' => 'Spec No',
            'ProcessRemark' => 'Process Remark',
            'TransferRecord1' => 'Transfer Record1',
            'TransferRecord2' => 'Transfer Record2',
            'TransferRecord3' => 'Transfer Record3',
            'StandardBatchSize' => 'Standard Batch Size',
            'CompoundCode' => 'Compound Code',
            'Density' => 'Density',
            'EffectiveDate' => 'Effective Date',
            'StandardYieldMin' => 'Standard Yield Min',
            'StandardYieldMax' => 'Standard Yield Max',
            'RegNo' => 'Reg No',
            'ProductType' => 'Product Type',
        ];
    }
}
