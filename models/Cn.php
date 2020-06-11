<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CN".
 *
 * @property string $CompanyCode
 * @property string $CN_Number
 * @property string $CN_Date
 * @property string $Inv_Number
 * @property string $Inv_Date
 * @property string $SalesmanCode
 * @property string $DivisionCode
 * @property string $DeptCode
 * @property string $Inv_TotalAmount
 * @property string $Inv_Amount
 * @property string $Vat_Percent
 * @property string $Vat_Amount
 * @property string $Remark1
 * @property string $Remark2
 * @property string $Remark3
 * @property string $Adjust_Date
 * @property integer $Adjust_Many
 * @property integer $CN_Issue
 * @property integer $Open_Close
 * @property string $Cust_No
 * @property string $Disc_Cash
 * @property string $Disc_Percent
 * @property string $Disc_Special
 * @property string $Disc_Money
 * @property string $Amount
 * @property string $TotalAmount
 * @property string $PaidAmount
 * @property string $BranchCode
 * @property string $Vat_type
 * @property string $Terms
 * @property string $Due_Date
 */
class Cn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CN';
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
            [['CompanyCode', 'CN_Number', 'Inv_Number', 'CN_Issue', 'Open_Close'], 'required'],
            [['CompanyCode', 'CN_Number', 'Inv_Number', 'SalesmanCode', 'DivisionCode', 'DeptCode', 'Remark1', 'Remark2', 'Remark3', 'Cust_No', 'BranchCode', 'Vat_type','Terms'], 'string'],
            [['CN_Date', 'Inv_Date', 'Adjust_Date','Due_Date'], 'safe'],
            [['Inv_TotalAmount', 'Inv_Amount', 'Vat_Percent', 'Vat_Amount', 'Disc_Cash', 'Disc_Percent', 'Disc_Special', 'Disc_Money', 'Amount', 'TotalAmount', 'PaidAmount'], 'number'],
            [['Adjust_Many', 'CN_Issue', 'Open_Close'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'CN_Number' => 'Cn  Number',
            'CN_Date' => 'Cn  Date',
            'Inv_Number' => 'Inv  Number',
            'Inv_Date' => 'Inv  Date',
            'SalesmanCode' => 'Salesman Code',
            'DivisionCode' => 'Division Code',
            'DeptCode' => 'Dept Code',
            'Inv_TotalAmount' => 'Inv  Total Amount',
            'Inv_Amount' => 'Inv  Amount',
            'Vat_Percent' => 'Vat  Percent',
            'Vat_Amount' => 'Vat  Amount',
            'Remark1' => 'Remark1',
            'Remark2' => 'Remark2',
            'Remark3' => 'Remark3',
            'Adjust_Date' => 'Adjust  Date',
            'Adjust_Many' => 'Adjust  Many',
            'CN_Issue' => 'Cn  Issue',
            'Open_Close' => 'Open  Close',
            'Cust_No' => 'Cust  No',
            'Disc_Cash' => 'Disc  Cash',
            'Disc_Percent' => 'Disc  Percent',
            'Disc_Special' => 'Disc  Special',
            'Disc_Money' => 'Disc  Money',
            'Amount' => 'Amount',
            'TotalAmount' => 'Total Amount',
            'PaidAmount' => 'Paid Amount',
            'BranchCode' => 'Branch Code',            
            'Vat_type' => 'Vat Type',
            'Terms' => 'Terms',
            'Due_Date' => 'Due  Date',            
        ];
    }
}
