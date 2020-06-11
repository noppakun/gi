<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Customer".
 *
 * @property string $Cust_No
 * @property string $Cust_Name
 * @property string $Addr1
 * @property string $Addr2
 * @property string $Addr3
 * @property string $Addr4
 * @property string $Phone
 * @property string $Contact
 * @property string $Position
 * @property string $Saleman
 * @property string $Credit_Limit
 * @property string $Terms
 * @property string $Price_Code
 * @property string $Currency_Type
 * @property string $Shipto_Addr1
 * @property string $Shipto_Addr2
 * @property string $Shipto_Addr3
 * @property string $Shipto_Addr4
 * @property string $CountryCode
 * @property string $Fax
 * @property string $Account_Code
 * @property string $ProvinceCode
 * @property string $AreaCode
 * @property string $DistrictCode
 * @property string $SaleZoneCode
 * @property string $PostalCode
 * @property string $Remark
 * @property string $CustomerTypeCode
 * @property string $CustomerGroupCode
 * @property integer $NotActive
 * @property integer $BlackList
 * @property string $RegisterNo
 * @property string $RegisterExpireDate
 * @property string $Account_Code_Credit
 * @property string $Account_Code_Return
 * @property string $Account_Code_Distcount
 * @property string $Account_Code_Material
 * @property string $Taxid
 * @property string $BranchCode
 * @property string $Vat_ch
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Customer';
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

            
            [['Cust_No', 'Cust_Name', 'Addr1', 'Addr2', 'Addr3', 'Addr4', 'Phone', 'Contact', 'Position', 'Saleman', 'Terms', 'Price_Code', 'Currency_Type', 'Shipto_Addr1', 'Shipto_Addr2', 'Shipto_Addr3', 'Shipto_Addr4', 'CountryCode', 'Fax', 'Account_Code', 'ProvinceCode', 'AreaCode', 'DistrictCode', 'SaleZoneCode', 'PostalCode', 'Remark', 'CustomerTypeCode', 'CustomerGroupCode', 'RegisterNo', 'Account_Code_Credit', 'Account_Code_Return', 'Account_Code_Distcount', 'Account_Code_Material', 'Taxid', 'BranchCode', 'Vat_ch'], 'string'],
            [['Credit_Limit'], 'number'],
            [['NotActive', 'BlackList'], 'integer'],
            [['RegisterExpireDate'], 'safe'],
            [['Cust_No'], 'required'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Cust_No' => 'รหัสลูกค้า',
            'Cust_Name' => 'ชื่อลูกค้า',
            'Addr1' => 'Addr1',
            'Addr2' => 'Addr2',
            'Addr3' => 'Addr3',
            'Addr4' => 'Addr4',
            'Phone' => 'Phone',
            'Contact' => 'Contact',
            'Position' => 'Position',
            'Saleman' => 'Saleman',
            'Credit_Limit' => 'Credit  Limit',
            'Terms' => 'Terms',
            'Price_Code' => 'Price  Code',
            'Currency_Type' => 'Currency  Type',
            'Shipto_Addr1' => 'Shipto  Addr1',
            'Shipto_Addr2' => 'Shipto  Addr2',
            'Shipto_Addr3' => 'Shipto  Addr3',
            'Shipto_Addr4' => 'Shipto  Addr4',
            'CountryCode' => 'Country Code',
            'Fax' => 'Fax',
            'Account_Code' => 'Account  Code',
            'ProvinceCode' => 'Province Code',
            'AreaCode' => 'Area Code',
            'DistrictCode' => 'District Code',
            'SaleZoneCode' => 'Sale Zone Code',
            'PostalCode' => 'Postal Code',
            'Remark' => 'Remark',
            'CustomerTypeCode' => 'Customer Type Code',
            'CustomerGroupCode' => 'Customer Group Code',
            'NotActive' => 'Not Active',
            'BlackList' => 'Black List',
            'RegisterNo' => 'Register No',
            'RegisterExpireDate' => 'Register Expire Date',
            'Account_Code_Credit' => 'Account  Code  Credit',
            'Account_Code_Return' => 'Account  Code  Return',
            'Account_Code_Distcount' => 'Account  Code  Distcount',
            'Account_Code_Material' => 'Account  Code  Material',
            'Taxid' => 'Taxid',
            'BranchCode' => 'Branch Code',
            'Vat_ch' => 'Vat Ch',
        ];
    }
}
