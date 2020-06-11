<?php

use kartik\grid\GridView;
use kartik\form\ActiveForm;
use app\widgets\ddlMonth;
use app\widgets\ddlYear;
use yii\helpers\Html;

$this->title = 'Packaging รับเข้าใหม่';

//$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => [$this->context->action->id]];
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'type' => 'horizontal',
    'options' => [
        'class' => 'well',
    ],
]);
?>

<div class="row">
    <div class="col-md-4">
        <?= ddlYear::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'year']);   ?>
    </div>
    <div class="col-md-5">
        <?= ddlMonth::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'month']);    ?>
    </div>
    <div class="col-md-3">
        <?= Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>
    </div>
</div>

<?php
$form::end();
?>

<div class="etable-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'responsiveWrap' => false,
        'columns' => [
            [                
                'attribute' => 'Item_Number',
                'group' => true,
            ],
            [                
                'attribute' => 'Item_Name',
                'group' => true,
                'subGroupOf' => 0,
            ],
            [
                'label'=>'จำนวนรับ',
                'attribute' => 'Recv_Qty',
                'format' => ['decimal', 2], 'hAlign' => 'right',
            ],          
            [
                'label'=>'เลขที่ใบรับ',
                'attribute' => 'VoucherNo',
            ],                                  
            [
                'label'=>'วันที่รับ',
                'attribute' => 'DocDate',
                'format' => 'date',
            ],                                  
            [                
                'attribute' => 'Ana_No',
            ],                                  

  

        ]
    ]);
    ?>
</div>
<div class="col-md-6">
    * ตรวจสอบจาก รับเข้าจากการซื้อ, รับเข้าจากผู้จ้างผลิต
</div>