<meta http-equiv="refresh" content="300">
<!--auto refresh 300 sec ( 5 minute )-->
<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Product Launching Planning';
$this->params['breadcrumbs'][] = $this->title;    

$form = ActiveForm::begin([ 
    'method' => 'get',
//    'layout' => 'horizontal',
]);
?>

    <?= $form->field($SelectForm, 'checkbox')->checkbox([
        'label' => 'แสดงทั้งหมด' ,
        'onclick'=>'submit()',
    ]);?>    
<?php
    $form::end();
?>    
<?= GridView::widget([       
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap'=>false,  
        'rowOptions' => function ($model, $index, $widget, $grid){
            if($model['stcardcount'] == 0){                        
                //return ['class' => 'success'];                
                return [];
            }else{
                return [];
            }
        },        
        'columns'=>[               
            
            [
                'attribute'=>'Item_Number',
                'format' => 'raw',                
                'value' => function ($data) {
  
                    return Html::a($data['Item_Number']
                        //.($data->notecount > 0 ? '<span class="badge">'.$data->notecount.'</span>':'')
                        //.($data->notecount > 0 ? '<span class="badge">'.$data->notecount.'</span>':'')                        
                        //.($data->notecount > 0 ? '<span class="badge">'.$data->prodnotecount->notecount.'</span>':'')                        
                        .((!isset($data->prodnotecount->notecount)?0:$data->prodnotecount->notecount) > 0 ? '<span class="badge">'.$data->prodnotecount->notecount.'</span>':'')                        
                        
                        .($data->stcardcount == 0 ? '<span class="label label-success"> NEW !</span>':'')
                        
                        
                                         
                        
                        , ['/prod/view', 
                        'order_no' => $data['Order_No'],
                        'item_number' => $data['Item_Number'],
                        
                    ]);
                },
                /*
                'contentOptions' => function($data){
                    
                    return ['style' => $data->stcardcount == 0?'background-color:#ccffcc':'' ];
                    	
                }
                */
                
                
            ],                
                
            
            [
                'attribute'=>'Item_Name',                
                'value'=>'item.Item_Name',  
            ],            
            [
                //'attribute'=>'item.Industry_Code',                
                'attribute'=>'Industry_Code',                
                'value'=>'item.Industry_Code',
                'label'=>'รหัสโรงงาน /<br>รหัสลูกค้า',
                'encodeLabel' => false,
            ],             
            [
                'attribute'=>'Order_Qty',                
                'format' => ['decimal',4],
                
                'contentOptions' => ['align' => 'right' ],
            ],            
            
            [
                'attribute'=>'priority.refname',                
                'label'=>'Priority',
                'width'=>'100px',
            ],            
            
            'status.refname:text:Status',
            //'Jst_Name',
            /*
            [
                'attribute'=>'Due_Date',                
                'format' => 'date',                
                'width'=>'100px',
                
            ],
            */
            [
                'label'=>'F/G Date',
                //'format' => 'raw',                
                //'format' => 'date',                                
                'value' => function ($data) {  
                    $rm = strtoupper($data['prod']['Remarks']).' ';
                    $pos = strpos($rm,'F/G@');                                        
                    $ret = ($pos===false)?'':
                        Yii::$app->formatter->format(strtotime(str_replace('/', '-', 
                            substr($rm,$pos+4,strpos($rm.' ',' ',$pos))
                        )), 'date');
                    return $ret;
                },
                
                
            ],                        

            
            
            [
                'attribute'=>'Order_No',                
                'label'=>'เลขที่ใบสั่งผลิต',
                'width'=>'100px',
            ],     
            [
                'attribute'=>'prod.Order_Date',                
                //'label'=>'วันที่ ใบสั่งผลิต',
                'format' => 'date',                                
                'width'=>'100px',
            ], 
            /*
            [
                'label'=>'.',
                'attribute'=>'prodnotecount.notecount',                
                
                
            ],
              */           
            /*
            [
                'attribute'=>'prod.Remarks',                
                //'label'=>'วันที่',
                //'format' => 'date',                                
                //'width'=>'100px',
            ],
            */                    
    /*        
            [
                'attribute'=>'stcardcount',                 
            ],
      */                    
            //'notecount',
        ]

    ]); ?>
<p>
* ข้อมูลจากใบสั่งผลิต | auto refresh page every 5 minutes


<!-- return ['style' => $data->stcardcount == 0?'background-color:#ccffcc':'' ]; -->
</p>