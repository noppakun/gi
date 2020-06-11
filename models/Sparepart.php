<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Item".
 *
 * @property string $Item_Number
 * @property string $WhCode
 * @property string $Loc_Number
 * @property string $Item_Name
 * @property string $Uom
 * @property string $Type_Invent_Code
 * @property string $Group_Product
 * @property string $Product
 * @property string $Brand
 * @property string $Type
 * @property string $SubType
 * @property string $Tariff_Code
 * @property string $Industry_Code
 * @property string $InsteadCode
 * @property integer $Pack
 * @property string $PackSize
 * @property string $PackUom
 * @property string $QtyOnhand
 * @property string $Price
 * @property string $Price_A
 * @property string $Price_B
 * @property string $Price_C
 * @property string $Price_D
 * @property string $Minimum
 * @property string $Maximum
 * @property string $Supp_Number
 * @property string $Uom_Buy
 * @property string $LastBuyDate
 * @property string $LastBuyPrice
 * @property string $LastBuyCurrency_type
 * @property string $Uom_Sale
 * @property string $LastSaleDate
 * @property string $LastSalePrice
 * @property integer $Flag_Ana
 * @property string $Class
 * @property string $Source
 * @property integer $LeadTime
 * @property string $Account_Code
 * @property string $Balbf
 * @property string $Balbf_Avg_Cost
 * @property string $Balbf_Fifo_Cost
 * @property string $Order_Policy
 * @property string $Sales_Reserved
 * @property string $Prodn_Reserved
 * @property string $Cost_Type
 * @property integer $Iqc_Check
 * @property integer $Life_Check
 * @property integer $RetestDate_Check
 * @property resource $Picture
 * @property string $CompanyCode
 * @property integer $Shrink
 * @property integer $ShrinkSize
 * @property string $Item_Type
 * @property string $CSCode
 * @property integer $Lot_Size
 * @property integer $Retest_Cycle
 * @property string $Scrap_Qty
 * @property string $LastPclDate
 * @property string $QtyOnhand_OH
 * @property string $OHCode
 * @property string $UserName
 * @property string $LastUpdate
 * @property string $Buffer
 * @property string $LabelPrice
 * @property string $Remark
 * @property integer $ShelfLife
 * @property string $FormatDateCoding
 * @property string $Waste_Qty
 * @property string $Defective_Qty
 * @property string $Good_Qty
 * @property string $CateCode
 * @property string $AvgSale_OH
 * @property string $VariableCost
 * @property string $FixedCost
 * @property string $ControlItemType
 * @property integer $Std_Approve_Purchase_LeadTime
 * @property integer $Std_Apprv_Production_LeadTime
 * @property integer $Std_Purchase_LeadTime
 * @property integer $Tag_Qty
 * @property string $Pallet
 * @property string $StandardCost
 * @property string $Sale_Category_Code
 * @property string $WeightPerCorbox
 * @property string $Account_Code_Credit
 * @property string $AvgCost
 * @property string $StorageConditionCode
 * @property string $Cust_No
 * @property string $Barcode
 * @property string $Carton_Width
 * @property string $Carton_Hight
 * @property string $Carton_Depth
 * @property string $Box_Width
 * @property string $Box_Hight
 * @property string $Box_Depth
 * @property string $Box_Weight
 * @property string $Box_Weight_Qty
 * @property string $Keep_Temperature
 * @property integer $Pallet_Row
 * @property integer $Pallet_Layer
 * @property integer $NotActive
 * @property string $CostOfAssay
 * @property string $QtyPerPackSize
 * @property string $WeightPerPackSize
 * @property string $Remark1_Coding
 * @property string $Remark2_Coding
 */
class Sparepart extends \yii\db\ActiveRecord
{
    public static function find()
    {
        return parent::find()->where(['Item_Type' => '5']);
    }
    /**
     * @inheritdoc
     */
    public function getMachineText()
    {
        $data = $this->hasMany(MachineSpareParts::className(), ['Item_Number'=>'Item_Number' ])->all();  
        $mac_text='';
        foreach($data as $mac){        
            $mac_text.= ($mac_text==''?'':', ').$mac->MachCode;
        }                                        
        return ($mac_text);        
    }       
    
