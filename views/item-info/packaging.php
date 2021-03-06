<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\GProduct;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

 

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Item_Number',
            //'WhCode',
            //'Loc_Number',
            'Item_Name',
            //'Uom',
            //'docyear_first',
            //'Type_Invent_Code',
//            'Group_Product',
            [
                'label'=>'กลุ่มสินค้า',
                'attribute' => 'gProduct.Group_Product_Desc',
            ],
            [
                'label'=>'ประเภทสินค้า',
                'attribute' => 'product.Product_Desc',
            ],

  //          'gProduct.Group_Product_Desc',
            //'Group_Product_Desc',
            // [
            //     //'label'=>'a',
            //     'attribute' => 'gProduct.Group_Product_Desc',
            //     'hAlign' => 'center',
            //     'width' => '70px',                                
            //     'filter' => '<input class="form-control" name="' . $Group_Product_Search . '" value="' . $Group_Product_Search . '" type="text">',
            //     //ArrayHelper::map(GProduct::find()->all(), 'Group_Product', 'Group_Product_Desc'),

            // ],            
            //'Product',
            //'product.Product_Desc',

            //'Brand',
            //'Type',
            //'SubType',
            //'Tariff_Code',
            //'Industry_Code',
            //'InsteadCode',
            //'Pack',
            //'PackSize',
            //'PackUom',
            //'QtyOnhand',
            //'Price',
            //'Price_A',
            //'Price_B',
            //'Price_C',
            //'Price_D',
            //'Minimum',
            //'Maximum',
            //'Supp_Number',
            //'Uom_Buy',
            //'LastBuyDate',
            //'LastBuyPrice',
            //'LastBuyCurrency_type',
            //'Uom_Sale',
            //'LastSaleDate',
            //'LastSalePrice',
            //'Flag_Ana',
            //'Class',
            //'Source',
            //'LeadTime:datetime',
            //'Account_Code',
            //'Balbf',
            //'Balbf_Avg_Cost',
            //'Balbf_Fifo_Cost',
            //'Order_Policy',
            //'Sales_Reserved',
            //'Prodn_Reserved',
            //'Cost_Type',
            //'Iqc_Check',
            //'Life_Check',
            //'RetestDate_Check',
            //'Picture',
            //'CompanyCode',
            //'Shrink',
            //'ShrinkSize',
            //'Item_Type',
            //'CSCode',
            //'Lot_Size',
            //'Retest_Cycle',
            //'Scrap_Qty',
            //'LastPclDate',
            //'QtyOnhand_OH',
            //'OHCode',
            //'UserName',
            //'LastUpdate',
            //'Buffer',
            //'LabelPrice',
            //'Remark',
            //'ShelfLife',
            //'FormatDateCoding',
            //'Waste_Qty',
            //'Defective_Qty',
            //'Good_Qty',
            //'CateCode',
            //'AvgSale_OH',
            //'VariableCost',
            //'FixedCost',
            //'ControlItemType',
            //'Std_Approve_Purchase_LeadTime:datetime',
            //'Std_Apprv_Production_LeadTime:datetime',
            //'Std_Purchase_LeadTime:datetime',
            //'Tag_Qty',
            //'Pallet',
            //'StandardCost',
            //'Sale_Category_Code',
            //'WeightPerCorbox',
            //'Account_Code_Credit',
            //'AvgCost',
            //'StorageConditionCode',
            //'Cust_No',
            //'Barcode',
            //'Carton_Width',
            //'Carton_Hight',
            //'Carton_Depth',
            //'Box_Width',
            //'Box_Hight',
            //'Box_Depth',
            //'Box_Weight',
            //'Box_Weight_Qty',
            //'Keep_Temperature',
            //'Pallet_Row',
            //'Pallet_Layer',
            //'NotActive',
            //'CostOfAssay',
            //'QtyPerPackSize',
            //'WeightPerPackSize',
            //'Remark1_Coding',
            //'Remark2_Coding',
            //'Std_Fill_LeadTime:datetime',
            //'GroupCode',
            //'ITypeCode',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
