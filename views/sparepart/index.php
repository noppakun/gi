<?php

use yii\helpers\Html;
use app\components\gihelper;
 
use kartik\grid\GridView;
use kartik\mpdf\Pdf;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SparepartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Spare Parts' ;
$this->params['breadcrumbs'][] = $this->title;
$gridViewPDF = [
    'mime' => 'application/pdf',     
    'config' => [        
        'cssInline' => file_get_contents(\Yii::getAlias('@app').'/web/css/kv-mpdf.css'),        
        'format' => 'A4',
        'orientation'=>'P',
        'destination' => 'I',
        'marginTop' => 22,      
        'methods' => [
            'SetHeader' => ['<h5>'.gihelper::comp_name().'</h5>'.
            '<br>Sparepart Report'.                
            '||Page : {PAGENO}/{nbpg}<br><br>Date : ' . date("d-m-Y")],  
            'SetFooter' => ['FM-068'],   
                             
        ],
    ],
];  
?>
<div class="sparepart-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
 
<!--
    <p>
       
        <?= Html::a('Report', ['report'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([

       'panel'=>[
            'before'=>''
        ],


        'export'=>[
            'target' => GridView::TARGET_BLANK,
        ],
        
        'exportConfig'=>[
            GridView::PDF => $gridViewPDF,
            
            // GridView::CSV => [],
            // GridView::EXCEL =>[],
            
        ],          

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns' => [
            [
                'class'=>'kartik\grid\SerialColumn',
                'width'=>'100px',  
                'headerOptions' => ['align'=>'center'],
                'contentOptions' => ['align'=>'center'],
                
            ],


            [
                'attribute'=>'Item_Number',
                'width'=>'120px',    
            ],           
            'Item_Name',
           // 'Uom',
            [
                'attribute'=>'Uom',
                'width'=>'100px',    
            ],    
            [
                //'attribute'=>'Remark1_Coding',
                // 'value'=>'(Remark1_Coding == null)?"a","    b"',
                'label'=>'เครื่องจักรที่ใช้',

                'attribute'=>'machineText',

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
        ],
    ]); ?>

</div>