    public static function tableName()
    {
        return 'Item';
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
            [['Item_Number', 'Uom', 'Flag_Ana', 'Source', 'Iqc_Check', 'Item_Type'], 'required'],
            [['Item_Number', 'WhCode', 'Loc_Number', 'Item_Name', 'Uom', 'Type_Invent_Code', 'Group_Product', 'Product', 'Brand', 'Type', 'SubType', 'Tariff_Code', 'Industry_Code', 'InsteadCode', 'PackUom', 'Price', 'Supp_Number', 'Uom_Buy', 'LastBuyCurrency_type', 'Uom_Sale', 'Class', 'Source', 'Account_Code', 'Order_Policy', 'Cost_Type', 'Picture', 'CompanyCode', 'Item_Type', 'CSCode', 'OHCode', 'UserName', 'Remark', 'FormatDateCoding', 'CateCode', 'ControlItemType', 'Sale_Category_Code', 'Account_Code_Credit', 'StorageConditionCode', 'Cust_No', 'Barcode', 'Remark1_Coding', 'Remark2_Coding'], 'string'],
            [['Pack', 'Flag_Ana', 'LeadTime', 'Iqc_Check', 'Life_Check', 'RetestDate_Check', 'Shrink', 'ShrinkSize', 'Lot_Size', 'Retest_Cycle', 'ShelfLife', 'Std_Approve_Purchase_LeadTime', 'Std_Apprv_Production_LeadTime', 'Std_Purchase_LeadTime', 'Tag_Qty', 'Pallet_Row', 'Pallet_Layer', 'NotActive'], 'integer'],
            [['PackSize', 'QtyOnhand', 'Price_A', 'Price_B', 'Price_C', 'Price_D', 'Minimum', 'Maximum', 'LastBuyPrice', 'LastSalePrice', 'Balbf', 'Balbf_Avg_Cost', 'Balbf_Fifo_Cost', 'Sales_Reserved', 'Prodn_Reserved', 'Scrap_Qty', 'QtyOnhand_OH', 'Buffer', 'LabelPrice', 'Waste_Qty', 'Defective_Qty', 'Good_Qty', 'AvgSale_OH', 'VariableCost', 'FixedCost', 'Pallet', 'StandardCost', 'WeightPerCorbox', 'AvgCost', 'Carton_Width', 'Carton_Hight', 'Carton_Depth', 'Box_Width', 'Box_Hight', 'Box_Depth', 'Box_Weight', 'Box_Weight_Qty', 'Keep_Temperature', 'CostOfAssay', 'QtyPerPackSize', 'WeightPerPackSize'], 'number'],
            [['LastBuyDate', 'LastSaleDate', 'LastPclDate', 'LastUpdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'Item_Number' => 'รหัส',
            'WhCode' => 'Wh Code',
            'Loc_Number' => 'Loc  Number',
            'Item_Name' => 'รายละเอียด',
            'Uom' => 'หน่วย',
            'Type_Invent_Code' => 'Type  Invent  Code',
            'Group_Product' => 'Group  Product',
            'Product' => 'Product',
            'Brand' => 'Brand',
            'Type' => 'Type',
            'SubType' => 'Sub Type',
            'Tariff_Code' => 'Tariff  Code',
            'Industry_Code' => 'Industry  Code',
            'InsteadCode' => 'Instead Code',
            'Pack' => 'Pack',
            'PackSize' => 'Pack Size',
            'PackUom' => 'Pack Uom',
            'QtyOnhand' => 'Qty Onhand',
            'Price' => 'Price',
            'Price_A' => 'Price  A',
            'Price_B' => 'Price  B',
            'Price_C' => 'Price  C',
            'Price_D' => 'Price  D',
            'Minimum' => 'Minimum',
            'Maximum' => 'Maximum',
            'Supp_Number' => 'Supp  Number',
            'Uom_Buy' => 'Uom  Buy',
            'LastBuyDate' => 'Last Buy Date',
            'LastBuyPrice' => 'Last Buy Price',
            'LastBuyCurrency_type' => 'Last Buy Currency Type',
            'Uom_Sale' => 'Uom  Sale',
            'LastSaleDate' => 'Last Sale Date',
            'LastSalePrice' => 'Last Sale Price',
            'Flag_Ana' => 'Flag  Ana',
            'Class' => 'Class',
            'Source' => 'Source',
            'LeadTime' => 'Lead Time',
            'Account_Code' => 'Account  Code',
            'Balbf' => 'Balbf',
            'Balbf_Avg_Cost' => 'Balbf  Avg  Cost',
            'Balbf_Fifo_Cost' => 'Balbf  Fifo  Cost',
            'Order_Policy' => 'Order  Policy',
            'Sales_Reserved' => 'Sales  Reserved',
            'Prodn_Reserved' => 'Prodn  Reserved',
            'Cost_Type' => 'Cost  Type',
            'Iqc_Check' => 'Iqc  Check',
            'Life_Check' => 'Life  Check',
            'RetestDate_Check' => 'Retest Date  Check',
            'Picture' => 'Picture',
            'CompanyCode' => 'Company Code',
            'Shrink' => 'Shrink',
            'ShrinkSize' => 'Shrink Size',
            'Item_Type' => 'Item  Type',
            'CSCode' => 'Cscode',
            'Lot_Size' => 'Lot  Size',
            'Retest_Cycle' => 'Retest  Cycle',
            'Scrap_Qty' => 'Scrap  Qty',
            'LastPclDate' => 'Last Pcl Date',
            'QtyOnhand_OH' => 'Qty Onhand  Oh',
            'OHCode' => 'Ohcode',
            'UserName' => 'User Name',
            'LastUpdate' => 'Last Update',
            'Buffer' => 'Buffer',
            'LabelPrice' => 'Label Price',
            'Remark' => 'Remark',
            'ShelfLife' => 'Shelf Life',
            'FormatDateCoding' => 'Format Date Coding',
            'Waste_Qty' => 'Waste  Qty',
            'Defective_Qty' => 'Defective  Qty',
            'Good_Qty' => 'Good  Qty',
            'CateCode' => 'Cate Code',
            'AvgSale_OH' => 'Avg Sale  Oh',
            'VariableCost' => 'Variable Cost',
            'FixedCost' => 'Fixed Cost',
            'ControlItemType' => 'Control Item Type',
            'Std_Approve_Purchase_LeadTime' => 'Std  Approve  Purchase  Lead Time',
            'Std_Apprv_Production_LeadTime' => 'Std  Apprv  Production  Lead Time',
            'Std_Purchase_LeadTime' => 'Std  Purchase  Lead Time',
            'Tag_Qty' => 'Tag  Qty',
            'Pallet' => 'Pallet',
            'StandardCost' => 'Standard Cost',
            'Sale_Category_Code' => 'Sale  Category  Code',
            'WeightPerCorbox' => 'Weight Per Corbox',
            'Account_Code_Credit' => 'Account  Code  Credit',
            'AvgCost' => 'Avg Cost',
            'StorageConditionCode' => 'Storage Condition Code',
            'Cust_No' => 'Cust  No',
            'Barcode' => 'Barcode',
            'Carton_Width' => 'Carton  Width',
            'Carton_Hight' => 'Carton  Hight',
            'Carton_Depth' => 'Carton  Depth',
            'Box_Width' => 'Box  Width',
            'Box_Hight' => 'Box  Hight',
            'Box_Depth' => 'Box  Depth',
            'Box_Weight' => 'Box  Weight',
            'Box_Weight_Qty' => 'Box  Weight  Qty',
            'Keep_Temperature' => 'Keep  Temperature',
            'Pallet_Row' => 'Pallet  Row',
            'Pallet_Layer' => 'Pallet  Layer',
            'NotActive' => 'Not Active',
            'CostOfAssay' => 'Cost Of Assay',
            'QtyPerPackSize' => 'Qty Per Pack Size',
            'WeightPerPackSize' => 'Weight Per Pack Size',
            'Remark1_Coding' => 'หมายเหตุ',
            'Remark2_Coding' => 'Remark2  Coding',
        ];
    }
}
