<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "BankTransaction".
 *
 * @property string $CompanyCode
 * @property string $BankTranType
 * @property string $VoucherNo
 * @property string $BankCode
 * @property string $TranDate
 * @property string $RefDoc
 * @property string $Remark
 * @property string $ChqNo
 * @property string $Amount
 * @property string $Charge
 * @property string $VatAmt
 * @property string $NetAmt
 * @property string $BankCode2
 * @property string $Supp_Number
 * @property string $Supp_Name
 * @property string $GIncome_Code
 * @property string $Income_Code
 * @property string $GExpend_Code
 * @property string $Expend_Code
 * @property string $TranDate2
 * @property string $BranchCode
 * @property string $PaymentWithHoldingTax
 * @property string $expend_Accountcode
 * @property string $Account_PaymentWithHoldingTax
 * @property string $Income_AccountCode
 * @property string $AccountCode_Tax
 * @property string $VoucherNoRef
 * @property string $Inv_Number
 * @property string $Inv_date
 * @property string $TransferStatus
 * @property string $TaxID
 * @property integer $BranchNo
 */
/*
    
    $BankTranType   from Pattanawit
    R0 ยอดยกมา
    R1 ฝากเงินสด
    R2 รายได้เข้าบัญชีธนาคาร/รับดอกเบี้ยธนาคาร
    I1 ถอนเงินสด
    I2 ค่าใช้จ่ายธนาคาร - จ่ายค่าดอกเบี้ย
    I3 ค่าใช้จ่ายธนาคาร - จ่ายค่าธรรมเนียม
    I4 ถอนเงินสดโดยใช้เช็ค
    I5 ชำระค่าใช้จ่ายอื่นโดยใช้เช็ค (ไม่ผ่านการวางบิล)
    I6 ค่าใช้จ่ายธนาคาร - จ่ายค่าใช้จ่ายอื่นๆ
    L1 โอนเงินระหว่างธนาคาร
    AI เงินทดรองจ่าย

*/ 
 
class BankTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'BankTransaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'BankTranType', 'VoucherNo', 'BankCode'], 'required'],
            [['CompanyCode', 'BankTranType', 'VoucherNo', 'BankCode', 'RefDoc', 'Remark', 'ChqNo', 'BankCode2', 'Supp_Number', 'Supp_Name', 'GIncome_Code', 'Income_Code', 'GExpend_Code', 'Expend_Code', 'BranchCode', 'expend_Accountcode', 'Account_PaymentWithHoldingTax', 'Income_AccountCode', 'AccountCode_Tax', 'VoucherNoRef', 'Inv_Number', 'TransferStatus', 'TaxID'], 'string'],
            [['TranDate', 'TranDate2', 'Inv_date'], 'safe'],
            [['Amount', 'Charge', 'VatAmt', 'NetAmt', 'PaymentWithHoldingTax'], 'number'],
            [['BranchNo'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'BankTranType' => 'Bank Tran Type',
            'VoucherNo' => 'Voucher No',
            'BankCode' => 'Bank Code',
            'TranDate' => 'Tran Date',
            'RefDoc' => 'Ref Doc',
            'Remark' => 'Remark',
            'ChqNo' => 'Chq No',
            'Amount' => 'Amount',
            'Charge' => 'Charge',
            'VatAmt' => 'Vat Amt',
            'NetAmt' => 'Net Amt',
            'BankCode2' => 'Bank Code2',
            'Supp_Number' => 'Supp  Number',
            'Supp_Name' => 'Supp  Name',
            'GIncome_Code' => 'Gincome  Code',
            'Income_Code' => 'Income  Code',
            'GExpend_Code' => 'Gexpend  Code',
            'Expend_Code' => 'Expend  Code',
            'TranDate2' => 'Tran Date2',
            'BranchCode' => 'Branch Code',
            'PaymentWithHoldingTax' => 'Payment With Holding Tax',
            'expend_Accountcode' => 'Expend  Accountcode',
            'Account_PaymentWithHoldingTax' => 'Account  Payment With Holding Tax',
            'Income_AccountCode' => 'Income  Account Code',
            'AccountCode_Tax' => 'Account Code  Tax',
            'VoucherNoRef' => 'Voucher No Ref',
            'Inv_Number' => 'Inv  Number',
            'Inv_date' => 'Inv Date',
            'TransferStatus' => 'Transfer Status',
            'TaxID' => 'Tax ID',
            'BranchNo' => 'Branch No',
        ];
    }
}
