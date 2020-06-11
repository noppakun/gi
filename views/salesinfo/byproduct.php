<style>
    .container {width:1300px}
</style>


<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;

use app\widgets\ddlYear;
use app\components\XLib;
use app\models\Appvar;



$this->title = 'Salesinfo By Product';
$this->params['breadcrumbs'][] = $this->title;

$appvar = Appvar::find()
    ->where(['app_key' => 'salesinfo',
            'app_value' => 'run'])->one();





$form = ActiveForm::begin([
    'method' => 'get',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-2',
            'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-2'
        ]
    ],
    'options' => [
        'class' => 'well',
    ],
]);

echo ddlYear::widget(['form'=>$form,'model' => $SelectForm,'field'=>'year','options'=>['onchange'=>'this.form.submit()'] ]);

// echo Html::submitButton('Process', ['class' => 'btn btn-primary']);



$form::end();


// echo '<pre>';
// print_r($dataProvider);
// echo '</pre>';
 

function amtqty($amt,$qty){
    return '<span style="color:blue">'.xlib::number_format_text($amt).'</span><br><i>'.xlib::number_format_text($qty).'</i>';    
}

?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary'=>true,
        'responsiveWrap' => false,
        'columns' => [
            [
                'attribute'=>'Item_Number', 
                //'header'=>'Code',
                
                
                'contentOptions' => ['style' => 'width:120px;'],
            ],

            [
                'attribute'=>'Item_Name', 
                //'header'=>'Name',
                'pageSummary'=>'Total',
                //'width'=>'560',
                
            ],            
            [
                'attribute'=>'totalamt', 
                'format' => ['decimal',0],              
                'header'=>'Total<br><span style="color:blue">Amt.</span><br><i>Qty.</i>',
                'hAlign'=>'right',
                'pageSummary'=>true,                
                
                'content'=>function ($model) {return amtqty($model['totalamt'],$model['totalqty']);}                
            ],
  
 

 
 
            ['attribute'=>'amt1',  'format' => ['decimal',0],'header'=>'Jan.','hAlign'=>'right','pageSummary'=>true,                
                'content'=>function ($model) {return amtqty($model['amt1'],$model['qty1']);}],                
            ['attribute'=>'amt2',  'format' => ['decimal',0],'header'=>'Feb.','hAlign'=>'right','pageSummary'=>true,
                'content'=>function ($model) {return amtqty($model['amt2'],$model['qty2']);}],                
            ['attribute'=>'amt3',  'format' => ['decimal',0],'header'=>'Mar.','hAlign'=>'right','pageSummary'=>true,
                'content'=>function ($model) {return amtqty($model['amt3'],$model['qty3']);}],                
            ['attribute'=>'amt4',  'format' => ['decimal',0],'header'=>'Apr.','hAlign'=>'right','pageSummary'=>true,
                'content'=>function ($model) {return amtqty($model['amt4'],$model['qty4']);}],                
            ['attribute'=>'amt5',  'format' => ['decimal',0],'header'=>'May.','hAlign'=>'right','pageSummary'=>true,
                'content'=>function ($model) {return amtqty($model['amt5'],$model['qty5']);}],                
            ['attribute'=>'amt6',  'format' => ['decimal',0],'header'=>'Jun.','hAlign'=>'right','pageSummary'=>true,
                'content'=>function ($model) {return amtqty($model['amt6'],$model['qty6']);}],                
            ['attribute'=>'amt7',  'format' => ['decimal',0],'header'=>'Jul.','hAlign'=>'right','pageSummary'=>true,
                'content'=>function ($model) {return amtqty($model['amt7'],$model['qty7']);}],                
            ['attribute'=>'amt8',  'format' => ['decimal',0],'header'=>'Aug.','hAlign'=>'right','pageSummary'=>true,
                'content'=>function ($model) {return amtqty($model['amt8'],$model['qty8']);}],                
            ['attribute'=>'amt9',  'format' => ['decimal',0],'header'=>'Sep.','hAlign'=>'right','pageSummary'=>true,
                'content'=>function ($model) {return amtqty($model['amt9'],$model['qty9']);}],                
            ['attribute'=>'amt10', 'format' => ['decimal',0],'header'=>'Oct.','hAlign'=>'right','pageSummary'=>true,
                'content'=>function ($model) {return amtqty($model['amt10'],$model['qty10']);}],                
            ['attribute'=>'amt11', 'format' => ['decimal',0],'header'=>'Nov.','hAlign'=>'right','pageSummary'=>true,
                'content'=>function ($model) {return amtqty($model['amt11'],$model['qty11']);}],                
            ['attribute'=>'amt12', 'format' => ['decimal',0],'header'=>'Dec.','hAlign'=>'right','pageSummary'=>true,
                'content'=>function ($model) {return amtqty($model['amt12'],$model['qty12']);}],                
                
        ],


    ]); ?>
 
    <div class="col-md-6">
                <?= Html::a('Update Data', ['update'], ['class' => 'btn btn-success']) ?>
                <span class="label label-primary">last update :  <?=date("d-m-Y  /  H:i:s",strtotime($appvar->lastupdate)); ?>
                </span>
    </div>    
 
