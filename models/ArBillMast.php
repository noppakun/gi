<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ArBillMast".
 *
 * @property string $CompanyCode
 * @property string $ArBillNo
 * @property string $ArBillDate
 * @property string $Cust_No
 * @property string $ArDocDate
 * @property string $ArRemark
 * @property string $ArDueDate
 * @property string $CreditTerm
 * @property string $UserName
 * @property string $LastUpdate
 */
class ArBillMast extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ArBillMast';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'ArBillNo', 'ArBillDate'], 'required'],
            [['CompanyCode', 'ArBillNo', 'Cust_No', 'ArRemark', 'CreditTerm', 'UserName'], 'string'],
            [['ArBillDate', 'ArDocDate', 'ArDueDate', 'LastUpdate'], 'safe'],
            [['ArBillNo', 'CompanyCode'], 'unique', 'targetAttribute' => ['ArBillNo', 'CompanyCode']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'ArBillNo' => 'เลขที่ใบวางบิล (Ar Bill No)',
            'ArBillDate' => 'Ar Bill Date',
            'Cust_No' => 'Cust  No',
            'ArDocDate' => 'วันที่ไปวางบิล (Ar Doc Date)',
            'ArRemark' => 'Ar Remark',
            'ArDueDate' => 'วันที่นัดรับเงิน (Ar Due Date)',
            'CreditTerm' => 'Credit Term',
            'UserName' => 'User Name',
            'LastUpdate' => 'Last Update',
        ];
    }
}
