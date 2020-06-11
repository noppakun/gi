 
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use yii\widgets\ActiveForm;
use kartik\grid\GridView;
 
use app\widgets\ddlYear;


use app\widgets\se2Customer;


 
$this->title = ($trtype=='IV') ?'Salesinfo (Qty)':'Sales Order (Qty)';
$this->params['breadcrumbs'][] = $this->title;
 
 
 
 
 
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
    <div class="col-md-2">
        <?=ddlYear::widget(['form'=>$form,'model' => $SelectForm,'field'=>'year']);   ?>
    </div>
    <div class="col-md-2">
        <?=ddlYear::widget(['form'=>$form,'model' => $SelectForm,'field'=>'year2'])  ?>
    </div>    
    <div class="col-md-8" >
        <?=se2Customer::widget(['form'=>$form,'model' => $SelectForm,'field'=>'cust_no','selectAll'=>false]);   ?>
    </div>

</div>
<div class="row">
 

  
</div>
<div class="row">
 
    <div class="col-md-12 text-right">
        <?=Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>                            
    <?= Html::a('<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export ( XLS )', 
            [
                //'qty2spreadsheet', 
                 
                ($trtype=='IV') ?'qty2spreadsheet':'salesorderqty2spreadsheet',

                    'year'=>$SelectForm->year,
                    'year2'=>$SelectForm->year2,                
                    'cust_no'=>$SelectForm->cust_no,
            ], 
            ['class' => 'btn btn-success']) ?>
    </div>        
    

</div>
<?php
$form::end(); 
//  BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBb     select form    
?> 


 

    <?= GridView::widget([
        'dataProvider' => $dataProvider,        
     
        'responsiveWrap' => false,
        'headerRowOptions' => ['class' => 'success'],
        'floatHeader'=>true,                  
        'showPageSummary' => true,
        'layout'=>'{summary}{items}{pager}',
        // 'pageSummaryRowOptions' => [
        //     'class' => 'infomation',          
        // ],

  

    ]); ?>
 