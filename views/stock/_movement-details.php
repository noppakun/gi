<?php

use yii\helpers\Html;
use kartik\grid\GridView;

// -------------------------------
$layout = <<< HTML
<div class="clearfix" style="background-color: red;"></div>
{items}
{pager}
HTML;
// -------------------------------
?>
<div class="st-card-index">
    
    <div class="row">
        <div class="col-md-11 col-md-offset-1">
            <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'showPageSummary' => true,
                    'responsiveWrap' => false,
                    'layout' => $layout,
                    'columns' => [            

                        'Item_Number',
                        'Item_Desc',
                      
                    
                        [                         
                            'attribute' =>'Ana_No',                 
                            'pageSummary' => 'รวม',                
                        ],

                        [                         
                            'label' =>'จำนวน',                
                            'value'=>function($model){
                                return $model->Recv_Qty+ $model->Issue_Qty;
                            },
                            'format'=>['decimal',3],
                            'hAlign' => 'right',                 
                            'width' => '100px',                
                        ],     
                        [                         
                            'label' =>'หน่วย',                
                            'attribute' =>'item.Uom',                
                            'hAlign' => 'center',                 
                            'width' => '50px',                
                        ],
                        [                         
                            'attribute' =>'UnitPrice',
                            'format'=>['decimal',2],            
                            'hAlign' => 'right',                 
                            'width' => '100px',                
                        ],
                        [                         
                            'attribute' =>'SumPrice',                
                            'format'=>['decimal',2],            
                            'hAlign' => 'right',                 
                            'width' => '100px',   
                            'pageSummary' => true,             
                        ],
                        'AccountCode',
                        'CsCode',
                        'WhCode',

                        //'Ana_No',
                        //'SumPrice',
                        //'Item_Uom',
                        //'CompanyCode',
                        //'DocType',
                        //'VoucherNo',
                        // 'Recv_Qty',
                        // 'Issue_Qty',
                        
                        //'Location',

                        
                        //'Status',
                        //'Batch',
                        //'TimeRecord',
                        //'UserName',
                        //'WorkStart',
                        //'WorkStop',
                        //'QA_StartDateTime',
                        //'QA_StopDateTime',
                        //'QA_MachCode',
                        //'QA_ApvDate',
                        //'MachCode',
                        
                        //'WantQCDate',
                        //'EmployeeCode',
                        //'Checker_Status',
                        //'Tare_Weight',
                        //'KpiDte2',
                        //'KpiDte1',

                        
                    ],
                ]); ?>
        </div>
    </div>

</div>
