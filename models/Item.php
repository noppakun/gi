<?php

namespace app\models;

use Yii;
 

/**
 * This is the model class for table "{{%Item}}".
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
 * @property int $Std_Fill_LeadTime
 */
/*
Type_Invent_Code (table Type_Invent)

01	Finished Goods                                    
02	Work in Process                                   
03	Semi Finished Goods                               
04	Raw Materials                                     
05	Packaging Materials                               
06	Spare Parts                                       
07	Store Supplies and Others                         
08	Office Supplies                                   
99	Others                                            
*/
class Item extends \yii\db\ActiveRecord
{
   
    
    public static $ControlItemType_LIST = [                                  
        'M'=>'ยา',
        'C'=>'เครื่องสำอาง',
        'F'=>'อาหาร',
    ];                             

    public static $Order_Policy_LIST = [                                  
        'EOQ'=>'Economic Order Quantity (EOQ)',
        'LOT'=>'Lot For Lot (LOT)',
        'RP'=>'Reorder Point (RP)',
    ];                                

    public static $Cost_Type_LIST = [
        'A'=>'Average',
        'F'=>'First IN First OUT',
    ];

    public static $Source_LIST = [                                    
        'B'=>'BUY PART',
        'M'=>'SEMI-MFG',
        'W'=>'COMPLETED ITEMS',
        'S'=>'SUB CONTRACT PART',
        'P'=>'PHANTOM PART',
    ];

