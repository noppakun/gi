<?php

use kartik\grid\GridView;


?>  
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'headerRowOptions' => ['class' => 'clHead'],
        'showPageSummary'=>true,
        'responsiveWrap'=>false,
        'columns'=>[ 
 
            //'Item_Number:text:รหัสสินค้า',
            //'Item_Name:text:ชื่อสินค้า', 
            [
              'attribute'=>'Ana_No',
              
            ],
            [
                'label'=>'จำนวนที่ใช้ไป',
                'attribute'=>'Issue_Qty',
                'format' => ['decimal',4],
                'contentOptions' => ['align' => 'right'   ],
            ],
            'Uom:text:หน่วย',
            [
                'label'=>'ต้นทุนต่อหน่วย',
                'attribute'=>'UnitPrice',
                'format' => ['decimal',2],
                'contentOptions' => ['align' => 'right' ],
                'pageSummary'=>'รวม',
                
            ],            
            [
                'label'=>'ต้นทุนรวม',
                'attribute'=>'SumPrice',

                'format' => ['decimal',2],
                'contentOptions' => ['align' => 'right' ],
                'hAlign'=>'right',     
                'pageSummary'=>true,                           
            ],
            [
                'label'=>'ค่าโสหุ้ยคงที่',
                'attribute'=>'calFixedCost',
                'content'=>function ($model, $key, $index, $column){                
                    return ($model['calFixedCost'] == 0 ? '' : number_format($model['calFixedCost'],2));
                },                
                'format' => ['decimal',2],
                'contentOptions' => ['align' => 'right' ],
                'hAlign'=>'right',                                                               
            ],                                    
            


                                  
        ]

    ]); ?>


<?php
/*

echo '<pre>';
print_r($paraItem);
echo '</pre>';
*/
?>  