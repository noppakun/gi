<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice Due Date [by account]';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">




    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,


        'columns' => [


            [
                'attribute' => 'CompanyCode',
                'contentOptions' => ['width' => 80],
            ],
            [
                'attribute' => 'Inv_Number',
                'contentOptions' => ['width' => 120],
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(
                        $model->Inv_Number,
                        [
                            Yii::$app->controller->id . '/duedateacc',
                            'CompanyCode' => $model->CompanyCode, 'Inv_Number' => $model->Inv_Number
                        ]

                    );
                }

            ],

            [
                'attribute' => 'Inv_Date',
                'format' => 'date',
                'contentOptions' => ['width' => 100],
            ],
            [
                'attribute' => 'Due_Date',
                'format' => 'date',
                'contentOptions' => ['width' => 120],
            ],
            
            [
                'attribute' => 'due_date_acc',
                'value'=> 'xInvoiceExt.due_date_acc',
                'label'=>'วันที่ครบกำหนด (ยังไม่ได้วางบิล)',
                'format' => 'date',
                'contentOptions' => ['width' => 120],

            ],            

            [
                'attribute' => 'Cust_No',
                'contentOptions' => ['width' => 100],
            ],
            [
                'attribute' => 'cust_name',
                'value'=>'customer.Cust_Name',
                'label'=>'ชื่อลูกค้า',                
            ],            
            

            [
                'attribute' => 'TotalAmount',
                'format' => ['decimal', 2],
                'hAlign' => 'right',
                'contentOptions' => ['width' => 100],
            ],
            //'Type_Inv_Code',
            //'Sale_Number',
            //'DivisionCode',
            //'DeptCode',


            //'SalesmanCode',
            //'DeliveryCode',
            //'Terms',
            //'ShipTo_Addr1',
            //'ShipTo_Addr2',
            //'ShipTo_Addr3',
            //'ShipTo_Addr4',
            //'Remark1',
            //'Remark2',
            //'Remark3',

            //'Cust_PO_No',
            //'Cust_PO_Date',
            //'Disc_Cash',
            //'Disc_Percent',
            //'Disc_Special',
            //'Disc_Money',
            //'Desc_Disc_Other',
            //'Disc_Other',
            //'Inv_Issue',
            //'Open_Close',
            //'Vat_Percent',
            //'Vat_Amount',
            //'Adjust_Date',
            //'Adjust_Many',
            //'Currency_Type',
            //'Currency_Rate',
            //'Amount',

            //'PaidAmount',
            //'Inv_Picture',
            //'UserName',
            //'LastUpdate',
            //'Vat_Type',
            //'BranchCode',
            //'delivery_date',
            //'TransportCode',
            //'Status_Prepare',
            //'PrintNo_Repair',
            //'Invs_Number',
            //'Service',    
            //['class' => 'yii\grid\ActionColumn'],        



        ],
    ]); ?>


</div>