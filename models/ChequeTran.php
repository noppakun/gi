<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ChequeTran".
 *
 * @property string $CompanyCode
 * @property string $Type
 * @property string $VoucherNo
 * @property string $ChqNo
 * @property string $ChqStatus
 * @property string $ChqDate
 * @property string $ChqCode
 * @property string $BankCode
 * @property string $BankBranch
 * @property string $ChqPayAmount
 * @property string $ChqRecvDate
 * @property string $ChqPassDate
 * @property string $ChqDepositDate
 * @property string $Fee
 * @property string $Remark
 * @property string $DepositSlip_CompanyCode
 * @property string $DepositSlip_Type
 * @property string $DepositSlip_VoucherNo
 * @property string $ChqLocationCode
 * 
 

 
 */
/*
** ChqStatus  from Pattanawit
    00 เช็คในมือ
    01 รอเรียกเก็บ
    02 เช็คคืนยื่นใหม่
    03 เช็คยกเลิกออกใหม่
    05 เช็คจ่าย
    10 เช็คผ่าน
    20 เช็คคืน
    21 ตัดหนี้สูญ
    22 เช็คยกเลิก
    23 เช็คยกเลิกออกใหม่
*/  
class ChequeTran extends \yii\db\ActiveRecord
{
    
    public static $ChqStatus_LIST = [          
        '00' =>'เช็คในมือ',
        '01' =>'รอเรียกเก็บ',
        '02' =>'เช็คคืนยื่นใหม่',
        '03' =>'เช็คยกเลิกออกใหม่',
        '05' =>'เช็คจ่าย',
        '10' =>'เช็คผ่าน',
        '20' =>'เช็คคืน',
        '21' =>'ตัดหนี้สูญ',
        '22' =>'เช็คยกเลิก',
        '23' =>'เช็คยกเลิกออกใหม่',
    ];  
    public function getChqStatusDesc()    {
        
        return self::$ChqStatus_LIST[$this->ChqStatus];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ChequeTran';
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
            [['CompanyCode', 'Type', 'VoucherNo', 'ChqNo', 'ChqStatus', 'ChqCode'], 'required'],
            [['CompanyCode', 'Type', 'VoucherNo', 'ChqNo', 'ChqStatus', 'ChqCode', 'BankCode', 'BankBranch', 'Remark', 'DepositSlip_CompanyCode', 'DepositSlip_Type', 'DepositSlip_VoucherNo', 'ChqLocationCode'], 'string'],
            [['ChqDate', 'ChqRecvDate', 'ChqPassDate', 'ChqDepositDate'], 'safe'],
            [['ChqPayAmount', 'Fee'], 'number'],
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
            'ChqNo' => 'Chq No',
            'ChqStatus' => 'Chq Status',
            'ChqDate' => 'Chq Date',
            'ChqCode' => 'Chq Code',
            'BankCode' => 'Bank Code',
            'BankBranch' => 'Bank Branch',
            'ChqPayAmount' => 'Chq Pay Amount',
            'ChqRecvDate' => 'Chq Recv Date',
            'ChqPassDate' => 'Chq Pass Date',
            'ChqDepositDate' => 'Chq Deposit Date',
            'Fee' => 'Fee',
            'Remark' => 'Remark',
            'DepositSlip_CompanyCode' => 'Deposit Slip  Company Code',
            'DepositSlip_Type' => 'Deposit Slip  Type',
            'DepositSlip_VoucherNo' => 'Deposit Slip  Voucher No',
            'ChqLocationCode' => 'Chq Location Code',
        ];
    }
}
