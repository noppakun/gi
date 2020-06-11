<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CashMast".
 *
 * @property string $CompanyCode
 * @property string $Type
 * @property string $VoucherNo
 * @property string $VoucherDate
 * @property string $Supp_Number
 * @property string $Cust_No
 * @property string $Discount
 * @property string $PaymentWithHoldingTax
 * @property string $Remark
 * @property string $TotalAmount
 * @property string $ChqTotalAmount
 * @property string $GIncome_Code
 * @property string $GExpend_Code
 * @property string $Income_Code
 * @property string $Expend_Code
 * @property string $CsCode
 * @property string $BranchCode
 * @property string $Discount_Reverse
 * @property string $Inv_Number
 * @property string $Inv_date
 * @property string $Accnum
 * @property string $Accountcode_Discount
 * @property string $Accountcode_Discount_Reverse
 * @property string $UserName
 * @property string $LastUpdate
 * @property string $AccountCode_Lostliabilities
 * @property string $Discount_Lostliabilities
 * @property string $Account_PaymentWithHoldingTax
 * @property string $VoucherNoRef
 * @property string $VatAmt
 */

 


/*
**  $Type ประเภทการรับจ่ายเงิน  from Pattanawit

รับ
CR รับเงินสด
BR รับเช็ค
RB โอนเงินเข้าบัญชีธนาคาร
RO รับเงินอื่นๆ
RD ตัดหนี้สูญ

จ่าย
CI จ่ายเงินสด
BI จ่ายเช็ค
IB จ่ายหักบัญชีธนาคาร
IO จ่ายเงินอื่นๆ
PB ตั้งวงเงินสดย่อย
PR เบิกทดแทนเงินสดย่อย
*/
class CashMast extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CashMast';
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
            [['CompanyCode', 'Type', 'VoucherNo', 'VoucherDate', 'PaymentWithHoldingTax'], 'required'],
            [['CompanyCode', 'Type', 'VoucherNo', 'Supp_Number', 'Cust_No', 'Remark', 'GIncome_Code', 'GExpend_Code', 'Income_Code', 'Expend_Code', 'CsCode', 'BranchCode', 'Inv_Number', 'Accnum', 'Accountcode_Discount', 'Accountcode_Discount_Reverse', 'UserName', 'AccountCode_Lostliabilities', 'Account_PaymentWithHoldingTax', 'VoucherNoRef'], 'string'],
            [['VoucherDate', 'Inv_date', 'LastUpdate'], 'safe'],
            [['Discount', 'PaymentWithHoldingTax', 'TotalAmount', 'ChqTotalAmount', 'Discount_Reverse', 'Discount_Lostliabilities', 'VatAmt'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'Type' => 'Type',
            'VoucherNo' => 'Voucher No',
            'VoucherDate' => 'Voucher Date',
            'Supp_Number' => 'Supp  Number',
            'Cust_No' => 'Cust  No',
            'Discount' => 'Discount',
            'PaymentWithHoldingTax' => 'Payment With Holding Tax',
            'Remark' => 'Remark',
            'TotalAmount' => 'Total Amount',
            'ChqTotalAmount' => 'Chq Total Amount',
            'GIncome_Code' => 'Gincome  Code',
            'GExpend_Code' => 'Gexpend  Code',
            'Income_Code' => 'Income  Code',
            'Expend_Code' => 'Expend  Code',
            'CsCode' => 'Cs Code',
            'BranchCode' => 'Branch Code',
            'Discount_Reverse' => 'Discount  Reverse',
            'Inv_Number' => 'Inv  Number',
            'Inv_date' => 'Inv Date',
            'Accnum' => 'Accnum',
            'Accountcode_Discount' => 'Accountcode  Discount',
            'Accountcode_Discount_Reverse' => 'Accountcode  Discount  Reverse',
            'UserName' => 'User Name',
            'LastUpdate' => 'Last Update',
            'AccountCode_Lostliabilities' => 'Account Code  Lostliabilities',
            'Discount_Lostliabilities' => 'Discount  Lostliabilities',
            'Account_PaymentWithHoldingTax' => 'Account  Payment With Holding Tax',
            'VoucherNoRef' => 'Voucher No Ref',
            'VatAmt' => 'Vat Amt',
        ];
    }
}
