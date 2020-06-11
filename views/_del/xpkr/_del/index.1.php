
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$BD_O = \Yii::$app->user->can('/@XPDR/BD-O');
$BD_M = \Yii::$app->user->can('/@XPDR/BD-M');
$RD_O = \Yii::$app->user->can('/@XPDR/RD-O');
$RD_M = \Yii::$app->user->can('/@XPDR/RD-M');

//  $BD_O = (1==0);
//  $BD_M = (1==0);
//  $RD_O = (1==1);
//  $RD_M = (1==1);


$this->title = $TABLECAPTION;
$this->params['breadcrumbs'][] = $this->title
    .' ( '
    .($BD_O?"BD_O ":' ')
    .($BD_M?"BD_M ":' ')
    .($RD_O?"RD_O ":' ')
    .($RD_M?"RD_M ":' ').' )';
 
?>
 
<?php
//  AAAAAAAAAAAAAAAAAAAAAAAAAAAA      select form
$form = ActiveForm::begin([ 
    'method' => 'get',
    //'layout' => 'horizontal',
    'options' => [
        'class' => 'well',
    ],
]);
?>

 
<div class="row">
    <!-- <div class="col-md-2">        
        ?=$form->field($SelectForm, 'checkbox')->checkbox()->label('New');?>                         
    </div>
    <div class="col-md-2">        
        ?=$form->field($SelectForm, 'checkbox2')->checkbox()->label('BD Approved');?>                 
    </div>
    <div class="col-md-2">        
        ?=$form->field($SelectForm, 'checkbox3')->checkbox()->label('RD Approved');?>         
    </div> -->
    <div class="col-md-6">        
        <?=$form->field($SelectForm, 'checkbox')->checkboxList(
            [
                'N'=>'New',
                'B'=>'BD Approved',
                'R'=>'RD Approved',
            ],
            ['inline'=>true]            
        )->label(false);?>                 
    </div>

    <div class="col-md-6  text-right">
        <?=Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>                            
    </div>    
 

</div>
<?php
$form::end(); 
//  BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBb     select form    
?> 
 <div class="etable-index">
 
 <?= GridView::widget([
     'dataProvider' => $dataProvider,
     'filterModel' => $searchModel,
     'responsiveWrap' => false,        
     //'autoXlFormat'=>false,
     'options' => [
         'class' => 'YourCustomTableClass',
      ],        
   
     'columns' => [
         [
             'header' => ($BD_O or $BD_M) ? Html::a(
                 '<i class="glyphicon glyphicon-plus"></i>',
                 [Yii::$app->controller->id.'/create'],
                 ['title'=>'เพิ่ม']
             ) : '#', 

             'class' => 'kartik\grid\SerialColumn',
             'headerOptions' => ['align'=>'center'],
             'contentOptions' => ['align'=>'center'],                                             
         ],

         
         [
             'attribute'=>'doc_no',
             'content'=>function ($model, $key, $index, $column) {                                        
                 return Html::a($model->doc_no,['update','id'=>$model->id]);                
             }
         ],
         'doc_date',
         'cust_name',
         'product_name',       
         'user_approve',
         'manager_approve',         
         [
             'label'=>'BD',
             'content'=>function ($model, $key, $index, $column) {                                           
                 return $model->user_approve==null ? '':'<span style="color:green"><i class="glyphicon glyphicon-ok"></i></span>';
             },
             'hAlign'=>'center',
         ],
         [
             'label'=>'RD',
             'content'=>function ($model, $key, $index, $column) {    
                 return $model->manager_approve==null ? '':'<span style="color:green"><i class="glyphicon glyphicon-ok"></i></span>';
             },
             'hAlign'=>'center',
         ],

            //'product_name',
            //'product_cat',
            //'product_cat_other',
            //'bulk',
            //'benchmark',
            //'target_group',
            //'size',
            //'size_unit',
            //'first_order',
            //'first_order_unit',
            //'total_order',
            //'total_order_unit',
            //'artwork_design',
            //'other_detail',
            //'other_detail_other',
            //'present_req_date',
            //'price_req_date',
            //'user_inform',
            //'user_approve',
            //'user_approve_date',
            //'manager_accept',
            //'manager_remark',
            //'manager_approve',
            //'manager_approve_date',
     ],

 ]); 
 ?>

</div>
 
