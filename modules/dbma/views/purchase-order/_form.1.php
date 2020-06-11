<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CompanyCode')->textInput() ?>

    <?= $form->field($model, 'Order_Number')->textInput() ?>

    <?= $form->field($model, 'DeptCode')->textInput() ?>

    <?= $form->field($model, 'Supp_Number')->textInput() ?>

    <?= $form->field($model, 'Pr_Number')->textInput() ?>

    <?= $form->field($model, 'Shipto_Addr1')->textInput() ?>

    <?= $form->field($model, 'Shipto_Addr2')->textInput() ?>

    <?= $form->field($model, 'Currency_Type')->textInput() ?>

    <?= $form->field($model, 'Remark1')->textInput() ?>

    <?= $form->field($model, 'Remark2')->textInput() ?>

    <?= $form->field($model, 'Remark3')->textInput() ?>

    <?= $form->field($model, 'Remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'Order_date')->textInput() ?>

    <?= $form->field($model, 'Buyers')->textInput() ?>

    <?= $form->field($model, 'Terms')->textInput() ?>

    <?= $form->field($model, 'Po_Issue')->textInput() ?>

    <?= $form->field($model, 'Open_Close')->textInput() ?>

    <?= $form->field($model, 'Close_Date')->textInput() ?>

    <?= $form->field($model, 'Service')->textInput() ?>

    <?= $form->field($model, 'Insurance')->textInput() ?>

    <?= $form->field($model, 'Carriage')->textInput() ?>

    <?= $form->field($model, 'Vat_Percent')->textInput() ?>

    <?= $form->field($model, 'Vat_Amt')->textInput() ?>

    <?= $form->field($model, 'Disc_Percent')->textInput() ?>

    <?= $form->field($model, 'Disc_Cash')->textInput() ?>

    <?= $form->field($model, 'Revision_No')->textInput() ?>

    <?= $form->field($model, 'Revision_Date')->textInput() ?>

    <?= $form->field($model, 'Vat_Type')->textInput() ?>

    <?= $form->field($model, 'ForWork')->textInput() ?>

    <?= $form->field($model, 'DivisionCode')->textInput() ?>

    <?= $form->field($model, 'LimitOverOrderRate')->textInput() ?>

    <?= $form->field($model, 'currency_Rate')->textInput() ?>

    <?= $form->field($model, 'ShipMent')->textInput() ?>

    <?= $form->field($model, 'Amount')->textInput() ?>

    <?= $form->field($model, 'TotalAmount')->textInput() ?>

    <?= $form->field($model, 'UserName')->textInput() ?>

    <?= $form->field($model, 'LastUpdate')->textInput() ?>

    <?= $form->field($model, 'PO_Approve')->textInput() ?>

    <?= $form->field($model, 'UserName_Approve')->textInput() ?>

    <?= $form->field($model, 'DateTime_Approve')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