    public $labels = [
        'Item_Number' => 'รหัสสินค้า',
        'WhCode' => 'คลังสินค้า',
        'Loc_Number' => 'สถานที่เก็บสินค้า',
        'Item_Name' => 'รายละเอียด',
        'Uom' => 'หน่วยนับ (Uom)',
        // 'Type_Invent_Code' => 'ประเภทกลุ่มสินค้า (Type  Invent  Code)',
        // 'Group_Product' => 'กลุ่มสินค้า (Group  Product)',
        // 'Product' => 'ประเภทสินค้า (Product)',
        // 'Brand' => 'ยี่ห้อสินค้า (Brand)',
        // 'Type' => 'ชนิดสินค้า (Type)',
        // 'SubType' => 'ชนิดย่อยสินค้า (Sub Type)',
        'Type_Invent_Code' => 'ประเภทกลุ่มสินค้า',
        'Group_Product' => 'กลุ่มสินค้า',
        'Product' => 'ประเภทสินค้า',
        'Brand' => 'ยี่ห้อสินค้า',
        'Type' => 'ชนิดสินค้า',
        'SubType' => 'ชนิดย่อยสินค้า',
        
        'Tariff_Code' => 'Tariff  Code',
        'Industry_Code' => 'รหัสโรงงาน / รหัสลูกค้า',
        'InsteadCode' => 'รหัสที่ใช้แทนกันได้',
        'Pack' => 'Pack',
        'PackSize' => 'Pack Size',
        'PackUom' => 'หน่วย Pack',
        'QtyOnhand' => 'จำนวนคงเหลือ',
        'Price' => 'Price',
        'Price_A' => 'Price  A',
        'Price_B' => 'Price  B',
        'Price_C' => 'Price  C',
        'Price_D' => 'Price  D',
        'Minimum' => 'จุดสั่งซื้อ',
        'Maximum' => 'จุดสูงสุด',
        'Supp_Number' => 'Supp  Number',
        'Uom_Buy' => 'Uom  Buy',
        'LastBuyDate' => 'Last Buy Date',
        'LastBuyPrice' => 'Last Buy Price',
        'LastBuyCurrency_type' => 'Last Buy Currency Type',
        'Uom_Sale' => 'Uom  Sale',
        'LastSaleDate' => 'Last Sale Date',
        'LastSalePrice' => 'Last Sale Price',
            'Flag_Ana' => 'ใช้ระบบ Ana Number',
        'Class' => 'Class',
        'Source' => 'Source',
        'LeadTime' => 'Lead Time',
        'Account_Code' => 'Account  Code',
        'Balbf' => 'Balbf',
        'Balbf_Avg_Cost' => 'Balbf  Avg  Cost',
        'Balbf_Fifo_Cost' => 'Balbf  Fifo  Cost',
        'Order_Policy' => 'นโยบายการสั่งซื้อ',
        'Sales_Reserved' => 'Sales  Reserved',
        'Prodn_Reserved' => 'Prodn  Reserved',
        'Cost_Type' => 'ประเภทต้นทุน',
            'Iqc_Check' => 'ต้องการตรวจสอบคุณภาพ (Quality Assurance)',
            'Life_Check' => 'ควบคุมวันที่ผลิต/วันที่หมดอายุ',
            'RetestDate_Check' => 'ควบคุมวันที่ Retest',
        'Picture' => 'Picture',
        'CompanyCode' => 'รหัสบริษัท',
        'Shrink' => 'ขนาด Shrink',
        'ShrinkSize' => 'Shrink Size',
        'Item_Type' => 'Item  Type',
        'CSCode' => 'Cscode',
        'Lot_Size' => 'Lot Size',
        'Retest_Cycle' => 'Retest  Cycle',
        'Scrap_Qty' => 'Scrap  Qty',
        'LastPclDate' => 'Last Pcl Date',
        'QtyOnhand_OH' => 'Qty Onhand  Oh',
        'OHCode' => 'Ohcode',
        'UserName' => 'User Name',
        'LastUpdate' => 'Last Update',
        'Buffer' => 'Buffer',
        'LabelPrice' => 'Label Price',
        'Remark' => 'หมายเหตุ',
        'ShelfLife' => 'Shelf Life',
        'FormatDateCoding' => 'Format Date Coding',
        'Waste_Qty' => 'Waste  Qty',
        'Defective_Qty' => 'Defective  Qty',
        'Good_Qty' => 'Good  Qty',
        'CateCode' => 'Cate Code',
        'AvgSale_OH' => 'Avg Sale  Oh',
        'VariableCost' => 'Variable Cost',
        'FixedCost' => 'Fixed Cost',
        'ControlItemType' => 'ประเภทของสินค้าควบคุม',
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
        'Remark1_Coding' => 'Remark1  Coding',
        'Remark2_Coding' => 'Remark2  Coding',
        'Std_Fill_LeadTime' => 'ระยะเวลาในการบรรจุมาตฐาน',
//        'calOnhand' => 'จำนวนคงเหลือ',  ยกเลิกใช้
        'itemlocqty'=> 'จำนวนคงเหลือ (Itemloc)',

  
        
    ];   

 
    // for DepDrop 
    // AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
    public function depDropList_Brand($id,$id2,$id3) // for depdrop
    {        
        $rows =  \app\models\Product::find()->select('Brand as id,BrandDesc as name')        
            ->where(['Product' => $id,'Group_Product' => $id2,'Type_Invent_Code'=>$id3])
            ->asArray()->all(); 
        return $rows;         
    }     
    public function depDropList_Product($id,$id2) // for depdrop
    {        
        $rows =  \app\models\Product::find()->select('Product as id,Product_Desc as name')        
            ->where(['Group_Product' => $id,'Type_Invent_Code'=>$id2])
            ->asArray()->all(); 
        return $rows;         
    } 
    public function depDropList_GProduct($id) // for depdrop
    {        
        $rows =  \app\models\GProduct::find()->select('Group_Product as id,Group_Product_Desc as name')        
            ->where(['Type_Invent_Code' => $id])
            ->asArray()->all(); 
        return $rows;         
    }    
    public function depDropList_Location($id) // for depdrop
    {        
        $rows =  \app\models\Location::find()->select('Location_Code as id,Location_Code as name')        
            ->where(['WhCode' => $id])
            ->asArray()->all(); 
        return $rows;         
    }
    // BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
    public function getProduct()    
    {        
        return $this->hasOne(Product::className(), ['Type_Invent_Code' => 'Type_Invent_Code','Group_Product' => 'Group_Product','Product' => 'Product']);
    }    
    public function getGProduct()    
    {        
        return $this->hasOne(GProduct::className(), ['Type_Invent_Code' => 'Type_Invent_Code','Group_Product' => 'Group_Product']);
    }    

