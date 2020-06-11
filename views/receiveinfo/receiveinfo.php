<style>
    .container {
        width: 1400px
    }

    .clHead {
        color: black;
        background-color: #DEE0FF;
    }

    .clGreen {
        color: black;
        background-color: #DEFFED
    }

    .clYellor {
        color: black;
        background-color: #FFFDDE
    }

    .clRed {
        color: black;
        background-color: #FFDEF0
    }

    .cllYellor {
        color: black;
        background-color: #FFFFED
    }

    .clDarkGreen {
        color: White;
        background-color: #669900
    }
</style>

<?php
use yii\helpers\Html;
use kartik\grid\GridView;

use yii\bootstrap\ActiveForm;
use app\widgets\ddlMonth;
use app\widgets\ddlYear;


use app\widgets\se2Salesman;
use app\widgets\se2Customer;
use app\widgets\se2Customertype;
use yii\data\ArrayDataProvider;
use app\components\XLib;

$this->title = 'Receive Info';
$this->params['breadcrumbs'][] = $this->title;

?>


<?php

$form = ActiveForm::begin([
    'method' => 'get',
    'layout' => 'horizontal',

    'options' => [
        'class' => 'well',
    ],
]);
?>
<span class="label label-default">เดือน / ปี ที่รับชำระ</span>

