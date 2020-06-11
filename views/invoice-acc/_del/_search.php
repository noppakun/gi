<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InvoiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CompanyCode') ?>

    <?= $form->field($model, 'Inv_Number') ?>

    <?= $form->field($model, 'Type_Inv_Code') ?>

    <?= $form->field($model, 'Sale_Number') ?>

    <?= $form->field($model, 'DivisionCode') ?>

    <?php // echo $form->field($model, 'DeptCode') ?>

    <?php // echo $form->field($model, 'Cust_No') ?>

    <?php // echo $form->field($model, 'Inv_Date') ?>

    <?php // echo $form->field($model, 'SalesmanCode') ?>

    <?php // echo $form->field($model, 'DeliveryCode') ?>

    <?php // echo $form->field($model, 'Terms') ?>

    <?php // echo $form->field($model, 'ShipTo_Addr1') ?>

    <?php // echo $form->field($model, 'ShipTo_Addr2') ?>

    <?php // echo $form->field($model, 'ShipTo_Addr3') ?>

    <?php // echo $form->field($model, 'ShipTo_Addr4') ?>

    <?php // echo $form->field($model, 'Remark1') ?>

    <?php // echo $form->field($model, 'Remark2') ?>

    <?php // echo $form->field($model, 'Remark3') ?>

    <?php // echo $form->field($model, 'Due_Date') ?>

    <?php // echo $form->field($model, 'Cust_PO_No') ?>

    <?php // echo $form->field($model, 'Cust_PO_Date') ?>

    <?php // echo $form->field($model, 'Disc_Cash') ?>

    <?php // echo $form->field($model, 'Disc_Percent') ?>

    <?php // echo $form->field($model, 'Disc_Special') ?>

    <?php // echo $form->field($model, 'Disc_Money') ?>

    <?php // echo $form->field($model, 'Desc_Disc_Other') ?>

    <?php // echo $form->field($model, 'Disc_Other') ?>

    <?php // echo $form->field($model, 'Inv_Issue') ?>

    <?php // echo $form->field($model, 'Open_Close') ?>

    <?php // echo $form->field($model, 'Vat_Percent') ?>

    <?php // echo $form->field($model, 'Vat_Amount') ?>

    <?php // echo $form->field($model, 'Adjust_Date') ?>

    <?php // echo $form->field($model, 'Adjust_Many') ?>

    <?php // echo $form->field($model, 'Currency_Type') ?>

    <?php // echo $form->field($model, 'Currency_Rate') ?>

    <?php // echo $form->field($model, 'Amount') ?>

    <?php // echo $form->field($model, 'TotalAmount') ?>

    <?php // echo $form->field($model, 'PaidAmount') ?>

    <?php // echo $form->field($model, 'Inv_Picture') ?>

    <?php // echo $form->field($model, 'UserName') ?>

    <?php // echo $form->field($model, 'LastUpdate') ?>

    <?php // echo $form->field($model, 'Vat_Type') ?>

    <?php // echo $form->field($model, 'BranchCode') ?>

    <?php // echo $form->field($model, 'delivery_date') ?>

    <?php // echo $form->field($model, 'TransportCode') ?>

    <?php // echo $form->field($model, 'Status_Prepare') ?>

    <?php // echo $form->field($model, 'PrintNo_Repair') ?>

    <?php // echo $form->field($model, 'Invs_Number') ?>

    <?php // echo $form->field($model, 'Service') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
