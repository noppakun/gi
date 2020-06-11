<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "GLJournalDet".
 *
 * @property string $CompanyCode
 * @property string $GLBookCode
 * @property string $VoucherNo
 * @property int $Seq_Number
 * @property string $AccNum
 * @property string $Description
 * @property string $TranType
 * @property string $Amount
 * @property string $UserName
 * @property string $UpdateTime
 * @property string $DebitAmount
 * @property string $CreditAmount
 * @property string $CsCode
 */
class GLJournalDet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'GLJournalDet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'GLBookCode', 'VoucherNo', 'Seq_Number', 'AccNum', 'TranType'], 'required'],
            [['CompanyCode', 'GLBookCode', 'VoucherNo', 'AccNum', 'Description', 'TranType', 'UserName', 'CsCode'], 'string'],
            [['Seq_Number'], 'integer'],
            [['Amount', 'DebitAmount', 'CreditAmount'], 'number'],
            [['UpdateTime'], 'safe'],
            [['AccNum', 'CompanyCode', 'GLBookCode', 'Seq_Number', 'VoucherNo'], 'unique', 'targetAttribute' => ['AccNum', 'CompanyCode', 'GLBookCode', 'Seq_Number', 'VoucherNo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'GLBookCode' => 'Glbook Code',
            'VoucherNo' => 'Voucher No',
            'Seq_Number' => 'Seq  Number',
            'AccNum' => 'Acc Num',
            'Description' => 'Description',
            'TranType' => 'Tran Type',
            'Amount' => 'Amount',
            'UserName' => 'User Name',
            'UpdateTime' => 'Update Time',
            'DebitAmount' => 'Debit Amount',
            'CreditAmount' => 'Credit Amount',
            'CsCode' => 'Cs Code',
        ];
    }
}
