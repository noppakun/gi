<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "BankTransactionDetailAcc".
 *
 * @property string $CompanyCode
 * @property string $BankTranType
 * @property string $VoucherNo
 * @property string $AccountCode
 * @property string $Amount
 * @property int $seq_number
 * @property string $CsCode
 * @property string $AccountDesc
 */
class BankTransactionDetailAcc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'BankTransactionDetailAcc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'BankTranType', 'VoucherNo', 'AccountCode', 'seq_number'], 'required'],
            [['CompanyCode', 'BankTranType', 'VoucherNo', 'AccountCode', 'CsCode', 'AccountDesc'], 'string'],
            [['Amount'], 'number'],
            [['seq_number'], 'integer'],
            [['AccountCode', 'BankTranType', 'CompanyCode', 'seq_number', 'VoucherNo'], 'unique', 'targetAttribute' => ['AccountCode', 'BankTranType', 'CompanyCode', 'seq_number', 'VoucherNo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'BankTranType' => 'Bank Tran Type',
            'VoucherNo' => 'Voucher No',
            'AccountCode' => 'Account Code',
            'Amount' => 'Amount',
            'seq_number' => 'Seq Number',
            'CsCode' => 'Cs Code',
            'AccountDesc' => 'Account Desc',
        ];
    }
}
