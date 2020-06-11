<style>
    .clHead  {color: black; background-color:#DEE0FF} 
    .clGreen  {color: black; background-color:#DEFFED}           
    .clYellor  {color: black; background-color:#FFFDDE} 
    .clRed  {color: black; background-color:#FFDEF0} 
    .cllYellor  {color: black; background-color:#FFFFED} 
</style>

<?php


use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use app\models\JobProductCostQList ;


$this->title = 'ข้อมูล Job Cost การผลิต';
$this->params['breadcrumbs'][] = $this->title;


?>


<?php


  
/*****************************************************************************************
    Header
*****************************************************************************************/

?>
    <div class="btn-lg" align="right">    
        <?= \yii\helpers\Html::a( '<span class="glyphicon glyphicon-chevron-left"></span> Back', Yii::$app->request->referrer)?>        
    </div>     
    
    <div class="container-fluid">
       
    <?= DetailView::widget([
        'model' => $rWPlanDet,
   
        'attributes' => [
            'JobNo',
            'Order_No:text:Lot No.',
            [
                'label'=>'ผลิตภัณฑ์',
                'attribute'=>'Item_Number',
                'value'=>$rWPlanDet['Item_Number'].' - '.$rWPlanDet['Item_Name'],            
            ],
            [
                'label'=>'ขนาดบรรจุ',
                'attribute'=>'PackSize',
                'value'=>$rWPlanDet['PackSize'].' '.$rWPlanDet['Job_QtyFixedCostUom'],
                //'format' => ['decimal',2],            
            ],          
            
            [
                'label'=>'จำนวนที่สั่งผลิต',
                'attribute'=>'JobQty',
                'format' => ['decimal',2],           
            ],
            [
                'label'=>'จำนวนที่ผลิตได้',
                'attribute'=>'Rlse_Qty',
                'format' => ['decimal',2],            
            ],
            [
                'label'=>'ต้นทุนต่อหน่วย (database)',
                'attribute'=>'UnitPriceDatabase',
                //'value'=>$itemloc->UnitPrice,
                'format' => ['decimal',2],
                           
                 
                
            ],                                                   
            [
                'label'=>'ต้นทุนต่อหน่วย ( ไม่รวมค่าโสหุ้ยคงที่ )',
                'attribute'=>'UnitPriceNoFix',
                //'value'=>$itemloc->UnitPrice,
                'format' => ['decimal',2],
                           
                 
                
            ],                                                   
            
       
        ],
        
    ]) ?>


<?php
/*****************************************************************************************
    Detail
*****************************************************************************************/
?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'headerRowOptions' => ['class' => 'clHead'],
        //'showPageSummary'=>true,
        'responsiveWrap'=>false,




        'columns'=>[ 
  
    // ----------------------------------------------
    // ----------------------------------------------
    // ----------------------------------------------
  
              [
                
                'class'=>'kartik\grid\ExpandRowColumn',
                'width'=>'50px',
                'value'=>function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'=>function ($model, $key, $index, $column) use ($paraItem){

                    $JobProductCostItem = new JobProductCostQList();
                    $paraItem['StCardINO']=$model['Item_Number'];
                    $rows  = $JobProductCostItem->QueryItems(
                            $paraItem['Order_Number'],
                            $paraItem['Item_Number'],
                            $paraItem['JobNo'],
                            $paraItem['StCardINO']
                    );
                    $dataProvider=new ArrayDataProvider( [
                        'allModels' => $rows,
                        'pagination'=>[
                            'pageSize'=>50,
                        ],
                    ]);                
                    return Yii::$app->controller->renderPartial('viewitem',[
                      'dataProvider' => $dataProvider,
                      'showAna'=>1,
                      'paraItem'=>$paraItem,
                    ]);        
                },

                //'headerOptions'=>['class'=>'kartik-sheet-style'] 
                'expandOneOnly'=>true,

            ],  
			/*
[

                'content'=>function ($model, $key, $index, $widget)  use ($paraItem) { 
                     $paraItem['StCardINO']=$model['Item_Number'];
                    return                       
                     $paraItem['Order_Number'].
                      $paraItem['Item_Number'].
                      $paraItem['JobNo'].
                      $paraItem['StCardINO'];
                },                
    
    
],
              */          
    // ----------------------------------------------
    // ----------------------------------------------
    // ----------------------------------------------       
  
  
            [                
                'attribute'=>'Type_Invent_Desc',
                'value'=>function ($model, $key, $index, $widget) { 
                    return 'กลุ่มสินค้า : '.$model['Type_Invent_Desc'];                    
                },                
                'group'=>true,  // enable grouping,  
                'groupedRow'=>true,
            ],
            [
                
                'attribute'=>'Item_Number',
                'label'=>'รหัสสินค้า',
                'content'=>function ($model, $key, $index, $column) use ($paraItem) {
                    if (
                        (($model['Type_Invent_Code'] =='03') and (substr($model['Item_Number'],0,1)=='C'))
                            and ($model['calFixedCost'] != null)
                        ){
                        $ret = Html::a($model['Item_Number'], ['/jobproductcost/view', 
                                        'Order_Number' => $paraItem['Order_Number'],
                                        'Item_Number' => $model['Item_Number'],
                                        'JobNo' => $paraItem['JobNo'],                        
                                    ]);

                    }else {
                        $ret= $model['Item_Number'];
                    }
                    return  $ret;
                }

                


            ],
            'Item_Name:text:ชื่อสินค้า',
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
                
                
            ],            
            [
                'label'=>'ต้นทุนรวม',
                'attribute'=>'SumPrice',

                'format' => ['decimal',2],
                'contentOptions' => ['align' => 'right' ],
                'hAlign'=>'right',     
                
                                           
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
/*****************************************************************************************
    Footer
*****************************************************************************************/
?>
    <?= GridView::widget([
        'dataProvider' => $rfooter,    
        'showPageSummary'=>true, 
        'responsiveWrap'=>false,
        'layout'=>"{items}",
                'rowOptions' => function ($model, $index, $widget, $grid){
                    if($model['id'] == 3){
                        return [];
                        //return ['class' => 'danger'];
                    }else{
                        return [];
                    }
                },
        

                        
        
        'columns' => [
            
            [
                'label'=>'',
                'attribute'=>'note',                
                                
                           
            ],            
            [
                'label'=>'',
                'attribute'=>'manhour',                
                'value'=> function ($model){                    
                    return ($model['manhour'] ==0 ) ?'':number_format($model['manhour']+0,2).' '.$model['unit'];
                },                
                'contentOptions' => ['align' => 'right' ],
                  
                                               
            ],                                     
            [
                'label'=>'อัตรา',
                'attribute'=>'rate',
                'value'=> function ($model){                    
                    return ($model['rate'] ==0 ) ?'':number_format($model['rate']+0,($model['id'] ==4 )?3:2);
                },
                'hAlign'=>'right',
                'contentOptions' => ['align' => 'right' ],
                'pageSummary'=>'<div align="right">ต้นทุนรวม<br>ต้นทุนต่อหน่วย<br>ต้นทุนรวมไม่รวมค่าโสหุ้ยคงที่<br>ต้นทุนต่อหน่วย</div>',       
                                
            ],             
            [
                'label'=>'รวม',
                'attribute'=>'amt',
                'format' => ['decimal',2],
                'contentOptions' => ['align' => 'right' ],  
                'hAlign'=>'right',             
                //'pageSummary'=>true,
                'pageSummary'=>function ($model) use ($rWPlanDet) {
                    return 
                        number_format($rWPlanDet['TotPrice'],2).'<br>'.
                        number_format($rWPlanDet['UnitPriceDatabase'],2).'<br>'.
                        number_format($rWPlanDet['TotPriceNoFix'],2).'<br>'.
                        number_format($rWPlanDet['UnitPriceNoFix'],2);                        
                    
                },              
            ]
        ],        
        
    ]); ?>
    * ค่าโสหุ้ยคงที่ { Fixed Overhead } { ค่าใช้จ่ายในการผลิต-คงที่ }  :  ค่าใช้จ่ายในการผลิตที่ไม่ได้เกี่ยวข้องกับการผลิตโดยตรง หรือไม่สามารถระบุ/ชี้ชัดได้ว่า เป็นค่าใช้จ่ายของหน่วยงานใด หรือ ไม่ได้ผันแปรกับจำนวน/ปริมาณ/เวลาในการผลิต

    <div class="btn-lg" align="right">    
        <?= \yii\helpers\Html::a( '<span class="glyphicon glyphicon-chevron-left"></span> Back', Yii::$app->request->referrer)?>        
    </div>     
<?php

//echo \yii\helpers\Html::a( 'Back', Yii::$app->request->referrer);    
//   <?= Html::a('Back', ['/controller/action'], ['class'=>'btn btn-primary']) 
//use yii\web\Request;
//return $this->redirect(Yii::$app->request->referrer);
//echo $this->redirect(\Yii::$app->request->referrer);
//$connection = \Yii::$app->erpdb;
?>  

</div> 