<!-- // echo ddlMonth::widget(['form'=>$form,'model' => $SelectForm,'field'=>'month','SelectQuarter'=>true]);   -->
<div class="row">
    <div class="col-md-6">
        <?= ddlYear::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'year']);   ?>
    </div>
    <div class="col-md-6">
        <?= ddlMonth::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'month', 'SelectQuarter' => true, 'selectAll' => true]);    ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= se2Customertype::widget([
            'form' => $form, 'model' => $SelectForm,
            'field' => 'customertypecode',
            'selectAll' => true,
            'showToggleAll' => false,
        ]) ?>
    </div>      
    <div class="col-md-6">
        <?= se2Customer::widget([
            'form' => $form, 'model' => $SelectForm,
            'field' => 'cust_no',
            'selectAll' => true,
            'showToggleAll' => false,
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= se2Salesman::widget([
            'form' => $form, 'model' => $SelectForm,
            'field' => 'sm_code',
            'selectAll' => true,
            'showToggleAll' => false,

        ]) ?>
    </div>




</div>

<div class="row">
    <!-- <div class="col-md-4">
            <?= $form->field($SelectForm, 'var2')->checkbox(['label' => 'Show detail']);
            ?>
        </div> -->

    <div class="col-md-6">
        <?= Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>
    </div>

    <div class="col-md-6 text-right">
        <?= Html::a(
            '<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export ( XLS )',
            [
                'tospreadsheet',
                'year' => $SelectForm->year,
                'month' => $SelectForm->month,
                'customertypecode' => $SelectForm->customertypecode,
                'cust_no' => $SelectForm->cust_no,
                'sm_code' => $SelectForm->sm_code,
            ],
            ['class' => 'btn btn-success']
        ) ?>
    </div>

</div>
<?php

$form::end();

?>
<div class="container-fluid">

    <?= GridView::widget([
        'responsiveWrap' => false,
        'dataProvider' => $dataProvider,
        'headerRowOptions' => ['class' => 'clHead'],
        'floatHeader' => true,
        //'showFooter'=>false,
        //'showPageSummary' => true,
        'panel' => [
            'type' => 'info',
            'before' => false, // ยกเลิก export ใช้ to actionTospreadsheet แทน
            'after' => false,
            'heading' => 'Total Receive : ' . number_format($SelectForm->var1, 0, '.', ','),
            //  'footer'=>null,
        ],
        //'showPageSummary' => true,         


        'columns' => [

            //['class' => 'kartik\grid\SerialColumn'],




            [
                'attribute' => 'cust_no',

                'content' => function ($model) use (&$p_lcustno) {
                    //return 'a';
                    return
                        '<span  style="float:left;">' .
                        $model['cust_no'] . ' : ' . $model['cust_name'] .

                        '</span>'
                        //.' <span  style="float:right;">Receive : '.number_format($model['cust_rec_amt'],0).'</span>'

                    ;
                },


                'group' => true,
                'groupedRow' => true,

                'groupOddCssClass' => [],
                'groupEvenCssClass' => [],
                'contentOptions' => ['class' => 'clDarkGreen'],






                'groupFooter' => function ($model, $key, $index, $widget) { // Closure method
                    return [
                        'mergeColumns' => [[1, 4]], // columns to merge in summary

                        'content' => [              // content to show in each summary cell

                            1 => 'Total',
                            //5 => GridView::F_SUM,                            
                            7 => GridView::F_SUM,


                        ],
                        'contentFormats' => [      // content reformatting for each summary cell
                            //5 => ['format' => 'number', 'decimals' => 0],
                            7 => ['format' => 'number', 'decimals' => 0],
                        ],
                        'contentOptions' => [      // content html attributes for each summary cell
                            1 => ['style' => 'text-align:right'],
                            //5 => ['style' => 'text-align:right'],                            
                            7 => ['style' => 'text-align:right'],
                        ],
                        // html attributes for group summary row
                        'options' => ['class' => 'info table-info', 'style' => 'font-weight:bold;']

                    ];
                },


            ],

            [
                'attribute' => 'sale_number',
                'header' => 'SO.NO / SO.Date'
                    //.' ( SO.Amt / Tot.Rec / Remainder )'     
                    . ' ( '
                    . '<span class="text-success">SO.Amt</span> / '
                    . '<span class="text-warning">Tot.Rec</span> / '
                    . '<span class="text-danger">Remainder</span>'
                    . ' )',
                'format' => 'raw',

                'content' => function ($model) {
                    return $model['sale_number'] . ' / ' . date("d-m-Y", strtotime($model['sale_date']))
                        . ' ( '
                        . '<span class="text-success">' . number_format($model['sale_amt'], 0) . '</span> / '
                        . '<span class="text-warning">' . number_format($model['tot_rec_amt'], 0) . '</span> / '
                        . '<span class="text-danger">' . number_format($model['remainder'], 0) . '</span>'
                        . ' )';
                },

                'groupOddCssClass' => [], 'groupEvenCssClass' => [],
                'group' => true,
                'subGroupOf' => 0,
                'contentOptions' => ['class' => 'clGreen', 'width' => 300],
                'headerOptions' => ['style' => 'text-align:center'],


            ],




            // [                
            //     'attribute'=>'sale_amt',   
            //     'header' => 'SO.Amt.',  
            //     'format' => ['decimal',0],                                   
            //     'groupOddCssClass'=>[],'groupEvenCssClass'=>[],
            //     'contentOptions' => ['align' => 'right','class' => 'clGreen','width'=>80],                
            //     'headerOptions' => ['style' => 'text-align:center'],                
            // ], 
            // [                
            //     'attribute'=>'tot_rec_amt',   
            //     'header' => 'Tot.Rec.',   
            //     'format' => ['decimal',0],                
            //     'groupOddCssClass'=>[],'groupEvenCssClass'=>[],
            //     'contentOptions' => ['align' => 'right','class' => 'clGreen','width'=>80],                   
            //     'headerOptions' => ['style' => 'text-align:center'],                                 
            // ],
            // [                
            //     'attribute'=>'remainder',                                    
            //     'content' => function ($model){                                           
            //         return (abs($model['remainder'])<1)  ? '': number_format($model['remainder'], 0); 
            //     },                              
            //     'groupOddCssClass'=>[],'groupEvenCssClass'=>[],
            //     'contentOptions' => ['align' => 'right','class' => 'clRed','width'=>80],                   
            //     'headerOptions' => ['style' => 'text-align:center'],                
            // ],    

            [
                'attribute' => 'yamt',
                'header' => 'Deposit',
                'contentOptions' => ['align' => 'right', 'class' => 'cllYellor', 'width' => 80],
                'content' => function ($model) {
                    return XLib::xnumber_format($model['yamt'], 0, '');
                },
                'headerOptions' => ['style' => 'text-align:center'],

            ],
            [
                'attribute' => 'namt',
                'header' => 'FG./SERV.',
                'contentOptions' => ['align' => 'right', 'class' => 'cllYellor', 'width' => 80],
                'content' => function ($model) {
                    return XLib::xnumber_format($model['namt'], 0, '');
                },
                'headerOptions' => ['style' => 'text-align:center'],
            ],

            [
                'attribute' => 'ramt',
                'header' => 'RM.',

                'contentOptions' => ['align' => 'right', 'class' => 'cllYellor', 'width' => 80],
                'content' => function ($model) {
                    return XLib::xnumber_format($model['ramt'], 0, '');
                },
                'headerOptions' => ['style' => 'text-align:center'],

            ],
            [
                'attribute' => 'pamt',
                'header' => 'PM.',

                'contentOptions' => ['align' => 'right', 'class' => 'cllYellor', 'width' => 80],
                'content' => function ($model) {
                    return XLib::xnumber_format($model['pamt'], 0, '');
                },
                'headerOptions' => ['style' => 'text-align:center'],
            ],
            [
                'attribute' => 'oamt',
                'header' => 'OTH.',
                'contentOptions' => ['align' => 'right', 'class' => 'cllYellor', 'width' => 80],
                'content' => function ($model) {
                    return XLib::xnumber_format($model['oamt'] + $model['disc_amt'], 0, '');
                },
                'headerOptions' => ['style' => 'text-align:center'],
            ],

            [
                'attribute' => 'rec_amt',
                'header' => 'Rec.Amt.',
                'format' => ['decimal', 0],
                'contentOptions' => ['class' => 'clYellor', 'width' => 80],
                'hAlign' => 'right',

            ],



            [
                'attribute' => 'inv_number',
                'header' => 'Inv.No.',
                'contentOptions' => ['width' => 80],
                'headerOptions' => ['style' => 'text-align:center'],
            ],
            [
                'attribute' => 'rec_date',
                'header' => 'Rec.Date',
                //'format' => ['date'],   
                'content' => function ($model) {
                    return date("d-m-Y", strtotime($model['rec_date'])) .
                        ' <span class="label label-' . (($model['rec_type']) == 'CR' ? 'success' : (($model['rec_type']) == 'BR' ? 'info' : 'warning')) .
                        '">' . $model['rec_type'] . '</span>';
                },
                'contentOptions' => ['width' => 120],
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'visible' => false,
                'detail' => function ($model, $key, $index, $column) {
                    // return Yii::$app->controller->renderPartial('invoiceDesc', ['inv_number'=>$model['inv_number']]);
                    $sql = "select 1 as seq,a.invdet_desc,a.order_qty,
                    case when b.vat_type ='X' then  a.price else a.price- (a.price*b.Vat_Percent/(100+isnull(b.Vat_Percent,0))) end as price,
                    a.batch_no 
                    from invoicedet a left join invoice b on a.inv_number=b.inv_number where a.inv_number =:inv_number
                    
                    union 

                    select 2 as seq ,a.cndet_desc as invdet_desc,- a.order_qty as order_qty,
                    case when b.vat_type ='X' then  a.price else a.price- (a.price*b.Vat_Percent/(100+isnull(b.Vat_Percent,0))) end as price,
                    '' as batch_no 
                    from CNDetail a left join CN b on a.cn_number=b.cn_number where a.cn_number =:inv_number2
                    
                    ";
                    $connection = \Yii::$app->erpdb;
                    $command = $connection->createCommand($sql);
                    $command->bindParam(":inv_number", $model['inv_number']);
                    $command->bindParam(":inv_number2", $model['inv_number']);
                    $rows = $command->queryAll();
                    $dataProvider = new ArrayDataProvider([
                        'allModels' => $rows,
                        'pagination' => [
                            'pageSize' => 20,
                        ],
                    ]);

                    return Yii::$app->controller->renderPartial('invoiceDesc', [
                        'inv_number' => $model['inv_number'],
                        'dataProvider' => $dataProvider,
                    ]);
                },


            ],

        ]

    ]); ?>
    <span class="label label-success">CR:เงินสด</span>
    <span class="label label-info">BR:เช็ค</span>
    <span class="label label-warning">RB:เงินโอน</span>

</div>