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



$this->title = 'Job ที่ต้นทุนมีการเปลี่ยนแปลง';
$this->params['breadcrumbs'][] = $this->title;

 





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
 

$form::end();

 

?>






    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showPageSummary'=>true,
        'responsiveWrap' => false,
        'columns' => [
            [
                'attribute'=>'JobNo', 
            ],
            [
                'attribute'=>'Item_Number', 
            ],
            [
                'attribute'=>'ana_no', 
            ],
            [
                'attribute'=>'item_name', 
            ],
            [
                'attribute'=>'UnitPrice', 
                'header'=>'ต้นทุนในฐานข้อมูล',
                'hAlign'=>'right',
                'format' => ['decimal',3],
            ],
            [
                'attribute'=>'calPrice', 
                'header'=>'ต้นทุนคำนวณใหม่',
                'hAlign'=>'right',
                'format' => ['decimal',3],
            ],
            [
                
                'header'=>'ผลต่าง',
                'hAlign'=>'right',
                'value'=>function($model){
                    return $model['calPrice'] - $model['UnitPrice'];                    
                },
                'format' => ['decimal',3],
            ],            
            //'calSum',
            //'sumPrice',
            
        ]
        // 'columns' => [
        //     [
        //         'attribute'=>'customertypedesc', 
        //         'header'=>'Customer type',
        //         'pageSummary'=>'Total',
        //         'width'=>'560',
        //     ],

        //     [
        //         'attribute'=>'total_l2', 'format' => ['decimal',0],
        //         'header'=>$SelectForm->year-2,                
        //         'hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['total_l2']);}
        //     ],
        //     [
        //         'attribute'=>'total_l1', 'format' => ['decimal',0],
        //         'header'=>$SelectForm->year-1,
        //         'hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['total_l1']);}
        //     ],
        //     [
        //         'attribute'=>'total_l1_ytlm', 'format' => ['decimal',0],
        //         'header'=>'ytm.<br>'.($SelectForm->year-1),
        //         'hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['total_l1_ytlm']);}
        //     ],
        //     [
        //         'attribute'=>'total_ytlm', 'format' => ['decimal',0],
        //         'header'=>'ytm.<br>'.($SelectForm->year),
        //         'hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['total_ytlm']);}
        //     ],            
        //     [
        //         'attribute'=>'total_ytlm', 'format' => ['percent',2],
        //         'header'=>'ytm.<br>'.($SelectForm->year-1).'<br>vs<br>'.$SelectForm->year,
        //         'value'=>function ($model, $key, $index, $widget) {                    
        //             if ($model['total_l1_ytlm']==0){
        //                 return 0;
        //             }else{                        
        //                 return (($model['total_ytlm']/$model['total_l1_ytlm'])-1);
        //             }                    
        //         },
        //         'hAlign'=>'right',
        //         'pageSummary'=>$yearGrowth,
        //     ],

        //     [
        //         'attribute'=>'total', 
        //         'format' => ['decimal',0],
        //         'header'=>$SelectForm->year,
        //         'hAlign'=>'right','pageSummary'=>true,                
        //         'content'=>function ($model) {return xlib::number_format_text($model['total']);}                
        //     ],

        //     ['attribute'=>'amt1',  'format' => ['decimal',0],'header'=>'Jan.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt1']);}],
        //     ['attribute'=>'amt2',  'format' => ['decimal',0],'header'=>'Feb.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt2']);}],
        //     ['attribute'=>'amt3',  'format' => ['decimal',0],'header'=>'Mar.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt3']);}],
        //     ['attribute'=>'amt4',  'format' => ['decimal',0],'header'=>'Apr.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt4']);}],
        //     ['attribute'=>'amt5',  'format' => ['decimal',0],'header'=>'May.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt5']);}],
        //     ['attribute'=>'amt6',  'format' => ['decimal',0],'header'=>'Jun.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt6']);}],
        //     ['attribute'=>'amt7',  'format' => ['decimal',0],'header'=>'Jul.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt7']);}],
        //     ['attribute'=>'amt8',  'format' => ['decimal',0],'header'=>'Aug.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt8']);}],
        //     ['attribute'=>'amt9',  'format' => ['decimal',0],'header'=>'Sep.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt9']);}],
        //     ['attribute'=>'amt10', 'format' => ['decimal',0],'header'=>'Oct.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt10']);}],
        //     ['attribute'=>'amt11', 'format' => ['decimal',0],'header'=>'Nov.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt11']);}],
        //     ['attribute'=>'amt12', 'format' => ['decimal',0],'header'=>'Dec.','hAlign'=>'right','pageSummary'=>true,
        //         'content'=>function ($model) {return xlib::number_format_text($model['amt12']);}],
        // ],


    ]); ?>
 
