<?php
/* @var $this yii\web\View */
use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use app\widgets\ddlYear;

$this->title = 'Machine Capacity';
$this->params['breadcrumbs'][] = $this->title;



$hcdata['machname']=[];
$hcdata['y_capacity']=[];
$hcdata['capacity_percent_by_recv']=[];

// echo '<pre>';
// print_r($rows);
// echo '</pre>';


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
$allcapacity_percent=0;

 
//$hcdata['capacity_percent_by_recv'] = array_column($rows, 'capacity_percent_by_recv');
foreach($rows   as   $row){
    array_push($hcdata['capacity_percent_by_recv'],$row['capacity_percent_by_recv']+0);
 
} 

//$hcdata['capacity_percent_by_recv'] = array_column($rows, 'capacity_percent_by_recv');

// echo '<br><br><pre>';
//  print_r($hcdata['capacity_percent_by_recv']);
//  echo '</pre>';

$hcdata['machname'] = array_column($rows, 'machname');
$hcdata['y_capacity'] = array_fill(0, count($rows), 100);


$allcapacity_percent =  array_sum(array_column($rows, 'capacity_percent_by_recv')) / count($rows);


// echo '<br><br><br>';
// echo $allcapacity_percent;
 
?>
<div class="panel  panel-default">
<div class="panel-body">
<?=Highcharts::widget([
   'options' => [

       
            'colors'=> ['#2b908f', '#90ee7e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066',
                        '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
 
            
           
       
        'chart'=> [
            'type'=> 'column',                        
            // 'options3d'=>[
            //     'enabled'=> true,
            //     'alpha'=> 15,
            //     'beta'=> 15,
            //     'viewDistance'=> 25,
            //     'depth'=> 40
            // ]
        ],
        'title'=> [
            'text'=> 'Machine Capacity '.$SelectForm->year
        ],
        'xAxis'=> [
            'categories'=> $hcdata['machname'],
        ],
 
        'legend'=> [
            'shadow'=> false
        ],
        'tooltip'=> [
            'shared'=> true
        ],
        'plotOptions'=> [
            'column'=> [
                'grouping'=> false,
                'shadow'=> false,
                'borderWidth'=> 0
            ]
        ],
        'series'=> [
            [
                'name'=> 'Capacity',
                'color'=> 'rgba(165,170,217,1)',                                
                'data'=> $hcdata['y_capacity'],
 
            ], [
                'name'=> '%Product',
                'color'=> 'rgba(126,86,134,.9)',
                'data'=> $hcdata['capacity_percent_by_recv'],
                'pointPadding'=> 0.2,

                //'pointPlacement'=> -0.2
            ],
            [
                
                'type'=> 'pie',
 

                'name'=> '%',
                'data'=> [
                    [
                        'name'=> 'active',
                        'y'=> $allcapacity_percent,                        
                        //'color'=> 'yellow' ,
                    ],
                    [
                        'name'=> 'idle',
                        'y'=> 100-$allcapacity_percent,                        
                        //'color'=> 'green' ,
                    ],

        
                    
                ],
                'center'=> [100, 0],
                'size'=> 80,
                'showInLegend'=> false,

                                
            ]
        ]
        
    ]
]);
?>
</div>
</div>
<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'responsiveWrap'=>false,
    'columns' => [
        [
            'attribute'=>'machcode',
            'label'=>'Mach.Code',
        ],
        [
            'attribute'=>'machname',
            'label'=>'Mach.Name',
        ],
        [
            'attribute'=>'y_capacity',
            'label'=>'Capacity/Year',
            'format' => ['decimal',0],                          
            'hAlign'=>'right',            
            
        ],      
        [
            'attribute'=>'recv_qty',
            'label'=>'Product',
            'format' => ['decimal',0],                          
            'hAlign'=>'right',            
        ],      
        [
            'attribute'=>'capacity_percent_by_recv',
            'label'=>'%Product',
            'format' => ['percent',2],                          
            'hAlign'=>'right',
            'value' => function ($model)  {
                return $model['capacity_percent_by_recv']/100;
            },                        
            
        ],      
        
        
        
    ]
    
    
]); 
?>
<?php

 
 