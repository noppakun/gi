<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Item_Number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'WhCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Loc_Number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Item_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Uom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Type_Invent_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Group_Product')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Product')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Brand')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SubType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Tariff_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Industry_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'InsteadCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Pack')->textInput() ?>

    <?= $form->field($model, 'PackSize')->textInput() ?>

    <?= $form->field($model, 'PackUom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QtyOnhand')->textInput() ?>

    <?= $form->field($model, 'Price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_A')->textInput() ?>

    <?= $form->field($model, 'Price_B')->textInput() ?>

    <?= $form->field($model, 'Price_C')->textInput() ?>

    <?= $form->field($model, 'Price_D')->textInput() ?>

    <?= $form->field($model, 'Minimum')->textInput() ?>

    <?= $form->field($model, 'Maximum')->textInput() ?>

    <?= $form->field($model, 'Supp_Number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Uom_Buy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastBuyDate')->textInput() ?>

    <?= $form->field($model, 'LastBuyPrice')->textInput() ?>

    <?= $form->field($model, 'LastBuyCurrency_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Uom_Sale')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastSaleDate')->textInput() ?>

    <?= $form->field($model, 'LastSalePrice')->textInput() ?>

    <?= $form->field($model, 'Flag_Ana')->textInput() ?>

    <?= $form->field($model, 'Class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LeadTime')->textInput() ?>

    <?= $form->field($model, 'Account_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Balbf')->textInput() ?>

    <?= $form->field($model, 'Balbf_Avg_Cost')->textInput() ?>

    <?= $form->field($model, 'Balbf_Fifo_Cost')->textInput() ?>

    <?= $form->field($model, 'Order_Policy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Sales_Reserved')->textInput() ?>

    <?= $form->field($model, 'Prodn_Reserved')->textInput() ?>

    <?= $form->field($model, 'Cost_Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Iqc_Check')->textInput() ?>

    <?= $form->field($model, 'Life_Check')->textInput() ?>

    <?= $form->field($model, 'RetestDate_Check')->textInput() ?>

    <?= $form->field($model, 'Picture')->textInput() ?>

    <?= $form->field($model, 'CompanyCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Shrink')->textInput() ?>

    <?= $form->field($model, 'ShrinkSize')->textInput() ?>

    <?= $form->field($model, 'Item_Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CSCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Lot_Size')->textInput() ?>

    <?= $form->field($model, 'Retest_Cycle')->textInput() ?>

    <?= $form->field($model, 'Scrap_Qty')->textInput() ?>

    <?= $form->field($model, 'LastPclDate')->textInput() ?>

    <?= $form->field($model, 'QtyOnhand_OH')->textInput() ?>

    <?= $form->field($model, 'OHCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UserName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastUpdate')->textInput() ?>

    <?= $form->field($model, 'Buffer')->textInput() ?>

    <?= $form->field($model, 'LabelPrice')->textInput() ?>

    <?= $form->field($model, 'Remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ShelfLife')->textInput() ?>

    <?= $form->field($model, 'FormatDateCoding')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Waste_Qty')->textInput() ?>

    <?= $form->field($model, 'Defective_Qty')->textInput() ?>

    <?= $form->field($model, 'Good_Qty')->textInput() ?>

    <?= $form->field($model, 'CateCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AvgSale_OH')->textInput() ?>

    <?= $form->field($model, 'VariableCost')->textInput() ?>

    <?= $form->field($model, 'FixedCost')->textInput() ?>

    <?= $form->field($model, 'ControlItemType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Std_Approve_Purchase_LeadTime')->textInput() ?>

    <?= $form->field($model, 'Std_Apprv_Production_LeadTime')->textInput() ?>

    <?= $form->field($model, 'Std_Purchase_LeadTime')->textInput() ?>

    <?= $form->field($model, 'Tag_Qty')->textInput() ?>

    <?= $form->field($model, 'Pallet')->textInput() ?>

    <?= $form->field($model, 'StandardCost')->textInput() ?>

    <?= $form->field($model, 'Sale_Category_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'WeightPerCorbox')->textInput() ?>

    <?= $form->field($model, 'Account_Code_Credit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AvgCost')->textInput() ?>

    <?= $form->field($model, 'StorageConditionCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Cust_No')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Barcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Carton_Width')->textInput() ?>

    <?= $form->field($model, 'Carton_Hight')->textInput() ?>

    <?= $form->field($model, 'Carton_Depth')->textInput() ?>

    <?= $form->field($model, 'Box_Width')->textInput() ?>

    <?= $form->field($model, 'Box_Hight')->textInput() ?>

    <?= $form->field($model, 'Box_Depth')->textInput() ?>

    <?= $form->field($model, 'Box_Weight')->textInput() ?>

    <?= $form->field($model, 'Box_Weight_Qty')->textInput() ?>

    <?= $form->field($model, 'Keep_Temperature')->textInput() ?>

    <?= $form->field($model, 'Pallet_Row')->textInput() ?>

    <?= $form->field($model, 'Pallet_Layer')->textInput() ?>

    <?= $form->field($model, 'NotActive')->textInput() ?>

    <?= $form->field($model, 'CostOfAssay')->textInput() ?>

    <?= $form->field($model, 'QtyPerPackSize')->textInput() ?>

    <?= $form->field($model, 'WeightPerPackSize')->textInput() ?>

    <?= $form->field($model, 'Remark1_Coding')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Remark2_Coding')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Std_Fill_LeadTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
