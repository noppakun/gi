<?php

namespace app\models;

use Yii;

use \app\components\XLib;
/**
 * This is the model class for table "StHead".
 *
 * @property string $CompanyCode
 * @property string $DocType
 * @property string $VoucherNo
 * @property string $DocDate
 * @property string $Order_Number
 * @property string $RefDoc
 * @property string $JobNo
 * @property string $Remark
 * @property string $AccountCode
 * @property string $Manufacturer
 * @property string $Supplier_Lot
 * @property string $RefDoc2
 * @property string $UserName
 * @property string $VatRate
 * @property string $VatAmt
 * @property string $RecvDocDate
 * @property string $PO_NO
 * @property string $Inv_Number
 * @property string $Inv_Date
 * @property string $Supp_Number
 * @property string $Supp_Name
 * @property string $Discount
 * @property string $Deposit
 * @property string $Amount
 * @property string $TotalAmount
 * @property string $PaidAmount
 * @property int $PostGL
 * @property string $UserPostGL
 * @property string $DateTimePostGL
 * @property int $PrintDocStatus
 * @property string $BranchCode
 * @property string $AccountCode_Tax
 * @property string $TransferStatus
 * @property string $TaxID
 * @property int $BranchNo
 * @property string $DivisionCode
 * @property string $DeptCode
 * @property string $AccountCode_Deposit
 */

 /*

 *** DocType  ประเภทการรับจ่ายสินค้า   from Pattawit
รับ
R0 ยอดยกมา
R1 รับจากการซื้อ
R2 รับจากการผลิต
R3 รับคืนจาการผลิต
R4 รับคืนจากลูกค้า
R5 ปรับปรุงการรับอื่นๆ
R6 รับจากการโอน
R7 รับเข้าจากการตรวจนับ
R8 รับจากผู้จ้างผลิต
R9 รับคืนจาก Supplier

จ่าย
I0 Reject จาก LAB
I1 เบิกวัตถุดิบเพื่อการผลิต
I2 เบิกสินค้าใช้ภายใน
I3 เบิกสินค้าเป็นตัวอย่าง
I4 ตัดสินค้าชำรุด
I5 เบิกเพื่อโอน
I6 เบิกสินค้าเพื่อจำหน่าย
I7 ปรับปรุงการเบิกอื่นๆ
I8 เบิกออกจากการตรวจนับ
I9 ตัดสินค้าชำรุดจาก Supplier

 */
class StHead extends \yii\db\ActiveRecord
{
    public $labels = [
        'CompanyCode' => 'Company Code',
        'DocType' => 'Doc Type',
        'VoucherNo' => 'เลขที่เอกสาร',
        'DocDate' => 'วันที่',
        'Order_Number' => 'Order_Number (Batch No./Po No.)',
        'RefDoc' => 'Ref Doc',
        'JobNo' => 'Job No',
        'Remark' => 'Remark',
        'AccountCode' => 'Account Code',
        'Manufacturer' => 'Manufacturer',
        'Supplier_Lot' => 'Supplier  Lot',
        'RefDoc2' => 'Ref Doc2',
        'UserName' => 'User Name',
        'VatRate' => 'Vat Rate',
        'VatAmt' => 'Vat Amt',
        'RecvDocDate' => 'Recv Doc Date',
        'PO_NO' => 'Po  No',
        'Inv_Number' => 'Inv  Number',
        'Inv_Date' => 'Inv  Date',
        'Supp_Number' => 'Supp  Number',
        'Supp_Name' => 'Supp  Name',
        'Discount' => 'Discount',
        'Deposit' => 'Deposit',
        'Amount' => 'Amount',
        'TotalAmount' => 'Total Amount',
        'PaidAmount' => 'Paid Amount',
        'PostGL' => 'Post Gl',
        'UserPostGL' => 'User Post Gl',
        'DateTimePostGL' => 'Date Time Post Gl',
        'PrintDocStatus' => 'Print Doc Status',
        'BranchCode' => 'Branch Code',
        'AccountCode_Tax' => 'Account Code  Tax',
        'TransferStatus' => 'Transfer Status',
        'TaxID' => 'Tax ID',
        'BranchNo' => 'Branch No',
        'DivisionCode' => 'Division Code',
        'DeptCode' => 'Dept Code',
        'AccountCode_Deposit' => 'Account Code  Deposit',
    ];

    public function afterFind(){
        parent::afterFind();
        $this->DocDate             = XLib::dateTimeConv($this->DocDate,'a');        
    }
 


    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->DocDate             = XLib::dateTimeConv($this->DocDate,'b');
        return true;
    }

    public function getStCard()
    {        
        return $this->hasMany(StCard::className(), [
            'CompanyCode' => 'CompanyCode',
            'DocType' => 'DocType',
            'VoucherNo' => 'VoucherNo',
            ])->orderBy(['Item_Number' => SORT_ASC]);         
    }
    public function getDoctype_ref()
    {
        
        return $this->hasOne(DocType::className(), ['DocType' => 'DocType']);
         
    }      
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'StHead';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'DocType', 'VoucherNo', 'DocDate'], 'required'],
            [['CompanyCode', 'DocType', 'VoucherNo', 'Order_Number', 'RefDoc', 'JobNo', 'Remark', 'AccountCode', 'Manufacturer', 'Supplier_Lot', 'RefDoc2', 'UserName', 'PO_NO', 'Inv_Number', 'Supp_Number', 'Supp_Name', 'UserPostGL', 'BranchCode', 'AccountCode_Tax', 'TransferStatus', 'TaxID', 'DivisionCode', 'DeptCode', 'AccountCode_Deposit'], 'string'],
            [['DocDate', 'RecvDocDate', 'Inv_Date', 'DateTimePostGL'], 'safe'],
            [['VatRate', 'VatAmt', 'Discount', 'Deposit', 'Amount', 'TotalAmount', 'PaidAmount'], 'number'],
            [['PostGL', 'PrintDocStatus', 'BranchNo'], 'integer'],
            [['CompanyCode', 'DocType', 'VoucherNo'], 'unique', 'targetAttribute' => ['CompanyCode', 'DocType', 'VoucherNo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    
    public function attributeLabels()
    {
        return $this->labels;
        
    }
}
