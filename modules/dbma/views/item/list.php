<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use app\models\XItemlastpo;

$this->title = 'Items List';
$this->params['breadcrumbs'][] = $this->title;
 
function filterInput($name,$filtersForm){
    return '<input class="form-control" name="filtersForm['.$name.']" value="'. $filtersForm[$name] .'" type="text">';
}
?>

<div class="item-list">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('CompanyCode is null Item', ['index','sort'=>'CompanyCode'], ['class' => 'btn btn-warning']) ?>
    </p> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filtersForm,  
        
              
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'CompanyCode',
            [
                'attribute'=>'Item_Number',
                'filter'=>filterinput('Item_Number',$filtersForm),
                
            ],
			
            //'WhCode',
            //'Loc_Number',
            [
                'attribute'=>'Item_Name',
                'filter'=>filterinput('Item_Name',$filtersForm),
            ],  
            
            //'Uom',

            [
                'attribute'=>'order_number',
                'label'=>'ใบสั่งซื้อ ล่าสุด',
                'contentOptions' => [ 'class' => 'bg-warning'],
                'filter'=>filterinput('order_number',$filtersForm),
            ],
 
            [
                'attribute'=>'order_date',
                'label'=>'วันที่',
                'format'=>'date',
                'contentOptions' => [ 'class' => 'bg-warning'],
             
            ],
            [
                'attribute'=>'price',
                'label'=>'ราคา',
                'format'=>['decimal',2],
                'hAlign' => 'right',  
                'contentOptions' => [ 'class' => 'bg-warning'],
             
            ],
            [
                'attribute'=>'order_qty',
                'header'=>'จำนวนสั่งซื้อ<br>ล่าสุด',
                'format'=>['decimal',2],
                'hAlign' => 'right',                  
                'contentOptions' => [ 'class' => 'bg-warning'],             
            ],
            [
                'attribute'=>'rlse_qty',
                'header'=>'จำนวนรับ',
                'format'=>['decimal',2],
                'hAlign' => 'right',                  
                'contentOptions' => [ 'class' => 'bg-warning'],             
            ],

            [
                'attribute'=>'LeadTime',            
                'header'=>'Lead Time<br>( วัน )',    
                'format'=>['decimal',2],
                'hAlign' => 'right',  
                'contentOptions' => [ 'class' => 'bg-warning'],
             
            ],            
            [
                'attribute'=>'QtyOnhand',                
                'label'=>'จำนวนคงเหลือ',
                'format'=>['decimal',2],
                'hAlign' => 'right',  
                'contentOptions' => [ 'class' => 'bg-warning'],
             
            ],
            
            

            
            // 'itemlastpo.order_number',
            // 'itemlastpo.order_date:date',
            // 'itemlastpo.price',
            // 'itemlastpo.order_qty',            
            // [
            //     'value'=>function($model){
            //         $m=XItemlastpo::find('item_number='.$model->Item_Number);
            //         return $m.order_number;
            //     }
            // ]
 
            
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
             //'QtyOnhand',
             //'itemlocqty',
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
            // 'Remark1_Coding',
            // 'Remark2_Coding',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
