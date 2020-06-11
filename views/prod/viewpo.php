<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use kartik\grid\GridView;
use yii\data\ArrayDataProvider;


/* @var $this yii\web\View */
/* @var $model app\models\Pr */

$this->title = 'PO. NO. : '.$model->Order_Number;
$this->params['breadcrumbs'][] = ['label' => 'PLP', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="po-view">

    <h1><?= Html::encode($this->title) ?></h1>

 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

         
          
            'Order_date:date',
            'Pr_Number',
            //'DivisionCode',
            //'DeptCode',
            //'Supp_Number',            

            [
                'attribute'=>'supplier.Supp_Name',
                'label'=>'ผู้จำหน่าย',
            ],
            //--'Buyer'
        ],
    ]) ?>

    <?php
    //print_r($model->detail);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $model->detail,
        ]);   
    ?>

    <?= GridView::widget([
        //'dataProvider' => $model->detail,
        
        
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'CompanyCode',
            //'PR_Number',
            //'Seq_Number',
            'Item_Number',
            'PurDet_Desc',            
            [
                'attribute'=>'Uom',                               
                'width'=>'100px',                
            ],              

            
         
            [
                'attribute'=>'Order_Qty',                
                'format' => ['decimal',2],                
                'contentOptions' => ['align' => 'right' ],
                'width'=>'150px',     
            ],              
            [
                'attribute'=>'Due_Date',                                
                'format' => 'date',                
                'width'=>'100px',                
                
            ],  
            
            

  
             //'Rlse_Date',
             //'Price',           
            
             //'Rlse_Qty',
             //'Recd_Qty',
             //'Type_Desc',
             
             //'PO_Issue',
            // 'score',
            // 'revdte1',
            // 'revdte2',

 
        ],
    ]); ?>    

</div>
