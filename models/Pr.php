<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pr".
 *
 * @property string $Companycode
 * @property string $PR_Number
 * @property string $Supp_Number
 * @property string $Quote
 * @property string $Shipto_Addr1
 * @property string $Shipto_Addr2
 * @property string $Currency_Type
 * @property string $Remarks
 * @property string $Remarks2
 * @property string $Remarks3
 * @property string $Order_Date
 * @property string $Buyers
 * @property string $Terms
 * @property integer $PO_Issue
 * @property integer $Open_Close
 * @property string $DeptCode
 * @property string $DivisionCode
 * @property string $UserName
 * @property string $LastUpdate
 */
class Pr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        return $this->hasMany(PRDetail::className(), ['PR_Number' => 'PR_Number']);
    }     
    public static function tableName()
    {
        return 'pr';
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
            [['Companycode', 'PR_Number', 'Order_Date', 'Buyers', 'PO_Issue', 'Open_Close'], 'required'],
            [['Companycode', 'PR_Number', 'Supp_Number', 'Quote', 'Shipto_Addr1', 'Shipto_Addr2', 'Currency_Type', 'Remarks', 'Remarks2', 'Remarks3', 'Buyers', 'Terms', 'DeptCode', 'DivisionCode', 'UserName'], 'string'],
            [['Order_Date', 'LastUpdate'], 'safe'],
            [['PO_Issue', 'Open_Close'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Companycode' => 'Companycode',
            'PR_Number' => 'Pr  Number',
            'Supp_Number' => 'Supp  Number',
            'Quote' => 'Quote',
            'Shipto_Addr1' => 'สถานที่ส่งของ',
            'Shipto_Addr2' => 'สถานที่ส่งของ',
            'Currency_Type' => 'Currency  Type',
            'Remarks' => 'Remarks',
            'Remarks2' => 'Remarks2',
            'Remarks3' => 'Remarks3',
            'Order_Date' => 'PR. Date',
            'Buyers' => 'Buyers',
            'Terms' => 'Terms',
            'PO_Issue' => 'เปิด PO แล้ว/ยัง (Po  Issue)',
            'Open_Close' => 'Open  Close',
            'DeptCode' => 'Dept Code',
            'DivisionCode' => 'Division Code',
            'UserName' => 'User Name',
            'LastUpdate' => 'Last Update',
        ];
    }
}
