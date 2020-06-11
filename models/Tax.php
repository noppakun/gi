<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Tax".
 *
 * @property string $TaxType
 * @property string $TaxInv
 * @property string $Supp_TaxInv
 * @property string $InvDate
 * @property string $Period
 * @property integer $Late
 * @property string $CsCode
 * @property string $Amount1
 * @property string $Vat1
 * @property string $Amount2
 * @property string $Vat2
 * @property string $Amount3
 * @property string $Remark1
 * @property string $Remark2
 * @property string $DocType
 * @property string $CompanyCode
 * @property string $VoucherNo
 * @property string $UserName
 * @property string $LastUpdate
 * @property string $Cust_no
 * @property string $supp_number
 * @property string $Supp_Name
 * @property string $TaxId
 * @property string $BranchCode
 * @property string $Vat_Ch
 */
class Tax extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Tax';
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
            [['TaxType', 'TaxInv', 'Supp_TaxInv', 'InvDate', 'Period', 'DocType', 'CompanyCode', 'VoucherNo'], 'required'],
            [['TaxType', 'TaxInv', 'Supp_TaxInv', 'Period', 'CsCode', 'Remark1', 'Remark2', 'DocType', 'CompanyCode', 'VoucherNo', 'UserName', 'Cust_no', 'supp_number', 'Supp_Name', 'TaxId', 'BranchCode', 'Vat_Ch'], 'string'],
            [['InvDate', 'LastUpdate'], 'safe'],
            [['Late'], 'integer'],
            [['Amount1', 'Vat1', 'Amount2', 'Vat2', 'Amount3'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TaxType' => 'Tax Type',
            'TaxInv' => 'เลขที่ออกใหม่',
            'Supp_TaxInv' => 'เลขที่ใบกำกับภาษี',
            'InvDate' => 'Inv Date',
            'Period' => 'Period',
            'Late' => 'Late',
            'CsCode' => 'Cs Code',
            'Amount1' => 'ภาษีซื้อที่ขอคืนได้ - สินค้า',
            'Vat1' => 'ภาษีซื้อที่ขอคืนได้ - ภาษี',
            'Amount2' => 'Amount2',
            'Vat2' => 'Vat2',
            'Amount3' => 'Amount3',
            'Remark1' => 'Remark1',
            'Remark2' => 'Remark2',
            'DocType' => 'Doc Type',
            'CompanyCode' => 'Company Code',
            'VoucherNo' => 'Voucher No',
            'UserName' => 'User Name',
            'LastUpdate' => 'Last Update',
            'Cust_no' => 'Cust No',
            'supp_number' => 'Supp Number',
            'Supp_Name' => 'Supp  Name',
            'TaxId' => 'Tax ID',
            'BranchCode' => 'Branch Code',
            'Vat_Ch' => 'Vat  Ch',
        ];
    }
}
