<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ApCN".
 *
 * @property string $CompanyCode
 * @property string $ApCN_Number
 * @property string $ApCN_Date
 * @property string $DocType
 * @property string $VoucherNo
 * @property string $DocDate
 * @property string $Buyers
 * @property string $DivisionCode
 * @property string $DeptCode
 * @property string $Voucher_TotalAmount
 * @property string $Voucher_Amount
 * @property string $Vat_Percent
 * @property string $Vat_Amount
 * @property string $Remark1
 * @property string $Remark2
 * @property string $Remark3
 * @property string $Adjust_Date
 * @property int $Adjust_Many
 * @property int $ApCN_Issue
 * @property int $Open_Close
 * @property string $Supp_Number
 * @property string $Disc_Cash
 * @property string $Disc_Percent
 * @property string $Disc_Special
 * @property string $Disc_Money
 * @property string $Amount
 * @property string $TotalAmount
 * @property string $PaidAmount
 * @property string $BranchCode
 * @property string $AccountCode_Tax
 */
class ApCN extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ApCN';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'ApCN_Number', 'ApCN_Issue', 'Open_Close'], 'required'],
            [['CompanyCode', 'ApCN_Number', 'DocType', 'VoucherNo', 'Buyers', 'DivisionCode', 'DeptCode', 'Remark1', 'Remark2', 'Remark3', 'Supp_Number', 'BranchCode', 'AccountCode_Tax'], 'string'],
            [['ApCN_Date', 'DocDate', 'Adjust_Date'], 'safe'],
            [['Voucher_TotalAmount', 'Voucher_Amount', 'Vat_Percent', 'Vat_Amount', 'Disc_Cash', 'Disc_Percent', 'Disc_Special', 'Disc_Money', 'Amount', 'TotalAmount', 'PaidAmount'], 'number'],
            [['Adjust_Many', 'ApCN_Issue', 'Open_Close'], 'integer'],
            [['ApCN_Number', 'CompanyCode'], 'unique', 'targetAttribute' => ['ApCN_Number', 'CompanyCode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'ApCN_Number' => 'Ap Cn  Number',
            'ApCN_Date' => 'Ap Cn  Date',
            'DocType' => 'Doc Type',
            'VoucherNo' => 'Voucher No',
            'DocDate' => 'Doc Date',
            'Buyers' => 'Buyers',
            'DivisionCode' => 'Division Code',
            'DeptCode' => 'Dept Code',
            'Voucher_TotalAmount' => 'Voucher  Total Amount',
            'Voucher_Amount' => 'Voucher  Amount',
            'Vat_Percent' => 'Vat  Percent',
            'Vat_Amount' => 'Vat  Amount',
            'Remark1' => 'Remark1',
            'Remark2' => 'Remark2',
            'Remark3' => 'Remark3',
            'Adjust_Date' => 'Adjust  Date',
            'Adjust_Many' => 'Adjust  Many',
            'ApCN_Issue' => 'Ap Cn  Issue',
            'Open_Close' => 'Open  Close',
            'Supp_Number' => 'Supp  Number',
            'Disc_Cash' => 'Disc  Cash',
            'Disc_Percent' => 'Disc  Percent',
            'Disc_Special' => 'Disc  Special',
            'Disc_Money' => 'Disc  Money',
            'Amount' => 'Amount',
            'TotalAmount' => 'Total Amount',
            'PaidAmount' => 'Paid Amount',
            'BranchCode' => 'Branch Code',
            'AccountCode_Tax' => 'Account Code  Tax',
        ];
    }
}