    public function getSupplier()
    {
        
        return $this->hasOne(Supplier::className(), ['Supp_Number' => 'Supp_Number']);
         
    }
    public function getItemlastpo()
    {
        
        return $this->hasOne(XItemlastpo::className(), ['item_number' => 'Item_Number']);
         
    }

    //   ยกเลิกกมารใช้ใน item/onhand 14/11/2018
    // public function getCalOnhand()    {        
    //     return $this->hasMany(Itemloc::className(), [
    //         'Item_Number' => 'Item_Number',            
    //     ])        
    //     ->andOnCondition(['status' => 'Y'])  
    //     ->sum('Ana_Qty');
    // }

    public function getItemloc()
    {
        return $this->hasMany(Itemloc::className(), ['Item_Number' => 'Item_Number'
            ,'WhCode' => 'WhCode'
            ,'Loc_Number' => 'Location_number']);

    }

    public function getItemlocqty()
    {
        return $this->hasMany(Itemloc::className(), ['Item_Number' => 'Item_Number'
            ,'WhCode' => 'WhCode'
            ,'Location_number' => 'Loc_Number'])->sum('Ana_Qty');
    }   
    // public function getQuotedetcount()
    // {
    //     return $this->hasMany(quotedet::className(), ['Item_Number' => 'Item_Number'])->count();
    // }  
 
    public function scenarios()
    {
        $scenarios = parent::scenarios();
 

        $scenarios['update']    = ['QtyOnhand','CompanyCode','NotActive','Uom','PackUom','Uom_Buy','Uom_Sale'];
        $scenarios['qcupdate']  = ['Std_Fill_LeadTime'];
        $scenarios['bdupdate']  = ['Industry_Code'];
        // echo '<pre>';
        // print_r($scenarios);

        
        return $scenarios;
        
    }    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%Item}}';
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
            [['Pack', 'Flag_Ana', 'LeadTime', 'Iqc_Check', 'Life_Check', 'RetestDate_Check', 'Shrink', 'ShrinkSize', 'Lot_Size', 'Retest_Cycle', 'ShelfLife', 'Std_Approve_Purchase_LeadTime', 'Std_Apprv_Production_LeadTime', 'Std_Purchase_LeadTime', 'Tag_Qty', 'Pallet_Row', 'Pallet_Layer', 'NotActive','Std_Fill_LeadTime'], 'integer'],
            [['PackSize', 'QtyOnhand', 'Price_A', 'Price_B', 'Price_C', 'Price_D', 'Minimum', 'Maximum', 'LastBuyPrice', 'LastSalePrice', 'Balbf', 'Balbf_Avg_Cost', 'Balbf_Fifo_Cost', 'Sales_Reserved', 'Prodn_Reserved', 'Scrap_Qty', 'QtyOnhand_OH', 'Buffer', 'LabelPrice', 'Waste_Qty', 'Defective_Qty', 'Good_Qty', 'AvgSale_OH', 'VariableCost', 'FixedCost', 'Pallet', 'StandardCost', 'WeightPerCorbox', 'AvgCost', 'Carton_Width', 'Carton_Hight', 'Carton_Depth', 'Box_Width', 'Box_Hight', 'Box_Depth', 'Box_Weight', 'Box_Weight_Qty', 'Keep_Temperature', 'CostOfAssay', 'QtyPerPackSize', 'WeightPerPackSize'], 'number'],
            [['LastBuyDate', 'LastSaleDate', 'LastPclDate', 'LastUpdate'], 'safe'],
            
    
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->labels; 
    }

    /**
     * @inheritdoc
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }



    
}



 



