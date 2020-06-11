<?php
use kartik\grid\GridView;
?>
<div class="row">
    <div class="col-md-12">


    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,        
      
        
        //'summary'=>'',
        //'showFooter'=>true,

        'columns' => [
            [                
                'attribute'=>'invdet_desc',   
                'header' => 'Invoice description',
            ],
            [                
                'attribute'=>'order_qty',    
                'header' => 'Qty.',    
                'format' => ['decimal',2],                                  
                'hAlign'=>'right',
            ],
            [                
                'attribute'=>'price',    
                'header' => 'Price (Excl.Vat)',    
                'format' => ['decimal',2],                                  
                'hAlign'=>'right',
            ],
            [                
                'attribute'=>'batch_no',    
                'header' => 'Batch No.',   
                'hAlign'=>'center',

            ],             

        ]

        
    ]); ?>

    </div>
</div>