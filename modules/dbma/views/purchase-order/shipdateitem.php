<?php

use yii\helpers\Html;

use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
//use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'PO. Ship date items. (เฉพาะสินค้าที่ไม่เคยรับเข้า Stock)';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-shipdateitem">

    <h1><?= Html::encode($this->title)?></h1>
<!--    
    <h5>BETA</h5>
-->    
    


    <?php
        $form = ActiveForm::begin([
            'method' => 'get',                        
            'options' => [
                'class' => 'well',
            ],                                    
        ]);
    ?>
    <div class="form-group">    
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-5">
 

            <?=
                $form->field($SelectForm, 'date')->widget(DatePicker::className(),[
                    'type' => DatePicker::TYPE_INPUT,
                    'removeButton' => ['icon' => 'trash'],
                    'pickerButton' => false,
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ])                
            ?>             
        </div>            
        <div class="col-md-2 col-sm-2 col-xs-5">    

            <?=
                $form->field($SelectForm, 'date2')->widget(DatePicker::className(),[
                    'type' => DatePicker::TYPE_INPUT,
                    'removeButton' => ['icon' => 'trash'],
                    'pickerButton' => false,
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ])                
            ?>     
 
        </div>        
    </div>
    <div class="row">    
        <div class="col-md-2 col-sm-2  col-xs-2">      
            
            <?=Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>
            
        </div>              
    
    </div>    
    </div>


    <?php        
    ActiveForm::end();

      
        $columns=[
            [
                'attribute'=>'Order_Number',
                'label'=>'PO.NO.',
                'contentOptions' => ['width'=>120],                
            ],
            
            [
                'attribute'=>'po.Order_date',
                'label'=>'PO.Date',
                'format'=>'date',
                'contentOptions' => ['width'=>100],                
            ],
            [
                'attribute'=>'po.supplier.Supp_Name',
                'label'=>'Supplier',
                
                'contentOptions' => ['width'=>250],                
            ],
                        
            [
                'attribute'=>'Item_Number',
                'label'=>'Item No.',                
                'contentOptions' => ['width'=>100],                
            ],
            [
                'attribute'=>'PurDet_Desc',
                'label'=>'Description',
            ],
            [
                'attribute'=>'Order_Qty',
                'label'=>'Qty.',
                'format'=>['decimal',2],
                'hAlign'=>'right',
                'contentOptions' => ['width'=>100],                
            ],
            [
                'attribute'=>'Due_Date',
                'label'=>'Ship Date',
                'format'=>'date',
                'contentOptions' => ['width'=>100],                
            ],
        ]        
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns'=>$columns,
     
    ]); ?>

</div>
