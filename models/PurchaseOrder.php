<?php

namespace app\models;

use Yii;
use app\models\Supplier;

/**
 * This is the model class for table "PO".
 *
 * @property string $CompanyCode
 * @property string $Order_Number
 * @property string $DeptCode
 * @property string $Supp_Number
 * @property string $Pr_Number
 * @property string $Shipto_Addr1
 * @property string $Shipto_Addr2
 * @property string $Currency_Type
 * @property string $Remark1
 * @property string $Remark2
 * @property string $Remark3
 * @property string $Remarks
 * @property string $Order_date
 * @property string $Buyers
 * @property string $Terms
 * @property integer $Po_Issue
 * @property integer $Open_Close
 * @property string $Close_Date
 * @property string $Service
 * @property string $Insurance
 * @property string $Carriage
 * @property string $Vat_Percent
 * @property string $Vat_Amt
 * @property string $Disc_Percent
 * @property string $Disc_Cash
 * @property integer $Revision_No
 * @property string $Revision_Date
 * @property string $Vat_Type
 * @property string $ForWork
 * @property string $DivisionCode
 * @property string $LimitOverOrderRate
 * @property string $currency_Rate
 * @property string $ShipMent
 * @property string $Amount
 * @property string $TotalAmount
 * @property string $UserName
 * @property string $LastUpdateuse app\models\
 * @property integer $PO_Approve
 * @property string $UserName_Approve
 * @property string $DateTime_Approve
 */
class PurchaseOrder extends \yii\db\ActiveRecord
{
    public function getDetail()
    {
        return $this->hasMany(PODetail::className(), ['CompanyCode'=>'CompanyCode','Order_Number' => 'Order_Number']);
    }     
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['Supp_Number' => 'Supp_Number']);
    }    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PO';
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
            [['CompanyCode', 'Order_Number', 'Supp_Number', 'Order_date', 'Po_Issue', 'Open_Close', 'Vat_Type'], 'required'],
            [['CompanyCode', 'Order_Number', 'DeptCode', 'Supp_Number', 'Pr_Number', 'Shipto_Addr1', 'Shipto_Addr2', 'Currency_Type', 'Remark1', 'Remark2', 'Remark3', 'Remarks', 'Buyers', 'Terms', 'Vat_Type', 'ForWork', 'DivisionCode', 'ShipMent', 'UserName', 'UserName_Approve'], 'string'],
            [['Order_date', 'Close_Date', 'Revision_Date', 'LastUpdate', 'DateTime_Approve'], 'safe'],
            [['Po_Issue', 'Open_Close', 'Revision_No', 'PO_Approve'], 'integer'],
            [['Service', 'Insurance', 'Carriage', 'Vat_Percent', 'Vat_Amt', 'Disc_Percent', 'Disc_Cash', 'LimitOverOrderRate', 'currency_Rate', 'Amount', 'TotalAmount'], 'number'],
            [['CompanyCode'], 'default', 'value'=> 'GPM'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'รหัสบริษัท',
            'Order_Number' => 'เลขที่ใบสั่งซื้อ',
            'DeptCode' => 'รหัสแผนก',
            'Supp_Number' => 'รหัสผู้ขาย',
            'Pr_Number' => 'เลขที่ใบขอซื้อ',
            'Shipto_Addr1' => 'Shipto  Addr1',
            'Shipto_Addr2' => 'Shipto  Addr2',
            'Currency_Type' => 'Currency  Type',
            'Remark1' => 'Remark1',
            'Remark2' => 'Remark2',
            'Remark3' => 'Remark3',
            'Remarks' => 'Remarks',
            'Order_date' => 'วันที่ PO.',
            'Buyers' => 'รหัสผู้ซื้อ',
            'Terms' => 'Terms',
            'Po_Issue' => 'Po  Issue',
            'Open_Close' => 'Open  Close',
            'Close_Date' => 'Close  Date',
            'Service' => 'Service',
            'Insurance' => 'Insurance',
            'Carriage' => 'Carriage',
            'Vat_Percent' => 'Vat  Percent',
            'Vat_Amt' => 'Vat  Amt',
            'Disc_Percent' => 'Disc  Percent',
            'Disc_Cash' => 'Disc  Cash',
            'Revision_No' => 'Revision  No',
            'Revision_Date' => 'Revision  Date',
            'Vat_Type' => 'Vat  Type',
            'ForWork' => 'For Work',
            'DivisionCode' => 'รหัสฝ่าย',
            'LimitOverOrderRate' => 'Limit Over Order Rate',
            'currency_Rate' => 'Currency  Rate',
            'ShipMent' => 'Ship Ment',
            'Amount' => 'Amount',
            'TotalAmount' => 'Total Amount',
            'UserName' => 'User Name',
            'LastUpdate' => 'Last Update',
            'PO_Approve' => 'Po  Approve',
            'UserName_Approve' => 'User Name  Approve',
            'DateTime_Approve' => 'Date Time  Approve',
        ];
    }
}
