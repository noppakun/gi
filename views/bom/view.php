<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\Bom */

$this->title = $item_number;
$this->params['breadcrumbs'][] = ['label' => (Yii::$app->controller->id == 'bom-temp'?"BomsTemp":"Boms"), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="bom-view">
            
            <h1><?= Html::encode($this->title) ?></h1>
        
    
    <div class="row">
   
        <div class="col-md-6">
            <!-- <h4>    
            <?php
            if ((Yii::$app->controller->id != 'bom-temp') and ($type_invent_code=='01')){                
                echo "( Batch Size : 100 kg. )";
            }        
            ?> -->
            </h4>    
            <h4>                
                <?=((Yii::$app->controller->id !== 'bom-temp') ?"( Batch Size : 100 kg. )":"")?>                
            </h4>    
        </div>
        <div class="col-md-6 text-right">            
            <?= Html::a('<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export ( XLS )', ['tospreadsheet','id'=>$item_number], ['class' => 'btn btn-success']) ?>              
        </div>
    </div>
    



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showPageSummary'=>true,
        'responsiveWrap' => false,
        // 'panel'=>[
        //     'type'=>GridView::TYPE_DEFAULT ,
        //     'heading'=>'Bom',

        // ],

        // 'export'=>[
        //     'target'=>GridView::TARGET_BLANK
        // ],
        // 'exportConfig' => [
        //     GridView::EXCEL => ['filename' => 'bom_raw'],              

        // ],       
       
        'columns' => [
            
            [
                'class' => 'kartik\grid\SerialColumn',
                'header' => '<center>#</center>',
                'contentOptions' => ['align' => 'center'],
              
                
                
            ],
            
            
            [
                'attribute'=>'component',
                'header' => 'Code',
                
               
            ],
            [
                'attribute'=>'item_name',
                'header' => 'Raw Material',
                
                'pageSummary'=>'<div align = right>Total (100 kg.)</div>',
            ],
            [
                'attribute'=>'lastprice',                
                'header' => '<center>ราคา (R/M)</center>',
                'format' => ['decimal',2],
                'contentOptions' => ['align' => 'right'],
                                  
            ],           
            [
                'attribute'=>'qty',                
                'header' => '<center>w/w</center>',
                'format' => ['decimal',3],  
                'contentOptions' => ['align' => 'right'],
                'hAlign'=>'right',
                'pageSummary'=>true,
                
                
                
            ],                                                            
            [
                'attribute'=>'cost',
                'header' => '<center>Cost</center>',
                'format' => ['decimal',3],  
                'contentOptions' => ['align' => 'right'],
                'hAlign'=>'right',
                'pageSummary'=>true,
                
            ],                                                            

            [
                'attribute'=>'order_date',
                'header' => '<center>วันที่สั่งซื้อล่าสุด</center>', 
                'contentOptions' => ['align' => 'center'],
                'content' => function ($model) {           
                    return $model['order_date'] == null  ? '-': date("d-m-Y",strtotime($model['order_date']));                    
                },                  
            ],                                                            

            [
                'attribute'=>'order_qty',
                'header' => '<center>จำนวนสั่งซื้อ<br>ล่าสุด</center>',
                'contentOptions' => ['align' => 'right'],                
                'content' => function ($model) {           
                    return $model['order_qty'] == 0 ? '-': number_format($model['order_qty'],2);                    
                },                  
                          
            ],      
            [
                'attribute'=>'leadtime',
                'header' => '<center>Lead Time (วัน)</center>',
                'format' => ['decimal'],  
                'contentOptions' => ['align' => 'center'],
                'content' => function ($model) {           
                    return $model['leadtime'] == 0 ? '-': number_format($model['leadtime'],0);                    
                },                  
                
                
            ],  
            
            [
                'attribute'=>'qtyonhand',
                'header' => '<center>จำนวนคงเหลือ</center>',
                'contentOptions' => ['align' => 'right'],                
                'content' => function ($model) {           
                    return $model['qtyonhand'] == 0 ? '-': number_format($model['qtyonhand'],2);                    
                },                                            
            ],
            [
                'attribute'=>'qtyquarantine',
                'header' => '<center>Quarantine</center>',
                'contentOptions' => ['align' => 'right'],                
                'content' => function ($model) {           
                    return $model['qtyquarantine'] == 0 ? '-': number_format($model['qtyquarantine'],2);                    
                },                                            
            ],
            [
                'attribute'=>'qtyreserved',
                'header' => '<center>Reserved</center>',
                'contentOptions' => ['align' => 'right'],                
                'content' => function ($model) {           
                    return $model['qtyreserved'] == 0 ? '-': number_format($model['qtyreserved'],2);                    
                },                                            
            ],
 
                             
            
        ]        

    ]); ?>

</div>



<ul class="list-inline">
  <li>*ราคา (R/M) : จากการรับเข้าล่าสุด หรือจากการสั่งซื้อล่าสุด</li>
  <li>*Reserved : จำนวนที่ยังไม่ได้เบิกเพื่อการผลิต จากใบสั่งผลิต</li>
</ul>