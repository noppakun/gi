<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Invoice".
 *
 * @property string $CompanyCode
 * @property string $Inv_Number
 * @property string $Type_Inv_Code
 * @property string $Sale_Number
 * @property string $DivisionCode
 * @property string $DeptCode
 * @property string $Cust_No
 * @property string $Inv_Date
 * @property string $SalesmanCode
 * @property string $DeliveryCode
 * @property string $Terms
 * @property string $ShipTo_Addr1
 * @property string $ShipTo_Addr2
 * @property string $ShipTo_Addr3
 * @property string $ShipTo_Addr4
 * @property string $Remark1
 * @property string $Remark2
 * @property string $Remark3
 * @property string $Due_Date
 * @property string $Cust_PO_No
 * @property string $Cust_PO_Date
 * @property string $Disc_Cash
 * @property string $Disc_Percent
 * @property string $Disc_Special
 * @property string $Disc_Money
 * @property string $Desc_Disc_Other
 * @property string $Disc_Other
 * @property integer $Inv_Issue
 * @property integer $Open_Close
 * @property string $Vat_Percent
 * @property string $Vat_Amount
 * @property string $Adjust_Date
 * @property integer $Adjust_Many
 * @property string $Currency_Type
 * @property string $Currency_Rate
 * @property string $Amount
 * @property string $TotalAmount
 * @property string $PaidAmount
 * @property resource $Inv_Picture
 * @property string $UserName
 * @property string $LastUpdate
 * @property string $Vat_Type
 * @property string $BranchCode
 * @property string $delivery_date
 */
class Invoice extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public function getXInvoiceExt()
    {        
        return $this->hasOne(XInvoiceExt::className(), [
            'companycode' => 'CompanyCode',
            'inv_number' => 'Inv_Number'
            ]);
    }    
    public function getCustomer()
    {        
        return $this->hasOne(Customer::className(), ['Cust_No' => 'Cust_No']);
    }
    

    public function scenarios()
    {
        $scenarios = parent::scenarios(); 

        $scenarios['xqedit'] =  ['Sale_Number','SalesmanCode'];  
        return $scenarios;
        
    } 
     
    public static function tableName()
    {
        return 'Invoice';
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
            [['CompanyCode', 'Inv_Number', 'Cust_No', 'Inv_Date', 'SalesmanCode', 'DeliveryCode', 'Inv_Issue', 'Open_Close'], 'required'],
            [['CompanyCode', 'Inv_Number', 'Type_Inv_Code', 'Sale_Number', 'DivisionCode', 'DeptCode', 'Cust_No', 'SalesmanCode', 'DeliveryCode', 'Terms', 'ShipTo_Addr1', 'ShipTo_Addr2', 'ShipTo_Addr3', 'ShipTo_Addr4', 'Remark1', 'Remark2', 'Remark3', 'Cust_PO_No', 'Desc_Disc_Other', 'Currency_Type',  'UserName', 'Vat_Type', 'BranchCode'], 'string'],
            [['Inv_Date', 'Due_Date', 'Cust_PO_Date', 'Adjust_Date', 'LastUpdate', 'delivery_date','Inv_Picture'], 'safe'],
            [['Disc_Cash', 'Disc_Percent', 'Disc_Special', 'Disc_Money', 'Disc_Other', 'Vat_Percent', 'Vat_Amount', 'Currency_Rate', 'Amount', 'TotalAmount', 'PaidAmount'], 'number'],
            [['Inv_Issue', 'Open_Close', 'Adjust_Many'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'รหัสบริษัท',
            'Inv_Number' => 'เลขที่ใบส่งของ',
            'Type_Inv_Code' => 'Type  Inv  Code',
            'Sale_Number' => 'Sale  Number',
            'DivisionCode' => 'Division Code',
            'DeptCode' => 'Dept Code',
            'Cust_No' => 'รหัสลูกค้า',
            'Inv_Date' => 'วันที่',
            'SalesmanCode' => 'Salesman Code',
            'DeliveryCode' => 'Delivery Code',
            'Terms' => 'Terms',
            'ShipTo_Addr1' => 'Ship To  Addr1',
            'ShipTo_Addr2' => 'Ship To  Addr2',
            'ShipTo_Addr3' => 'Ship To  Addr3',
            'ShipTo_Addr4' => 'Ship To  Addr4',
            'Remark1' => 'Remark1',
            'Remark2' => 'Remark2',
            'Remark3' => 'Remark3',
            'Due_Date' => 'Due Date',
            'Cust_PO_No' => 'Cust  Po  No',
            'Cust_PO_Date' => 'Cust  Po  Date',
            'Disc_Cash' => 'Disc  Cash',
            'Disc_Percent' => 'Disc  Percent',
            'Disc_Special' => 'Disc  Special',
            'Disc_Money' => 'Disc  Money',
            'Desc_Disc_Other' => 'Desc  Disc  Other',
            'Disc_Other' => 'Disc  Other',
            'Inv_Issue' => 'Inv  Issue',
            'Open_Close' => 'Open  Close',
            'Vat_Percent' => 'Vat  Percent',
            'Vat_Amount' => 'Vat  Amount',
            'Adjust_Date' => 'Adjust  Date',
            'Adjust_Many' => 'Adjust  Many',
            'Currency_Type' => 'Currency  Type',
            'Currency_Rate' => 'Currency  Rate',
            'Amount' => 'Amount',
            'TotalAmount' => 'Total Amount',
            'PaidAmount' => 'Paid Amount',
            'Inv_Picture' => 'Inv  Picture',
            'UserName' => 'User Name',
            'LastUpdate' => 'Last Update',
            'Vat_Type' => 'Vat  Type',
            'BranchCode' => 'Branch Code',
            'delivery_date' => 'Delivery Date',
        ];
    }
}
