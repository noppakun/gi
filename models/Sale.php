<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Sale".
 *
 * @property string $CompanyCode
 * @property string $Sale_Number
 * @property string $Cust_No
 * @property string $Sale_Date
 * @property string $Rlse_Date
 * @property string $Cust_PO_No
 * @property string $Cust_PO_Date
 * @property string $SalesmanCode
 * @property string $Terms
 * @property string $Shipto_Addr1
 * @property string $Shipto_Addr2
 * @property string $Shipto_Addr3
 * @property string $Shipto_Addr4
 * @property string $UserName
 * @property string $LastUpdate
 * @property string $Remark1
 * @property string $Remark2
 * @property string $Remark3
 * @property string $BranchCode
 * @property string $Confirm_Terms
 * @property string $Confirm_Remark
 * @property string $Disc_Cash
 * @property string $Disc_Percent
 * @property string $Disc_Special
 * @property string $Disc_Money
 * @property string $Desc_Disc_Other
 * @property string $Disc_Other
 * @property string $Vat_Percent
 * @property string $Vat_Amount
 * @property string $Amount
 * @property string $TotalAmount
 * @property string $Vat_Type
 */
class Sale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'Sale_Number', 'Cust_No', 'Sale_Date', 'SalesmanCode'], 'required'],
            [['CompanyCode', 'Sale_Number', 'Cust_No', 'Cust_PO_No', 'SalesmanCode', 'Terms', 'Shipto_Addr1', 'Shipto_Addr2', 'Shipto_Addr3', 'Shipto_Addr4', 'UserName', 'Remark1', 'Remark2', 'Remark3', 'BranchCode', 'Confirm_Terms', 'Confirm_Remark', 'Desc_Disc_Other', 'Vat_Type'], 'string'],
            [['Sale_Date', 'Rlse_Date', 'Cust_PO_Date', 'LastUpdate'], 'safe'],
            [['Disc_Cash', 'Disc_Percent', 'Disc_Special', 'Disc_Money', 'Disc_Other', 'Vat_Percent', 'Vat_Amount', 'Amount', 'TotalAmount'], 'number'],
            [['CompanyCode', 'Sale_Number'], 'unique', 'targetAttribute' => ['CompanyCode', 'Sale_Number']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'Sale_Number' => 'Sale  Number',
            'Cust_No' => 'Cust  No',
            'Sale_Date' => 'Sale  Date',
            'Rlse_Date' => 'Rlse  Date',
            'Cust_PO_No' => 'Cust  Po  No',
            'Cust_PO_Date' => 'Cust  Po  Date',
            'SalesmanCode' => 'Salesman Code',
            'Terms' => 'Terms',
            'Shipto_Addr1' => 'Shipto  Addr1',
            'Shipto_Addr2' => 'Shipto  Addr2',
            'Shipto_Addr3' => 'Shipto  Addr3',
            'Shipto_Addr4' => 'Shipto  Addr4',
            'UserName' => 'User Name',
            'LastUpdate' => 'Last Update',
            'Remark1' => 'Remark1',
            'Remark2' => 'Remark2',
            'Remark3' => 'Remark3',
            'BranchCode' => 'Branch Code',
            'Confirm_Terms' => 'Confirm  Terms',
            'Confirm_Remark' => 'Confirm  Remark',
            'Disc_Cash' => 'Disc  Cash',
            'Disc_Percent' => 'Disc  Percent',
            'Disc_Special' => 'Disc  Special',
            'Disc_Money' => 'Disc  Money',
            'Desc_Disc_Other' => 'Desc  Disc  Other',
            'Disc_Other' => 'Disc  Other',
            'Vat_Percent' => 'Vat  Percent',
            'Vat_Amount' => 'Vat  Amount',
            'Amount' => 'Amount',
            'TotalAmount' => 'Total Amount',
            'Vat_Type' => 'Vat  Type',
        ];
    }
}
