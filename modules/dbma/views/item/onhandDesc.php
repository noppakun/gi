<?php
use kartik\grid\GridView;
?>
<div class="row">
    <div class="col-md-11 col-md-offset-1">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,    
            'responsiveWrap' => false,    
    

            'columns' => [
                [                
                    'attribute'=>'Ana_No',    
                ],
                [                
                    'attribute'=>'Ana_Qty',     
                    'format' => ['decimal',2],                                  
                    'hAlign'=>'right',
                ],
                [                
                    'attribute'=>'Mfg_Date',                    
                    'format' => ['date'],                                  
                    'hAlign'=>'center',
                ],
                [                
                    'attribute'=>'Exp_Date',                    
                    'format' => ['date'],                                  
                    'hAlign'=>'center',
                ],
                [                
                    'attribute'=>'UnitPrice',     
                    'format' => ['decimal',2],                                  
                    'hAlign'=>'right',
                    'visible'=>$showPrice
                ],           
                [                
                    'attribute'=>'Status',                     
                    'label'=>'QC',                     
                    'hAlign'=>'center',
                    'value'=>function($model){
                        
                        //return ($model->Status)=='N'?'N':'Y';        
                        return ($model->Status);
            
                    }
                    
                ],           

                

            ]

            
        ]); ?>
     </div>
</div>
