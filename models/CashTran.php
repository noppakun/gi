<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CashTran".
 *
 * @property string $CompanyCode
 * @property string $Type
 * @property string $VoucherNo
 * @property string $DocNo
 * @property string $BillNo
 * @property string $DocType
 * @property string $Amount
 * @property string $PayAmount
 * @property string $BalanceAmount
 * @property string $DocDate
 * @property string $Accnum 
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
class CashTran extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CashTran';
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
            [['CompanyCode', 'Type', 'VoucherNo', 'DocNo', 'BillNo', 'DocType'], 'required'],
            [['CompanyCode', 'Type', 'VoucherNo', 'DocNo', 'BillNo', 'DocType', 'Accnum' ], 'string'],
            [['Amount', 'PayAmount', 'BalanceAmount'], 'number'],
            [['DocDate'], 'safe']
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
            'DocNo' => 'Doc No',
            'BillNo' => 'Bill No',
            'DocType' => 'Doc Type',
            'Amount' => 'Amount',
            'PayAmount' => 'Pay Amount',
            'BalanceAmount' => 'Balance Amount',
            'DocDate' => 'Doc Date',
            'Accnum' => 'Accnum',
            
        ];
    }
}
