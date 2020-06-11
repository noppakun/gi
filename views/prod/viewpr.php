<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use kartik\grid\GridView;
use yii\data\ArrayDataProvider;


/* @var $this yii\web\View */
/* @var $model app\models\Pr */

$this->title = 'PR. NO. : '.$model->PR_Number;
$this->params['breadcrumbs'][] = ['label' => 'PLP', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pr-view">

    <h1><?= Html::encode($this->title) ?></h1>

 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'Companycode',
            //'PR_Number',
            'Order_Date:date',
            //'Supp_Number',
            //'Quote',
            'Shipto_Addr1',
            //'Shipto_Addr2',
            //'Currency_Type',
            'Remarks',
            'Remarks2',
            'Remarks3',
            
            //'Buyers',
            //'Terms',
            //'PO_Issue',
            //'Open_Close',
            //'DeptCode',
            //'DivisionCode',
            'UserName',
            'LastUpdate:date',
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
            'PRDet_Desc',            
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
            
            

            [
                'attribute'=>'PO_Qty',                
                'format' => ['decimal',2],                
                'width'=>'150px',     
                'contentOptions' => ['align' => 'right' ],
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
