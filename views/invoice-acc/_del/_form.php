<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CompanyCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Inv_Number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Type_Inv_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Sale_Number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DivisionCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DeptCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Cust_No')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Inv_Date')->textInput() ?>

    <?= $form->field($model, 'SalesmanCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DeliveryCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Terms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ShipTo_Addr1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ShipTo_Addr2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ShipTo_Addr3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ShipTo_Addr4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Remark1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Remark2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Remark3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Due_Date')->textInput() ?>

    <?= $form->field($model, 'Cust_PO_No')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Cust_PO_Date')->textInput() ?>

    <?= $form->field($model, 'Disc_Cash')->textInput() ?>

    <?= $form->field($model, 'Disc_Percent')->textInput() ?>

    <?= $form->field($model, 'Disc_Special')->textInput() ?>

    <?= $form->field($model, 'Disc_Money')->textInput() ?>

    <?= $form->field($model, 'Desc_Disc_Other')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Disc_Other')->textInput() ?>

    <?= $form->field($model, 'Inv_Issue')->textInput() ?>

    <?= $form->field($model, 'Open_Close')->textInput() ?>

    <?= $form->field($model, 'Vat_Percent')->textInput() ?>

    <?= $form->field($model, 'Vat_Amount')->textInput() ?>

    <?= $form->field($model, 'Adjust_Date')->textInput() ?>

    <?= $form->field($model, 'Adjust_Many')->textInput() ?>

    <?= $form->field($model, 'Currency_Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Currency_Rate')->textInput() ?>

    <?= $form->field($model, 'Amount')->textInput() ?>

    <?= $form->field($model, 'TotalAmount')->textInput() ?>

    <?= $form->field($model, 'PaidAmount')->textInput() ?>

    <?= $form->field($model, 'Inv_Picture')->textInput() ?>

    <?= $form->field($model, 'UserName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastUpdate')->textInput() ?>

    <?= $form->field($model, 'Vat_Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BranchCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
