<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Supplier".
 *
 * @property string $Supp_Number
 * @property string $Supp_Name
 * @property string $Addr1
 * @property string $Addr2
 * @property string $Addr3
 * @property string $Addr4
 * @property string $Contact
 * @property string $Position
 * @property string $Remarks
 * @property string $Phone
 * @property string $Fax
 * @property string $Credit_Limit
 * @property string $Terms
 * @property string $Currency_Type
 * @property string $Account_Code
 * @property integer $Supp_Cancel
 * @property string $TaxID
 * @property string $SupplierTypeCode
 * @property string $BranchCode
 * @property string $Vat_Ch
 */
class Supplier extends \yii\db\ActiveRecord
{
    public $labels = [
        'Supp_Number' => 'รหัส Supplier',
        'Supp_Name' => 'ชื่อ Supplier',
        'Addr1' => 'ที่อยู่ 1',
        'Addr2' => 'ที่อยู่ 2',
        'Addr3' => 'ที่อยู่ 3',
        'Addr4' => 'ที่อยู่ 4',
        'Contact' => 'ซื่อผู้ติดต่อ',
        'Position' => 'ตำแหน่ง',
        'Remarks' => 'หมายเหตุ',
        'Phone' => 'โทรศัพท์',
        'Fax' => 'โทรสาร',
        'Credit_Limit' => 'วงเงินอนุมัติ',
        'Terms' => 'เครดิต',
        'Currency_Type' => 'อัตราแลกเปลี่ยน',
        'Account_Code' => 'Account  Code',
        'Supp_Cancel' => 'ยกเเลิก',
        'TaxID' => 'เลขประจำตัวผู้เสียภาษี',
        'SupplierTypeCode' => 'ประเภท Supplier',
        'BranchCode' => 'สาขา',
        'Vat_Ch' => 'ภพ. 20',
    ];    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Supplier';
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
            [['Supp_Number'], 'required'],
            [['Supp_Number', 'Supp_Name', 'Addr1', 'Addr2', 'Addr3', 'Addr4', 'Contact', 'Position', 'Remarks', 'Phone', 'Fax', 'Terms', 'Currency_Type', 'Account_Code', 'TaxID', 'SupplierTypeCode', 'BranchCode', 'Vat_Ch'], 'string'],
            [['Credit_Limit'], 'number'],
            [['Supp_Cancel'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->labels;
    }
}
