<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$this->title = $model->CompanyCode;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="invoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'CompanyCode' => $model->CompanyCode, 'Inv_Number' => $model->Inv_Number], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'CompanyCode' => $model->CompanyCode, 'Inv_Number' => $model->Inv_Number], [
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
            'CompanyCode',
            'Inv_Number',
            'Type_Inv_Code',
            'Sale_Number',
            'DivisionCode',
            'DeptCode',
            'Cust_No',
            'Inv_Date',
            'SalesmanCode',
            'DeliveryCode',
            'Terms',
            'ShipTo_Addr1',
            'ShipTo_Addr2',
            'ShipTo_Addr3',
            'ShipTo_Addr4',
            'Remark1',
            'Remark2',
            'Remark3',
            'Due_Date',
            'Cust_PO_No',
            'Cust_PO_Date',
            'Disc_Cash',
            'Disc_Percent',
            'Disc_Special',
            'Disc_Money',
            'Desc_Disc_Other',
            'Disc_Other',
            'Inv_Issue',
            'Open_Close',
            'Vat_Percent',
            'Vat_Amount',
            'Adjust_Date',
            'Adjust_Many',
            'Currency_Type',
            'Currency_Rate',
            'Amount',
            'TotalAmount',
            'PaidAmount',
            'Inv_Picture',
            'UserName',
            'LastUpdate',
            'Vat_Type',
            'BranchCode',
            'delivery_date',
            'TransportCode',
            'Status_Prepare',
            'PrintNo_Repair',
            'Invs_Number',
            'Service',
        ],
    ]) ?>

</div>
