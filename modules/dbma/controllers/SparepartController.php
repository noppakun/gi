<?php
 
namespace app\modules\dbma\controllers;
use Yii;


 
 
class SparepartController extends \app\components\XQEdit\XQEditController

{
    

    protected $MAIN_MODEL 	=   'app\models\Sparepart';    
     

    public function init()  
    {
        parent::init();
        
        
        $this->VIEWPARA['TABLECAPTION'] =  'Spare Parts';
        $this->VIEWPARA['XQEDIT']['exportconfig_pdf_orientation']='P'; // XQEditinit   L ,P      
        $this->VIEWPARA['XQEDIT']['exportconfig_pdf_footer']=['FM-068'];  
        $this->VIEWPARA['XQEDIT']['index_actioncolumn_template'] =null; 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [
            [
                'attribute'=>'Item_Number',
                'width'=>'120px',    
            ],           
            'Item_Name',
           // 'Uom',
            [
                'attribute'=>'Uom',
                'width'=>'90px',    
            ],    
            [
                //'attribute'=>'Remark1_Coding',
                // 'value'=>'(Remark1_Coding == null)?"a","    b"',
                'label'=>'เครื่องจักรที่ใช้',

                'attribute'=>'machineText',
                'width'=>'200px',    

                // 'value'=>function($data,$row){                                 
                //     return $data->machineText;
                // },
     
            ],               
            /*
            [
                'attribute'=>'Remark1_Coding',
               // 'value'=>'(Remark1_Coding == null)?"a","    b"',
                'value'=>function($data,$row){             
                    return ($data->Remark1_Coding == null)?'':$data->Remark1_Coding;
                },
     
            ],
            */               
           
            // 'Type_Invent_Code',
            // 'Group_Product',
            // 'Product',
            // 'Brand',
            // 'Type',
            // 'SubType',
            // 'Tariff_Code',
            // 'Industry_Code',
            // 'InsteadCode',
            // 'Pack',
            // 'PackSize',
            // 'PackUom',
            // 'QtyOnhand',
            // 'Price',
            // 'Price_A',
            // 'Price_B',
            // 'Price_C',
            // 'Price_D',
            // 'Minimum',
            // 'Maximum',
            // 'Supp_Number',
            // 'Uom_Buy',
            // 'LastBuyDate',
            // 'LastBuyPrice',
            // 'LastBuyCurrency_type',
            // 'Uom_Sale',
            // 'LastSaleDate',
            // 'LastSalePrice',
            // 'Flag_Ana',
            // 'Class',
            // 'Source',
            // 'LeadTime:datetime',
            // 'Account_Code',
            // 'Balbf',
            // 'Balbf_Avg_Cost',
            // 'Balbf_Fifo_Cost',
            // 'Order_Policy',
            // 'Sales_Reserved',
            // 'Prodn_Reserved',
            // 'Cost_Type',
            // 'Iqc_Check',
            // 'Life_Check',
            // 'RetestDate_Check',
            // 'Picture',
            // 'CompanyCode',
            // 'Shrink',
            // 'ShrinkSize',
            // 'Item_Type',
            // 'CSCode',
            // 'Lot_Size',
            // 'Retest_Cycle',
            // 'Scrap_Qty',
            // 'LastPclDate',
            // 'QtyOnhand_OH',
            // 'OHCode',
            // 'UserName',
            // 'LastUpdate',
            // 'Buffer',
            // 'LabelPrice',
            //'Remark',
            // 'ShelfLife',
            // 'FormatDateCoding',
            // 'Waste_Qty',
            // 'Defective_Qty',
            // 'Good_Qty',
            // 'CateCode',
            // 'AvgSale_OH',
            // 'VariableCost',
            // 'FixedCost',
            // 'ControlItemType',
            // 'Std_Approve_Purchase_LeadTime:datetime',
            // 'Std_Apprv_Production_LeadTime:datetime',
            // 'Std_Purchase_LeadTime:datetime',
            // 'Tag_Qty',
            // 'Pallet',
            // 'StandardCost',
            // 'Sale_Category_Code',
            // 'WeightPerCorbox',
            // 'Account_Code_Credit',
            // 'AvgCost',
            // 'StorageConditionCode',
            // 'Cust_No',
            // 'Barcode',
            // 'Carton_Width',
            // 'Carton_Hight',
            // 'Carton_Depth',
            // 'Box_Width',
            // 'Box_Hight',
            // 'Box_Depth',
            // 'Box_Weight',
            // 'Box_Weight_Qty',
            // 'Keep_Temperature',
            // 'Pallet_Row',
            // 'Pallet_Layer',
            // 'NotActive',
            // 'CostOfAssay',
            // 'QtyPerPackSize',
            // 'WeightPerPackSize',
   
            // 'Remark2_Coding',

           // ['class' => 'yii\grid\ActionColumn'],
        ];
    }     

}
