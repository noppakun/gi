 <?php

    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use kartik\grid\GridView;

    use app\widgets\ddlMonth;
    use app\widgets\ddlYear;
    use app\widgets\se2Customertype;
    use app\widgets\se2Customer;


    $this->title = 'Salesinfo';
    $this->params['breadcrumbs'][] = $this->title;


    $monthTextArray = \app\components\XLib::monthTextArray;
    $summary = 0;
    foreach ($dataProvider->query->all() as $item) {
        $summary += $item['amt'];
    }
    $appvar = app\models\Appvar::find()
        ->where([
            'app_key' => 'salesinfo',
            'app_value' => 'run'
        ])->one();
    ?>

 <?php
    //  AAAAAAAAAAAAAAAAAAAAAAAAAAAA      select form
    $form = ActiveForm::begin([
        'method' => 'get',
        'layout' => 'horizontal',
        'options' => [
            'class' => 'well',
        ],
    ]);
    ?>

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
 </div>
 <div class="row">
     <div class="col-md-6">
         <?= $form->field($SelectForm, 'checkbox')->checkbox()->label('ไม่รวมเงินมัดจำ/เงินรับล่วงหน้า'); ?>
     </div>
     <div class="col-md-6  text-right">
         <?= Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>
     </div>
     <!-- <div class="col-md-2  text-right">    
            <?= Html::a(
                '<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export ( XLS )',
                [
                    'indextospreadsheet',
                    'year' => $SelectForm->year,
                    'month' => $SelectForm->month,
                    'customertypecode' => $SelectForm->customertypecode,
                    'cust_no' => $SelectForm->cust_no,
                ],
                ['class' => 'btn btn-success']
            ) ?>
    </div>     -->

 </div>
 <?php
    $form::end();
    //  BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBb     select form    
    ?>




 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'headerRowOptions' => ['class' => 'success'],
        'floatHeader' => true,
        'showPageSummary' => true,
        'layout' => '{summary}{items}{pager}',
        // 'pageSummaryRowOptions' => [
        //     'class' => 'infomation',          
        // ],



        'columns' => [

            [
                'attribute' => 'trmonth',
                'group' => true,
                'value' => function ($model) use ($monthTextArray) {
                    return $monthTextArray[$model['trmonth']];
                },
                'contentOptions' => ['style' => 'width:75px'],
                'groupFooter' => function ($model, $key, $index, $widget) use ($monthTextArray) { // Closure method
                    return [
                        'mergeColumns' => [[0, 3]], // columns to merge in summary
                        'content' => [             // content to show in each summary cell
                            0 => 'Sum : ' . $monthTextArray[$model['trmonth']],
                            4 => GridView::F_SUM,
                        ],
                        'contentFormats' => [      // content reformatting for each summary cell                            
                            4 => ['format' => 'number', 'decimals' => 2],
                        ],
                        'contentOptions' => [      // content html attributes for each summary cell

                            0 => ['style' => 'text-align:right'],
                            4 => ['style' => 'text-align:right'],
                        ],
                        // html attributes for group summary row
                        'options' => ['class' => 'info', 'style' => 'font-weight:bold;']
                    ];
                }
            ],
            [
                'attribute' => 'cust_name',
                'contentOptions' => ['style' => '<width:22></width:22>0px;  min-width:220px;  '],
                'group' => true,
                'subGroupOf' => 0,
            ],



            [
                'attribute' => 'item_name',
                'contentOptions' => ['style' => 'width:300px;  min-width:500px;  ',],
                'pageSummary' => 'Summary',

            ],
            [
                'attribute' => 'qty',
                'format' => ['decimal', 2],
                'hAlign' => 'right',
                'contentOptions' => ['style' => 'width:120px;'],
            ],
            [
                'attribute' => 'amt',
                'format' => ['decimal', 2],
                'hAlign' => 'right',
                'contentOptions' => ['style' => 'width:120px;'],
                'pageSummary' => number_format($summary, 2),
            ],
            // [
            //     'attribute'=>'doc_no',
            //     'contentOptions' => ['style' => 'width:120px;'],                             
            // ], 


        ],

    ]); ?>
 <div class="col-md-6"> 
     <ul>
         <li>
             Markup : sales amount - variable cost
         </li>
         <li>
             ข้อมูลย้อนหลัง 3 ปี + ปีปัจจุบัน
         </li>

     </ul>


 </div>
 <div class="col-md-6">
     <?= Html::a('Update Data', ['update'], ['class' => 'btn btn-success']) ?>
     <span class="label label-primary">last update : <?= date("d-m-Y  /  H:i:s", strtotime($appvar->lastupdate)); ?>
     </span>
 </div>