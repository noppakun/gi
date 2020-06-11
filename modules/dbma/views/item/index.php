<?php

use yii\helpers\Html;
use app\components\gihelper;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $TABLECAPTION;
$this->params['breadcrumbs'][] = $this->title;

    
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        

        'Item_Number',
        'Item_Name',
        'WhCode',
 
        
        [
            'attribute'=>'Loc_Number',
            'label'=>'สถานที่<br>เก็บสินค้า',
            'encodeLabel' => false,            
        ],
        [
            'attribute'=>'Uom',
            'label'=>'หน่วยนับ<br>(Uom)',
            'encodeLabel' => false,            
        ],
        
        'Type_Invent_Code',

        // 'Flag_Ana' ,
        // 'Iqc_Check',
        // 'Life_Check',
        // 'RetestDate_Check',
        
        [
            'attribute'=>'Industry_Code',
            'label'=>'รหัสโรงงาน /<br> รหัสลูกค้า',
            'encodeLabel' => false,            
        ],
 

        [
            'attribute'=>'Pack',
            'hAlign' => 'right',
        ],        
        [
            'attribute'=>'PackSize',
            'hAlign' => 'right',
        ],        
        

        'PackUom',        
        [
            'attribute'=>'QtyOnhand',
            'format' => ['decimal',4],
            'hAlign' => 'right',
              
        ],        
        'Minimum',

        
        'Retest_Cycle',        
        //'CompanyCode',
        // 'InsteadCode',

        // 'Group_Product',
        // 'Product',
        // 'Brand',
        // 'Type',
        // 'SubType',

        // 'Tariff_Code',        
        // 'itemlocqty',
        // 'Price',
        // 'Price_A',
        // 'Price_B',
        // 'Price_C',
        // 'Price_D',
              
        // 'Maximum',
        // 'Supp_Number',
        // 'Uom_Buy',
        // 'LastBuyDate',
        // 'LastBuyPrice',
        // 'LastBuyCurrency_type',
        // 'Uom_Sale',
        // 'LastSaleDate',
        // 'LastSalePrice',
        
        // 'Class',
        //'Source',
        // 'LeadTime:datetime',
        // 'Account_Code',
        // 'Balbf',
        // 'Balbf_Avg_Cost',
        // 'Balbf_Fifo_Cost',
        // 'Order_Policy',
        // 'Sales_Reserved',
        // 'Prodn_Reserved',
        // 'Cost_Type',
     
      
        
        // 'Picture',
        // 'CompanyCode',
        // 'Shrink',
        // 'ShrinkSize',
        // 'Item_Type',
        // 'CSCode',
        // 'Lot_Size',


        // 'Scrap_Qty',
        // 'LastPclDate',
        // 'QtyOnhand_OH',
        // 'OHCode',
        // 'UserName',
        // 'LastUpdate',
        // 'Buffer',
        // 'LabelPrice',
        // 'Remark',
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
        //'Cust_No',
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
        // 'Remark1_Coding',
        // 'Remark2_Coding',

        [
            'class' => 'kartik\grid\ActionColumn',
            'template'=>'{view}{update}{delete}',
            'header' => Html::a(
                '<i class="glyphicon glyphicon-plus"></i>',
                [Yii::$app->controller->id.'/create'],
                ['title'=>'เพิ่ม']
            )          
        ],
    ];
 
?>





<div class="etable-index">
 
 <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'responsiveWrap' => false,
    'columns' => $columns,
 ]); 
 ?>

</div>










