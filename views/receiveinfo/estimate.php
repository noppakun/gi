 <?php

    use yii\helpers\Html;
    use kartik\grid\GridView;

    use yii\bootstrap\ActiveForm;
    use app\widgets\ddlMonth;
    use app\widgets\ddlYear;


    use app\components\gihelper;
    use app\components\XLib;


    
    $this->title = 'ประมาณการรับชำระ';
    $this->params['breadcrumbs'][] = $this->title;
    

    $monthTextArray = \app\components\XLib::monthTextArray;


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
         <?= \app\widgets\se2Customertype::widget([
                'form' => $form, 'model' => $SelectForm,
                'field' => 'customertypecode',
                'selectAll' => true,
                'showToggleAll' => false,
            ]) ?>
     </div>

     <div class="col-md-6">
         <?= \app\widgets\se2Customer::widget([
                'form' => $form, 'model' => $SelectForm,
                'field' => 'cust_no',
                'selectAll' => true,
                'showToggleAll' => false,
            ]) ?>
     </div>
 </div>

 <div class="row">
     <div class="col-md-5"
>
         <?= $form->field($SelectForm, 'checkbox')->checkbox()->label('เฉพาะรายการที่มีการวางบิล'); ?>
     </div>

     <div class="col-md-5">
         <?= $form->field($SelectForm, 'checkbox2')
                ->checkbox(['class' => 'navbar-header'])->label('แสดงรวมรายการที่รับชำระแล้ว'); ?>
     </div>
   
 

     <div class="col-md-3">
         <?= Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>
         <?= Html::submitButton(null, ['class' => 'glyphicon glyphicon-print btn btn-success','name' => 'btPrint','value' => 'btPrint' ]); ?>         
         <?= Html::submitButton('XLS', ['class' => 'btn btn-success','name' => 'btXls','value' => 'btXls']); ?>
         
        
         

     </div>
 </div>


 <span class="label label-default">เดือน / ปี : วันที่นัดชำระ / วันที่ครบกำหนด </span>

 <?php
    $form::end();
    //  BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBb     select form    
    ?>
 <?php

