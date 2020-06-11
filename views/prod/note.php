<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use yii\web\UrlManager;

$this->title = 'Product Launching Planning';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $order_no.' - '.$item_number, 'url' => ['view','order_no'=>$order_no,'item_number'=>$item_number]];
$this->params['breadcrumbs'][] = $component;
 
?>
<?= GridView::widget([       
        'dataProvider' => $dataProvider,
        'responsiveWrap'=>false,  
        'rowOptions' => function ($model, $index, $widget, $grid){
            if($model['status'] == 'N'){                        
                return ['class' => 'danger'];
            }else{
                //return ['class' => 'info'];
                return [];
            }
        },        
        
        'columns'=>[
            
             
            
            [            
                'attribute'=>'note',
               
                //'width'=>'50%',
            ],    
            [            

                'attribute'=>'username',
                'label'=>'ผู้บันทึก',
                'format' => 'raw',   
                'value' => function ($data) {  
                    //return $data['tr_datetime'];
                    return $data['username'].'<br>'.Yii::$app->formatter->format(strtotime($data['tr_datetime']), 'datetime');
                  
                },                
                
                'width'=>'160px',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],                
            /*
            [            
                'attribute'=>'tr_datetime',
                'label'=>'วันที่/เวลา',
                'format' => 'raw',                
                'value' => function ($data) {  
                    //return $data['tr_datetime'];
                    return Yii::$app->formatter->format(strtotime($data['tr_datetime']), 'datetime');
                  
                },                
                'width'=>'160px',
            ],
            */                 
            [            
                'attribute'=>'status',
                'width'=>'10px',          
                'value' => function ($data) {  
                    //return $data['tr_datetime'];
                    return $data['status']=='N'?'NEW':'CLOSE';
                  
                },       
                
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],    
            [
                'attribute'=>'status',
                'format' => 'raw', 

                'value' => function ( $model) use ($order_no,$item_number) {

                    if ($model['status']=='A'){
                        return '';
                    } else {                         
                        return Html::a('<span class="label label-primary">Close</span>', 
                            Yii::$app->urlManager->createUrl(                                            
                                [
                                    Yii::$app->controller->id.'/approvenote',
                                    'id'        => $model['id'],
                                    'order_no'  => $order_no,
                                    'item_no'   => $item_number,
                                ]                      
                            )
                        );
                    }
                    
                   
                },
                'header' => '.',
                'width'=>'10px',
                'headerOptions' => ['class' => 'text-center'],                    
            ],
            
            [
                'label'=>'All Order',
                'format' => 'raw',   
                'value' => function ($data) {                      
                    return ($data['order_no'] == '*') && ($data['item_no'] == '*')  ? '<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>':'';                  
                },                                
                'width'=>'10px',        
                'contentOptions' => ['class' => 'text-center'],            
                'headerOptions' => ['class' => 'text-center'],                        
            ],              
            

        ]
        /*
        'columns'=>[
            
                

            [
                'attribute'=>'Item_Number',
                'format' => 'raw',                
                'value' => function ($data) {
  
                    return Html::a($data['Item_Number'], ['/prod/view', 
                        'order_no' => $data['Order_No'],
                        'item_number' => $data['Item_Number'],
                        
                    ]);
                },
                
                
            ],                 
                
            
            'Order_Qty',
            'priority.refname',
            'status.refname',
            //'Jst_Name',
            'Due_Date:date',
            'Order_No',
            'prod.Order_Date:date',
        ]
        */

    ]); ?>


    <?php $form = ActiveForm::begin([        
        'action' => Url::to([Yii::$app->controller->id.'/updatenote',
            'id'=>$modeld1->id
        ]),
        'type' => ActiveForm::TYPE_INLINE,
 //       'layout' => 'horizontal',
        


    ]); ?>
    <?= $form->field($modeld1, 'order_no')->hiddenInput(['value' => $modeld1->order_no])->label(false);?>
    <?= $form->field($modeld1, 'item_no')->hiddenInput(['value' => $modeld1->item_no])->label(false);?>
    <?= $form->field($modeld1, 'component')->hiddenInput(['value' => $modeld1->component])->label(false);?>
    <?= $form->field($modeld1, 'username')->hiddenInput(['value' => $modeld1->username])->label(false);?>
    <?php // = $form->field($modeld1, 'tr_datetime')->hiddenInput(['value' => $modeld1->tr_datetime])->label(false);?>    
                                

    

<!--
    < ? = $form->field($modeld1, 'note')->textInput(['style'=>'width:500px']) ?>
-->
    <?= $form->field($modeld1, 'note')->textarea(['rows' => 6,'style'=>'width:500px']) ?>
    <?= $form->field($modeld1, 'allorder')->checkbox()->label('All Order'); ?>
    
    

    <div class="form-group">
        <?= Html::submitButton($modeld1->isNewRecord ? 'Create' : 'Update', ['class' => $modeld1->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

* <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> : All Order No.


<?php 

    // if (rtrim($item_number)=='*'){
        ?>
        <h4><span class="label label-default">Component : <?=$modeld1->component?></span></h4>
        <?=GridView::widget([       
            'dataProvider' => $itemProvider,
            'responsiveWrap'=>false,
            'columns'=>[
                [
                    'header'=>'Item Code',
                    'attribute'=>'item_number',
                ],
                [
                    'header'=>'Name',
                    'attribute'=>'item_name',
                ],
                [
                    'header'=>'Customer',
                    'attribute'=>'cust_name',
                ],
                [
                    'header'=>'Order No.',
                    'attribute'=>'order_no',
                ]

            ]
        ]);?>  
        <?php
    // }
?>