<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sparepart */

$this->title = $model->Item_Number;
$this->params['breadcrumbs'][] = ['label' => 'Spareparts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sparepart-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Item_Number], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Item_Number], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Item_Number',
            'WhCode',
            'Loc_Number',
            'Item_Name',
            'Uom',
            'Type_Invent_Code',
            'Group_Product',
            'Product',
            'Brand',
            'Type',
            'SubType',
            'Tariff_Code',
            'Industry_Code',
            'InsteadCode',
            'Pack',
            'PackSize',
            'PackUom',
            'QtyOnhand',
            'Price',
            'Price_A',
            'Price_B',
            'Price_C',
            'Price_D',
            'Minimum',
            'Maximum',
            'Supp_Number',
            'Uom_Buy',
            'LastBuyDate',
            'LastBuyPrice',
            'LastBuyCurrency_type',
            'Uom_Sale',
            'LastSaleDate',
            'LastSalePrice',
            'Flag_Ana',
            'Class',
            'Source',
            'LeadTime:datetime',
            'Account_Code',
            'Balbf',
            'Balbf_Avg_Cost',
            'Balbf_Fifo_Cost',
            'Order_Policy',
            'Sales_Reserved',
            'Prodn_Reserved',
            'Cost_Type',
            'Iqc_Check',
            'Life_Check',
            'RetestDate_Check',
            'Picture',
            'CompanyCode',
            'Shrink',
            'ShrinkSize',
            'Item_Type',
            'CSCode',
            'Lot_Size',
            'Retest_Cycle',
            'Scrap_Qty',
            'LastPclDate',
            'QtyOnhand_OH',
            'OHCode',
            'UserName',
            'LastUpdate',
            'Buffer',
            'LabelPrice',
            'Remark',
            'ShelfLife',
            'FormatDateCoding',
            'Waste_Qty',
            'Defective_Qty',
            'Good_Qty',
            'CateCode',
            'AvgSale_OH',
            'VariableCost',
            'FixedCost',
            'ControlItemType',
            'Std_Approve_Purchase_LeadTime:datetime',
            'Std_Apprv_Production_LeadTime:datetime',
            'Std_Purchase_LeadTime:datetime',
            'Tag_Qty',
            'Pallet',
            'StandardCost',
            'Sale_Category_Code',
            'WeightPerCorbox',
            'Account_Code_Credit',
            'AvgCost',
            'StorageConditionCode',
            'Cust_No',
            'Barcode',
            'Carton_Width',
            'Carton_Hight',
            'Carton_Depth',
            'Box_Width',
            'Box_Hight',
            'Box_Depth',
            'Box_Weight',
            'Box_Weight_Qty',
            'Keep_Temperature',
            'Pallet_Row',
            'Pallet_Layer',
            'NotActive',
            'CostOfAssay',
            'QtyPerPackSize',
            'WeightPerPackSize',
            'Remark1_Coding',
            'Remark2_Coding',
        ],
    ]) ?>

</div>
