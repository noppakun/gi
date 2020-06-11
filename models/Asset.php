<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Asset".
 *
 * @property string $AssetCode
 * @property string $VoucherNo
 * @property string $Recv_Date
 * @property string $PONo
 * @property string $AccountNo
 * @property string $AssetFor
 * @property string $InvoiceNo
 * @property string $Supp_Number
 * @property string $Supp_Name
 * @property string $Asset_Category_Code
 * @property string $Asset_Type_Code
 * @property string $CompanyCode
 * @property string $DivisionCode
 * @property string $DeptCode
 * @property string $SectionCode
 * @property string $AssetDate
 * @property string $AssetName
 * @property string $Model
 * @property string $SerialNo
 * @property integer $Qty
 * @property string $AssetUnit
 * @property string $Asset_Location_Code
 * @property string $Asset_AccountNo
 * @property string $WaranteeNo
 * @property string $InsuranceCorp
 * @property string $InsuranceNo
 * @property string $InsuranceRate
 * @property string $Insurance_Life
 * @property string $WaranteeStart
 * @property string $WaranteeStop
 * @property string $Depreciate
 * @property string $CostNovat
 * @property string $Vat_Percent
 * @property string $Vat
 * @property string $Cost
 * @property string $Remark
 * @property string $Sale_Date
 * @property string $Sale_Price
 * @property string $Sale_DocNo
 * @property string $Sale_Remark
 * @property integer $Sale_Status
 * @property string $PaidAmount
 * @property string $CsCode
 * @property string $DepreciationBF
 * @property string $InitialAllowance
 * @property string $DepreciationMethod
 * @property integer $CalcDepreciation
 * @property string $DepreciationRemain
 * @property string $DepreciationManual
 * @property string $DepreciationManualDate
 * @property integer $AssetLifeYear
 * @property string $Acc_Depreciation
 * @property string $Acc_AccumulatedDepreciation
 * @property string $CalcDepreciationType
 * @property string $AccountCode_Tax
 * @property string $BranchCode
 * @property string $InvoiceDate
 * @property string $Acc_ScrapValue
 */
class Asset extends \yii\db\ActiveRecord
{


    public function afterFind(){

        parent::afterFind();
        $this->AssetDate = \app\components\XLib::dateConv($this->AssetDate,'a'); 
    }
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->AssetDate = \app\components\XLib::dateConv($this->AssetDate,'b');
        return true;
    } 
    
    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Asset';
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
            [['AssetCode'], 'required'],
            [['AssetCode', 'VoucherNo', 'PONo', 'AccountNo', 'AssetFor', 'InvoiceNo', 'Supp_Number', 'Supp_Name', 'Asset_Category_Code', 'Asset_Type_Code', 'CompanyCode', 'DivisionCode', 'DeptCode', 'SectionCode', 'AssetName', 'Model', 'SerialNo', 'AssetUnit', 'Asset_Location_Code', 'Asset_AccountNo', 'WaranteeNo', 'InsuranceCorp', 'InsuranceNo', 'Remark', 'Sale_DocNo', 'Sale_Remark', 'CsCode', 'DepreciationMethod', 'Acc_Depreciation', 'Acc_AccumulatedDepreciation', 'CalcDepreciationType', 'AccountCode_Tax', 'BranchCode', 'Acc_ScrapValue'], 'string'],
            [['Recv_Date', 'AssetDate', 'WaranteeStart', 'WaranteeStop', 'Sale_Date', 'DepreciationManualDate', 'InvoiceDate'], 'safe'],
            [['Qty', 'Sale_Status', 'CalcDepreciation', 'AssetLifeYear'], 'integer'],
            [['InsuranceRate', 'Insurance_Life', 'Depreciate', 'CostNovat', 'Vat_Percent', 'Vat', 'Cost', 'Sale_Price', 'PaidAmount', 'DepreciationBF', 'InitialAllowance', 'DepreciationRemain', 'DepreciationManual'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AssetCode' => 'เลขที่ทรัพย์สิน',
            'VoucherNo' => 'เลขที่ใบสำคัญ',
            'Recv_Date' => 'วันที่เอกสาร',
            'PONo' => 'Pono',
            'AccountNo' => 'Account No',
            'AssetFor' => 'Asset For',
            'InvoiceNo' => 'Invoice No',
            'Supp_Number' => 'Supp  Number',
            'Supp_Name' => 'Supp  Name',
            'Asset_Category_Code' => 'Asset  Category  Code',
            'Asset_Type_Code' => 'Asset  Type  Code',
            'CompanyCode' => 'Company Code',
            'DivisionCode' => 'Division Code',
            'DeptCode' => 'Dept Code',
            'SectionCode' => 'Section Code',
            'AssetDate' => 'วันที่เริ่มคิดค่าเสื่อม',
            'AssetName' => 'ซื่อทรัพย์สิน',
            'Model' => 'Model',
            'SerialNo' => 'Serial No',
            'Qty' => 'Qty',
            'AssetUnit' => 'Asset Unit',
            'Asset_Location_Code' => 'Asset  Location  Code',
            'Asset_AccountNo' => 'เลขที่บัญชีทรัพย์สิน',
            'WaranteeNo' => 'Warantee No',
            'InsuranceCorp' => 'Insurance Corp',
            'InsuranceNo' => 'Insurance No',
            'InsuranceRate' => 'Insurance Rate',
            'Insurance_Life' => 'Insurance  Life',
            'WaranteeStart' => 'Warantee Start',
            'WaranteeStop' => 'Warantee Stop',
            'Depreciate' => 'อัตราค่าเสื่อมราคา/ปี',
            'CostNovat' => 'Cost Novat',
            'Vat_Percent' => 'Vat  Percent', 
            'Vat' => 'Vat',
            'Cost' => 'Cost',
            'Remark' => 'Remark',
            'Sale_Date' => 'Sale  Date',
            'Sale_Price' => 'Sale  Price',
            'Sale_DocNo' => 'Sale  Doc No',
            'Sale_Remark' => 'Sale  Remark',
            'Sale_Status' => 'Sale  Status',
            'PaidAmount' => 'Paid Amount',
            'CsCode' => 'Cs Code',
            'DepreciationBF' => 'Depreciation Bf',
            'InitialAllowance' => 'Initial Allowance',
            'DepreciationMethod' => 'Depreciation Method',
            'CalcDepreciation' => 'คิดค่าเสื่อม',
            'DepreciationRemain' => 'ราคาซาก',
            'DepreciationManual' => 'Depreciation Manual',
            'DepreciationManualDate' => 'Depreciation Manual Date',
            'AssetLifeYear' => 'Asset Life Year',
            'Acc_Depreciation' => 'บัญชีค่าเสื่อม (DR.)',
            'Acc_AccumulatedDepreciation' => 'บัญชีค่าเสื่อมสะสม (CR.)',
            'CalcDepreciationType' => 'Calc Depreciation Type',
            'AccountCode_Tax' => 'Account Code  Tax',
            'BranchCode' => 'Branch Code',
            'InvoiceDate' => 'Invoice Date',
            'Acc_ScrapValue' => 'บัญชีมูลค่าซาก (DR.)',
        ];
    }
}
