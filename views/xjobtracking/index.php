<style>
    .container {width:100%;margin:0 auto;}
</style>
<?php

use yii\helpers\Html;
use app\components\gihelper;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\XJobtracking;
use app\widgets\ddlYear;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $TABLECAPTION;
$this->params['breadcrumbs'][] = $this->title;
   
?>

<!-- ---------------------------------------------------------------------------------- -->

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


            <div class="col-md-2 col-sm-2 col-xs-5"> 
                <?php 
                    
                    $l_status_LIST = XJobtracking::$status_LIST;
                    $l_status_LIST[0]='ทั้งหมด'; 
                    
                    echo $form->field($SelectForm, 'status')->dropDownList($l_status_LIST);
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
    ?>
                        

    
<!-- ---------------------------------------------------------------------------------- -->

<div class="etable-index">
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,        

        //'autoXlFormat'=>false,
        'rowOptions'=>function($model){
            if($model->duedate == date("d-m-Y", strtotime('tomorrow'))
            and ($model->finishdate == null)
            ){
                return ['class' => 'danger'];
            }
        },                
        'panel'=>[
            'before'=>''
        ],


        'export'=>[
            'target' => GridView::TARGET_BLANK,
        ],
        
        'exportConfig'=>[
            GridView::PDF => [
                'mime' => 'application/pdf',     
                'config' => [        
                    'cssInline' => file_get_contents(\Yii::getAlias('@app').'/web/css/kv-mpdf.css'),        
                    'format' => 'A4',
                    'orientation'=>'L',
                    'destination' => 'I',
                    'marginTop' => 22,      
                    'methods' => [
                        'SetHeader' => ['<h5>'.gihelper::comp_name().'</h5>'.
                        '<br>'.$TABLECAPTION.' Report'.                
                        '||Page : {PAGENO}/{nbpg}<br><br>Date : ' . date("d-m-Y")],  
                        'SetFooter' => [date("H:i:s")],   
                                         
                    ],
                ],
            ],
            

            
        ],        
        'columns' => [
            [
                'attribute'=>'id',    
                'label'=>'Job.Id',
                'width' => '5%',
                'hAlign' => 'center',
                // 'value'=>function($model){
                //     return 'J'.$model->id;
                // },                
            ],
            // [
            //     'class'=>'kartik\grid\SerialColumn',
            //     'width'=>'10px',  
            //     'headerOptions' => ['align'=>'center'],
            //     'contentOptions' => ['align'=>'center'],
                
            // ],


            [
                'attribute'=>'jobtype',
                'width' => '10px',
            ],

            [
                'attribute'=>'detail',
                'width' => '300px',
            ],

            [
                'attribute'=>'jobdate',
                'width' => '10px',
                'hAlign' => 'center',
            ],
            [
                'attribute'=>'duedate',                    
                'value'=>function($model){
                    return $model->duedate == null ? '-':$model->duedate;
                },                    
                'width' => '10px',
                'hAlign' => 'center',
            ],
            [
                'attribute'=>'finishdate',
                'value'=>function($model){
                    return $model->finishdate == null ? '-':$model->finishdate;
                },
                'width' => '10px',
                'hAlign' => 'center',
            ],
            [
                 
                'label'=>'D',
                'value'=>function($model){
                    return $model->finishdate == null ? 0 : (strtotime($model->finishdate)-strtotime($model->duedate))/60/60/24;            
                },
                'width' => '10px',
                'hAlign' => 'center',
            ],
            
            [
                //'header'=>'ผู้รับ<br>ผิดชอบ',
                'attribute'=>'responsible_user',
                'width' => '5px',
                //'format'=>'raw',
                 
            ],            
            [
                
                'attribute'=>'calStatusText',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return ['class' => ' ' 
                        . ($model->calStatus==1
                            ? 'bg-warning' : (
                                $model->calStatus==2 ? ( ($model->calPerformance==2)?'bg-danger' : 'bg-success'):''
                            ))];

                },
                'width' => '10px',
                'hAlign' => 'center', 
            ],
            [
                
                'attribute'=>'calPerformanceText',
                'hAlign' => 'center',
                'width' => '10px',
 
            ],                        
            
            [
                'attribute'=>'remark',
                'width' => '80px',
            ],

            //'owner_user',

            [
                'class' => 'kartik\grid\ActionColumn',
                //'template'=>'{view}{update}{delete}',
                'template'=>'{update}{view}',
 
                'visibleButtons' => [
                    'update' => function ($model) {
                        return $model->calStatus==1;
                    },
                    'view' => function ($model) {
                        return (!$model->calStatus==1) or ($model->calStatus==2)or ($model->cancel==1);
                    },
                ],
                'header' => Html::a(
                    '<i class="glyphicon glyphicon-plus"></i>',
                    [Yii::$app->controller->id.'/create'],
                    ['title'=>'เพิ่ม']
                ),
                'width' => '10px',
            ],        
            // [               
            //     'value'=>function($model){                
            //         return  date("Y-m-d", strtotime('tomorrow'));                 
            //     },        
            // ],            
        ],
  
    ]); 
    ?>

</div>

 <h4><span class="label label-default">* P (ประสิทธิภาพ)  N:ปกติ   O:เกินกำหนด</span></h4>