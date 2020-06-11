<?php
use kartik\grid\GridView;

?>
* ข้อมูลย้อนหลัง 2 ปี
    <?= GridView::widget([
        'dataProvider' => $dataProvider,        
        'responsiveWrap' => false, 
        
        //'afterHeader'=>'ยอดหลัง 2 ปี',
        'columns' => [

            
            [
                'attribute'=>'docdate',
                'header' => 'วันที่',
                'hAlign' => 'center', 
              
                'contentOptions' => ['align' => 'center'],
                'content' => function ($model) {           
                    return $model['docdate'] == null  ? '': date("d-m-Y",strtotime($model['docdate']));                    
                },                  
            ],             
             
            [                
                'header'=>'รายการ',                
                'attribute'=>'doctypedesc',    
            ],
             

            [                
                'header'=>'รับเข้า',
                'attribute'=>'recv_qty',                    
                'hAlign' => 'right', 
                'content' => function ($model) {           
                    return $model['recv_qty'] == 0 ? '-': number_format($model['recv_qty'],2);                    
                },                  
            ],             
            [                
                'header'=>'เบิกออก',
                'attribute'=>'issue_qty',    
                'hAlign' => 'right', 
                'content' => function ($model) {           
                    return $model['issue_qty'] == 0 ? '-': number_format($model['issue_qty'],2);                    
                },                  
            ],
            [                                
                'header'=>'คงเหลือ',                                
                'hAlign' => 'right', 
                'content' => function ($model) {           
                    return $model['_calonhand'] == 0 ? '-': number_format($model['_calonhand'],2);                    
                },                   
            ],            
            [                
                'header'=>'เลขที่เอกสาร',                
                'attribute'=>'voucherno',    
            ],    
    
            /*
            [                
                'header'=>'คงเหลือ',
                'attribute'=>'balance',    
                'contentOptions' => ['align' => 'right'],  
                'hAlign' => 'center', 
                'content' => function ($model) {           
                    return $model['balance'] == 0 ? '-': number_format($model['balance'],2);                    
                },                  
            ],
            */            
             

        ]
        
    ]); ?>
 