$cssStyles = [
    '.kv-group-even' => ['background-color' => '#f0f1ff'],
    '.kv-group-odd' => ['background-color' => '#f9fcff'],
    '.kv-grouped-row' => ['background-color' => '#fff0f5', 'font-size' => '1.3em', 'padding' => '10px'],
    '.kv-table-caption' => [
        'border' => '1px solid #ddd',
        'border-bottom' => 'none',
        'font-size' => '1.5em',
        'padding' => '8px',
    ],
    '.kv-table-footer' => ['border-top' => '4px double #ddd', 'font-weight' => 'bold'],
    '.kv-page-summary td' => [
        'background-color' => '#ffeeba',
        'border-top' => '4px double #ddd',
        'font-weight' => 'bold',
    ],
    '.kv-align-center' => ['text-align' => 'center'],
    '.kv-align-left' => ['text-align' => 'left'],
    '.kv-align-right' => ['text-align' => 'right'],
    '.kv-align-top' => ['vertical-align' => 'top'],
    '.kv-align-bottom' => ['vertical-align' => 'bottom'],
    '.kv-align-middle' => ['vertical-align' => 'middle'],
    '.kv-editable-link' => [
        'color' => '#428bca',
        'text-decoration' => 'none',
        'background' => 'none',
        'border' => 'none',
        'border-bottom' => '1px dashed',
        'margin' => '0',
        'padding' => '2px 1px',
    ],
];  
    $gridViewPDF = [
        'mime' => 'application/pdf',
        'cssStyles'=>$cssStyles,
        'config' => [
            // 'cssInline' => file_get_contents(\Yii::getAlias('@app').'/web/css/kv-mpdf.css')
            //     .   '.kv-heading-1{font-size:58px}', 
            
            'cssFile' => '@app/web/css/kv-mpdf-xreport.css', 
            //'cssFile' => '@app/web/css/test.css', 
            //'cssFile' => '@app/web/css/test.css', 
            
            
            // 'cssInline' =>'
            //     body {
            //         /* font-family: "Garuda";
            //         font-size: 14px; */
                
            //         font-family: "saraban";    
            //         font-size: 20px;
            //     }

            //     .kv-grid-table thead,th,td  { 
            //         font-size: 20px;    
            //      }
                                
                

            // ',

            'format' => 'A4',
            'orientation' => 'L',
            'destination' => 'I',
            'marginTop' => 22,
            'methods' => [
                'SetHeader' => [
                    '<h5>' . gihelper::comp_name() . '</h5>' .
                        '<br>ประมาณการรับชำระ' .
                        '||Page : {PAGENO}/{nbpg}<br><br>Date : ' . date("d-m-Y")
                ],
                'SetFooter' => ['.'],

            ],
        ],
    ];    
    ?>
 <?= GridView::widget([
        'responsiveWrap' => false,
        'dataProvider' => $dataProvider,
        'headerRowOptions' => ['class' => 'success'],
        'floatHeader' => true,
        'showPageSummary' => true,
        //'export'=>true,
        // 'panel' => [
        //     'type' => GridView::TYPE_DEFAULT,
        //     //'heading'=>'Company',
        // ],

        'export' => [
            'target' => GridView::TARGET_BLANK,
            'encoding' => 'utf-8',
        ],
        'exportConfig' => [
            GridView::PDF => $gridViewPDF,
            //GridView::EXCEL => true,
            GridView::HTML => true,
        ],
        'columns' => [
            [
                'header' => 'เดือน',
                'attribute' => 'month',
                'group' => true,
                //'groupedRow'=>(true),    
                'value' => function ($model) use ($monthTextArray) {
                    return $monthTextArray[$model['month']];
                },
                'contentOptions' => ['class' => 'danger', 'style' => 'font-weight:bold;'],
                'groupFooter' => function ($model, $key, $index, $widget) use ($monthTextArray) { // Closure method
                    return [
                        'mergeColumns' => [[0, 4]], // columns to merge in summary
                        'content' => [             // content to show in each summary cell
                            0 => 'Sum : ' . $monthTextArray[$model['month']],
                            5 => GridView::F_SUM,
                            6 => GridView::F_SUM,
                            7 => GridView::F_SUM,
                        ],

                        'contentFormats' => [      // content reformatting for each summary cell                            
                            5 => ['format' => 'number', 'decimals' => 0],
                            6 => ['format' => 'number', 'decimals' => 0],
                            7 => ['format' => 'number', 'decimals' => 0],
                        ],
                        'contentOptions' => [      // content html attributes for each summary cell
                            //1=>['style'=>'font-variant:small-caps'],
                            0 => ['style' => 'text-align:right'],
                            5 => ['style' => 'text-align:right'],
                            6 => ['style' => 'text-align:right'],
                            7 => ['style' => 'text-align:right'],
                        ],
                        // html attributes for group summary row
                        'options' => ['class' => 'info', 'style' => 'font-weight:bold;']
                    ];
                }
            ],



            [
                'header' => 'ลูกค้า',
                'attribute' => 'cust_name',
                'group' => true,
                'subGroupOf' => 0,
                // 'groupFooter' => function ($model, $key, $index, $widget) use ($monthTextArray) { // Closure method
                //     return [
                //         'mergeColumns' => [[1, 4]], // columns to merge in summary
                //         'content' => [             // content to show in each summary cell
                //             4 => 'Sum',
                //             5 => GridView::F_SUM,
                //             6 => GridView::F_SUM,
                //             7 => GridView::F_SUM,
                //         ],

                //         'contentFormats' => [      // content reformatting for each summary cell                            
                //             5 => ['format' => 'number', 'decimals' => 0],
                //             6 => ['format' => 'number', 'decimals' => 0],
                //             7 => ['format' => 'number', 'decimals' => 0],
                //         ],
                //         'contentOptions' => [      // content html attributes for each summary cell
                            
                //             1 => ['style' => 'text-align:right'],
                //             4 => ['style' => 'text-align:right'],
                //             5 => ['style' => 'text-align:right'],
                //             6 => ['style' => 'text-align:right'],
                //             7 => ['style' => 'text-align:right'],
                //         ],
                      
                //         'options' => [ 'style' => 'font-weight:bold;']
                //     ];
                // }


            ],
            [
                'header' => 'เลขที่ใบกำกับฯ',
                'attribute' => 'inv_number',
                'contentOptions' => ['width' => 100],
            ],
            [
                'header' => 'วันที่ใบใบกำกับฯ',
                'attribute' => 'inv_date',
                'format' => 'date',
                'contentOptions' => ['width' => 100],
                'hAlign' => 'center',
                'pageSummary' => 'Summary',
            ],
            [
                'header' => 'วันที่ครบกำหนด',
                'attribute' => 'due_date',
                'format' => 'date',
                'contentOptions' => ['width' => 100],
                'hAlign' => 'center',

            ],
            [
                'header' => 'ยอดตามใบกำกับฯ',
                'attribute' => 'amount',
                'format' => ['decimal', 0],
                'hAlign' => 'right',
                'contentOptions' => ['width' => 80],
                'pageSummary' => number_format($params['sum_amount'], 0),




            ],
            [
                'header' => 'ยอดชำระแล้ว',
                'attribute' => 'payamount',
                'hAlign' => 'right',
                'contentOptions' => ['width' => 80],
                'content' => function ($model) {
                    //  return ($model['payamount']<1)?'-':number_format($model['payamount'],0);                    
                    return XLib::xnumber_format($model['payamount'], 0, '');
                },
                'pageSummary' => XLib::xnumber_format($params['sum_payamount'], 0, '-'),

            ],
            [
                'header' => 'ยอดค้างชำระ',
                //'format' => ['decimal',0],
                'contentOptions' => ['class' => 'bg-warning', 'width' => 80],
                'hAlign' => 'right',
                'value' => function ($model) {
                    return XLib::xnumber_format($model['amount'] - $model['payamount'], 0, '-');
                },
                'pageSummary' => number_format(round($params['sum_amount'], 0) - round($params['sum_payamount'], 0), 0),
            ],

            [
                'header' => 'วันที่นัดชำระ',
                'attribute' => 'arduedate',
                'contentOptions' => ['width' => 100],
                'value' => function ($model) {
                    $_arduedate=XLib::xisnull($model['arduedate'],XLib::xisnull($model['due_date_acc'],null));                                       
                    return XLib::xisnull(XLib::dateConv($_arduedate, 'a'), '-');
                    
                },
                'hAlign' => 'center',
            ],

            [
                'header' => 'เลขที่ใบวางบิล',
                'attribute' => 'arbillno',
                'contentOptions' => ['width' => 100],
                'hAlign' => 'center',
                'value' => function ($model) {
                    return XLib::xisnull($model['arbillno'], '-');
                },
            ],
             
            [
                'header' => 'วันที่รับชำระ',
                'attribute' => 'receive_date',
                'contentOptions' => ['width' => 100],
                'value' => function ($model) {
                    //return $model['arduedate']==null?'-' : XLib::dateConv($model['arduedate'],'a'); ;
                    return XLib::xisnull(XLib::dateConv($model['receive_date'], 'a'), '-');
                },
                'hAlign' => 'center',
            ],            


        ]





    ]); ?>