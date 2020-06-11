<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ArBillTran".
 *
 * @property string $CompanyCode
 * @property string $ArBillNo
 * @property string $Inv_Number
 * @property string $DocType
 * @property string $Inv_Date
 * @property string $Amount
 * @property string $Due_Date
 * @property string $PayAmount
 */
class ArBillTran extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ArBillTran';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'ArBillNo', 'Inv_Number', 'DocType', 'Inv_Date'], 'required'],
            [['CompanyCode', 'ArBillNo', 'Inv_Number', 'DocType'], 'string'],
            [['Inv_Date', 'Due_Date'], 'safe'],
            [['Amount', 'PayAmount'], 'number'],
            [['ArBillNo', 'CompanyCode', 'DocType', 'Inv_Number'], 'unique', 'targetAttribute' => ['ArBillNo', 'CompanyCode', 'DocType', 'Inv_Number']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'ArBillNo' => 'Ar Bill No',
            'Inv_Number' => 'Inv  Number',
            'DocType' => 'Doc Type',
            'Inv_Date' => 'Inv  Date',
            'Amount' => 'Amount',
            'Due_Date' => 'Due  Date',
            'PayAmount' => 'Pay Amount',
        ];
    }
}
