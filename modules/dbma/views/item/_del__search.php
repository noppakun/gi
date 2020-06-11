<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Item_Number') ?>

    <?= $form->field($model, 'WhCode') ?>

    <?= $form->field($model, 'Loc_Number') ?>

    <?= $form->field($model, 'Item_Name') ?>

    <?= $form->field($model, 'Uom') ?>

    <?php // echo $form->field($model, 'Type_Invent_Code') ?>

    <?php // echo $form->field($model, 'Group_Product') ?>

    <?php // echo $form->field($model, 'Product') ?>

    <?php // echo $form->field($model, 'Brand') ?>

    <?php // echo $form->field($model, 'Type') ?>

    <?php // echo $form->field($model, 'SubType') ?>

    <?php // echo $form->field($model, 'Tariff_Code') ?>

    <?php // echo $form->field($model, 'Industry_Code') ?>

    <?php // echo $form->field($model, 'InsteadCode') ?>

    <?php // echo $form->field($model, 'Pack') ?>

    <?php // echo $form->field($model, 'PackSize') ?>

    <?php // echo $form->field($model, 'PackUom') ?>

    <?php // echo $form->field($model, 'QtyOnhand') ?>

    <?php // echo $form->field($model, 'Price') ?>

    <?php // echo $form->field($model, 'Price_A') ?>

    <?php // echo $form->field($model, 'Price_B') ?>

    <?php // echo $form->field($model, 'Price_C') ?>

    <?php // echo $form->field($model, 'Price_D') ?>

    <?php // echo $form->field($model, 'Minimum') ?>

    <?php // echo $form->field($model, 'Maximum') ?>

    <?php // echo $form->field($model, 'Supp_Number') ?>

    <?php // echo $form->field($model, 'Uom_Buy') ?>

    <?php // echo $form->field($model, 'LastBuyDate') ?>

    <?php // echo $form->field($model, 'LastBuyPrice') ?>

    <?php // echo $form->field($model, 'LastBuyCurrency_type') ?>

    <?php // echo $form->field($model, 'Uom_Sale') ?>

    <?php // echo $form->field($model, 'LastSaleDate') ?>

    <?php // echo $form->field($model, 'LastSalePrice') ?>

    <?php // echo $form->field($model, 'Flag_Ana') ?>

    <?php // echo $form->field($model, 'Class') ?>

    <?php // echo $form->field($model, 'Source') ?>

    <?php // echo $form->field($model, 'LeadTime') ?>

    <?php // echo $form->field($model, 'Account_Code') ?>

    <?php // echo $form->field($model, 'Balbf') ?>

    <?php // echo $form->field($model, 'Balbf_Avg_Cost') ?>

    <?php // echo $form->field($model, 'Balbf_Fifo_Cost') ?>

    <?php // echo $form->field($model, 'Order_Policy') ?>

    <?php // echo $form->field($model, 'Sales_Reserved') ?>

    <?php // echo $form->field($model, 'Prodn_Reserved') ?>

    <?php // echo $form->field($model, 'Cost_Type') ?>

    <?php // echo $form->field($model, 'Iqc_Check') ?>

    <?php // echo $form->field($model, 'Life_Check') ?>

    <?php // echo $form->field($model, 'RetestDate_Check') ?>

    <?php // echo $form->field($model, 'Picture') ?>

    <?php // echo $form->field($model, 'CompanyCode') ?>

    <?php // echo $form->field($model, 'Shrink') ?>

    <?php // echo $form->field($model, 'ShrinkSize') ?>

    <?php // echo $form->field($model, 'Item_Type') ?>

    <?php // echo $form->field($model, 'CSCode') ?>

    <?php // echo $form->field($model, 'Lot_Size') ?>

    <?php // echo $form->field($model, 'Retest_Cycle') ?>

    <?php // echo $form->field($model, 'Scrap_Qty') ?>

    <?php // echo $form->field($model, 'LastPclDate') ?>

    <?php // echo $form->field($model, 'QtyOnhand_OH') ?>

    <?php // echo $form->field($model, 'OHCode') ?>

    <?php // echo $form->field($model, 'UserName') ?>

    <?php // echo $form->field($model, 'LastUpdate') ?>

    <?php // echo $form->field($model, 'Buffer') ?>

    <?php // echo $form->field($model, 'LabelPrice') ?>

    <?php // echo $form->field($model, 'Remark') ?>

    <?php // echo $form->field($model, 'ShelfLife') ?>

    <?php // echo $form->field($model, 'FormatDateCoding') ?>

    <?php // echo $form->field($model, 'Waste_Qty') ?>

    <?php // echo $form->field($model, 'Defective_Qty') ?>

    <?php // echo $form->field($model, 'Good_Qty') ?>

    <?php // echo $form->field($model, 'CateCode') ?>

    <?php // echo $form->field($model, 'AvgSale_OH') ?>

    <?php // echo $form->field($model, 'VariableCost') ?>

    <?php // echo $form->field($model, 'FixedCost') ?>

    <?php // echo $form->field($model, 'ControlItemType') ?>

    <?php // echo $form->field($model, 'Std_Approve_Purchase_LeadTime') ?>

    <?php // echo $form->field($model, 'Std_Apprv_Production_LeadTime') ?>

    <?php // echo $form->field($model, 'Std_Purchase_LeadTime') ?>

    <?php // echo $form->field($model, 'Tag_Qty') ?>

    <?php // echo $form->field($model, 'Pallet') ?>

    <?php // echo $form->field($model, 'StandardCost') ?>

    <?php // echo $form->field($model, 'Sale_Category_Code') ?>

    <?php // echo $form->field($model, 'WeightPerCorbox') ?>

    <?php // echo $form->field($model, 'Account_Code_Credit') ?>

    <?php // echo $form->field($model, 'AvgCost') ?>

    <?php // echo $form->field($model, 'StorageConditionCode') ?>

    <?php // echo $form->field($model, 'Cust_No') ?>

    <?php // echo $form->field($model, 'Barcode') ?>

    <?php // echo $form->field($model, 'Carton_Width') ?>

    <?php // echo $form->field($model, 'Carton_Hight') ?>

    <?php // echo $form->field($model, 'Carton_Depth') ?>

    <?php // echo $form->field($model, 'Box_Width') ?>

    <?php // echo $form->field($model, 'Box_Hight') ?>

    <?php // echo $form->field($model, 'Box_Depth') ?>

    <?php // echo $form->field($model, 'Box_Weight') ?>

    <?php // echo $form->field($model, 'Box_Weight_Qty') ?>

    <?php // echo $form->field($model, 'Keep_Temperature') ?>

    <?php // echo $form->field($model, 'Pallet_Row') ?>

    <?php // echo $form->field($model, 'Pallet_Layer') ?>

    <?php // echo $form->field($model, 'NotActive') ?>

    <?php // echo $form->field($model, 'CostOfAssay') ?>

    <?php // echo $form->field($model, 'QtyPerPackSize') ?>

    <?php // echo $form->field($model, 'WeightPerPackSize') ?>

    <?php // echo $form->field($model, 'Remark1_Coding') ?>

    <?php // echo $form->field($model, 'Remark2_Coding') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
