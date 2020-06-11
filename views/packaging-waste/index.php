<?php
/* @var $this yii\web\View */
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
//HighchartsAsset::register($this)->withScripts(['highstock', 'modules/exporting', 'modules/drilldown']);
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use app\widgets\ddlYear;
use yii\helpers\Html;
 



$this->title = Yii::$app->controller->id == 'rawmaterial-waste' ? 'Raw Material Waste':'Packaging Waste';
$this->params['breadcrumbs'][] = $this->title;






$form = ActiveForm::begin([
    'method' => 'get',
    'layout' => 'horizontal',
 
    'options' => [
        'class' => 'well',
    ],
]);
?>
<div class="row">
<div class="col col-md-3">
    <?=ddlYear::widget(['form'=>$form,'model' => $SelectForm,'field'=>'year'  ]);?>
</div>
<div class="col col-md-3">
    <?=ddlYear::widget(['form'=>$form,'model' => $SelectForm,'field'=>'year2'  ]);?>
</div>
<div class="col col-md-3">
    <?=Html::submitButton('Process', ['class' => 'btn btn-primary']);?>
</div>

</div>
<?php 

$form::end();

$hcdata['name']=[];
$hcdata['percent']=[];
 
//$hcdata['name'] = array_column($rows, 'product_desc');
//$hcdata['percent'] = array_column($rows, 'waste_percent');
foreach($rows   as   $row){
    //$hcdata['percent'] = array_column($rows, 'waste_percent');
    array_push($hcdata['name'],$row['product_desc'].'-'.$row['group_product_desc']); 
    array_push($hcdata['percent'],round(($row['waste_percent']*100),2)); 
} 

// echo '<br><br><pre>';
//  //print_r($hcdata['capacity_percent_by_recv']);
//  print_r($hcdata);
//  echo '</pre>';
 
?>
<div class="panel  panel-default">
    <div class="panel-body">
    <?=Highcharts::widget([
    'options' => [

        'credits' => ['enabled' => false],
            'colors'=> ['#2b908f', '#90ee7e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066',
                        '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],

            
            
        
            'chart'=> [
                'type'=> 'column',                       
                'options3d'=>[
                    'enabled'=> true,
                    'alpha'=> 15,
                    'beta'=> 15,
                    'depth'=> 50,                
                    'viewDistance'=> 25,
            
                ],
            ],
            'title'=> [
                'text'=> $this->title,

            ],
            'subtitle'=>[
                'text'=> $SelectForm->year.' - '.$SelectForm->year2
            ],         
            'xAxis'=> [
                'categories'=> $hcdata['name'],
            ],
    
        
            'plotOptions'=>[
                'column'=>[
                    'depth'=> 25,
                ],
            ],
            'series'=> [
    
                [
                    'name'=> '%Waste',
                    'data'=> $hcdata['percent'],

                ],
            
            ]
            
        ]
    ]);?>
    </div>
</div>
<?php
 $gridColumns=[
    [
        'attribute'=>'group_product_desc',
        'label'=>'Group',
        'group'=>true,
        //'groupedRow'=>true,
    ],        
    [
        'attribute'=>'product_desc',
        'label'=>'Product',
    ],                
    [
        'attribute'=>'qtyRlse',
        //'label'=>'Product',
        'format' => ['decimal',0],                          
        'hAlign'=>'right',            
    ],         
    [
        'attribute'=>'Issue_Qty',
        //'label'=>'Product',
        'format' => ['decimal',0],                          
        'hAlign'=>'right',            
    ],         
    [
        'attribute'=>'waste_percent',
        'label'=>'%Waste    ',
        'format' => ['percent',2],                          
        'hAlign'=>'right',
        //.text-success


        // 8/8/2018  remark by k.Viroje
        'contentOptions' => function ($model){                
            return [ 'class' => ($model['waste_percent'] > 0 ? 'text-danger':'text-success')]; 
        },

                       
        
    ], 

];
?>
<div class="row">
    <div class="col-md-12">
    
    
        <span class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export ( XLS )', ['waste2xls','year'=>$SelectForm->year,'year2'=>$SelectForm->year2], ['class' => 'btn btn-success']) ?>       
            <?= Html::a('<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export ( Summary, XLS )', ['waste2xlstype2','year'=>$SelectForm->year,'year2'=>$SelectForm->year2], ['class' => 'btn btn-success']) ?>       
        </span>
    </div> 
</div>
<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'responsiveWrap'=>false,
    'columns'=>$gridColumns,
]); 

?>
           

 
