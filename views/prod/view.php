<?php
use kartik\grid\GridView;
use yii\helpers\Html;
$this->title = 'Product Launching Planning';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $order_no.' - '.$item_number;

// $this->params['breadcrumbs'][] = ['label' => $order_no.' / '.$item_number, 'url' => ['view', 'id' => $item_number]];


//$this->params['breadcrumbs'][] = 'Update';


?>

<?= GridView::widget([       
        'dataProvider' => $dataProvider,
        'responsiveWrap'=>false,  
        'rowOptions' => function ($model, $index, $widget, $grid){
            if($model['note'] == null){                        
                return [];                
            }else{                
                return ['class' => 'danger'];
            }
        },                
        'columns'=>[            
            [
                'attribute'=>'Item_Number',
                'group'=>true,
                'groupedRow'=>true,   
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) { 
                    return 'ITEM : '.$model['Item_Number']
                    .($model['Status']=='C'? '<span class="text-success ">( Closed )</span>':'')
                    
                    ;
                },                
            ],             
            
            [
                'attribute'=>'type_invent',
                'group'=>true,
                'subGroupOf'=>0,
            ],              
            [
                'attribute'=>'Component',
                'format' => 'raw',                
                'value' => function ($data) {
  
//                    return $data['Component'].($data['notecount'] > 0 ? '<span class="badge">'.$data['notecount'].'</span>':'');       

                    return Html::a(
                        $data['Component'].($data['notecount'] > 0 ? '<span class="badge">'.$data['notecount'].'</span>':''),       
                        [
                            '/prod/note',                 
                            'order_no' => $data['Order_No'],
                            'item_number' => $data['Item_Number'],
                            'component' => $data['Component'],      
                        ]);                    
                },
                
                
            ],             
            'Component_name:text:Descripton',
            //'qty_use',
            //'QtyOnhand',
            [
                'attribute'=>'pr_date',
                'format' => 'raw',
                'label'=>'PR.Date',                
                'value' => function ($data) {
                    //return $data['pr_date']==null?'':Yii::$app->formatter->format(strtotime($data['pr_date']), 'date');  

                    return Html::a(
                        ($data['pr_date']==null?'':Yii::$app->formatter->format(strtotime($data['pr_date']), 'date')  ),
                        
                               
                        [
                            '/prod/viewpr',                 
                            'pr_number' => $data['pr_number'],
                        ]);

                },   
            ],         


            
            //'pr_number',
            //'po_date:date:PO.Date',
            [
                'attribute'=>'po_date',
                'format' => 'raw',                
                'label'=>'PO.Date',                
                'value' => function ($data) {
                    //return $data['po_date']==null?'':Yii::$app->formatter->format(strtotime($data['po_date']), 'date');  

                    return Html::a(
                        ($data['po_date']==null?'':Yii::$app->formatter->format(strtotime($data['po_date']), 'date')  ),                               
                        [
                            '/prod/viewpo',                 
                            'po_number' => $data['po_number'],
                        ]);                    
                },   
            ],         
            
            //'po_number',
            //'',
            [
                'attribute'=>'note',
                'label'=>'Status',
                'format' => 'raw',   
                'value' => function ($data) {  
                    return $data['note']==null?'n/a':$data['note'];
                    
                },   
                'headerOptions' => ['class' => 'text-center'],           
                'contentOptions' => ['align' => 'center' ],    
            ],         
            
            
            //'recd_date:date:Receive Date',
            [
                'attribute'=>'recd_date',
                'label'=>'Receive Date*',                
                'value' => function ($data) {
                    return $data['recd_date']==null?'':Yii::$app->formatter->format(strtotime($data['recd_date']), 'date');  
                },   
            ],             
            //'dock_number',
            //'delivery_date:date:Delivery Date',
            [
                'attribute'=>'delivery_date',
                'label'=>'Delivery Date*',                
                'value' => function ($data) {
                    return $data['delivery_date']==null?'':Yii::$app->formatter->format(strtotime($data['delivery_date']), 'date');                      
                },   
            ],             
            

        ],

    ]); ?>
    <p>
    * Receive Date : วันที่รับเข้าจากการซื้อล่าสุด (Dock)  &nbsp;&nbsp;&nbsp;&nbsp  Delivery Date : วันที่ของจะเข้า (PO)
    </p>
 
