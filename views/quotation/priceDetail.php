<?php
use kartik\grid\GridView;
use yii\helpers\Html;
?>
    <div class="row">

        
        <div class="col-md-6  col-md-offset-1">

          
            <?= GridView::widget([
                'dataProvider' => $quotationPrice,
                'responsiveWrap'=>false,  
                'panelTemplate'=>"
                    {panelHeading}                
                    {items}                
                    {panelFooter}
                ",
                'panel' => [
                    'type'=>'primary',
                    'heading'=>'Quotation Price',                    
                    // 'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
                    // 'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
                    // 'footer'=>false
                ],

                'columns' => [
                    [                
                        'header'=>'DOC. Date',
                        'attribute'=>'doc_date',                    
                        'format' => ['date'],                                  
                        'hAlign'=>'center',
                    ],
                    [                
                        'header'=>'Item',
                        'attribute'=>'item_number',                                                   
                        'visible'=>($viewby == 'supp'),
                    ],                            
                    [                
                        'header'=>'Supplier',
                        'attribute'=>'supp_name',                    
                        'visible'=>($viewby == 'item'),
                    ],
                    
                    [                
                        'header'=>'จำนวน',
                        'attribute'=>'qty',     
                        'format' => ['decimal',2],                                  
                        'hAlign'=>'right',
                    ],
                    
                    // [
                        
                    //     'header'=>'ถึง',
                    //     'attribute'=>'qty2',     
                    //     'hAlign'=>'right',
                    //     'value'=>function ($model, $key, $index, $column) {
                    //         return $model['qty2'] == 0 ? '':number_format($model['qty2'],2);
                    //     },
                    // ],
                    [                
                        'header'=>'หน่วย',
                        'attribute'=>'unit',                    
                        'value'=>function ($model, $key, $index, $column) {
                            return $model['unit'] == '' ? '':$model['unit'];
                        },
                        
                    ],                            
                    [                
                        'header'=>'ราคา',
                        'attribute'=>'price',     
                        'format' => ['decimal',2],                                  
                        'hAlign'=>'right',
                        
                    ],            
                    

                ]

                
            ]); ?>        

        </div>
        <div class="col-md-5">
            <?= GridView::widget([
                'dataProvider' => $poHistory,
                'responsiveWrap'=>false,              
                'panelTemplate'=>"
                    {panelHeading}                
                    {items}                    
                    {panelFooter}
                ",                

                'panel' => [
                    'type'=>'success',
                    'heading'=>'PO. History',                    
                ],

                'columns' => [ 
                    [                
                        'header'=>'PO. No.',
                        'attribute'=>'order_number',                                                   
                    ],                    
                    [                
                        'header'=>'PO. Date',
                        'attribute'=>'order_date',                    
                        'format' => ['date'],                                  
                        'hAlign'=>'center',
                    ],
                    [                
                        'header'=>'Item',
                        'attribute'=>'item_number',                                                   
                        'visible'=>($viewby == 'supp'),
                    ],
                    [                
                        'header'=>'Supp.',
                        'attribute'=>'supp_number',                                                   
                        'visible'=>($viewby == 'item'),
                    ],                                                        
                    [                
                        'header'=>'จำนวน',
                        'attribute'=>'order_qty',     
                        'format' => ['decimal',2],                                  
                        'hAlign'=>'right',
                    ],
                    
                    [                
                        'header'=>'ราคา',
                        'attribute'=>'price',     
                        'format' => ['decimal',2],                                  
                        'hAlign'=>'right',
                        
                    ],            
                ]                
            ]); ?>      
            <?= Html::a('<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> More...', 
            ['/po-history',                 
                'viewby' =>$viewby,                
                'viewby_code'=>$viewby_code,                
                // 'month'=>$SelectForm->month,
                // 'customertypecode'=>$SelectForm->customertypecode,
                // 'cust_no'=>$SelectForm->cust_no,
                    ], 
            ['class' => 'btn btn-success']) ?>       
        </div> 
    </div>
 