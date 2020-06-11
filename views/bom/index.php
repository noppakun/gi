<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\daterange\DateRangePicker;
use app\components\gihelper;
//use kartik\widgets\ActiveForm;

//use kartik\form\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'โครงสร้างสินค้า '.(Yii::$app->controller->id == 'bom-temp'?"(new)":"(approved)");
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bom-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<!--
    <p>
        <?= Html::a('Create Bom', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->

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
                <?=$form->field($SelectForm, 'checkbox')->checkbox(['onchange'=>'this.form.submit()']   )->label('Effective Date Fillter');?> 
            </div>
                   
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

        </div>
        <div class="row">            
            <div class="col-md-2 col-sm-2  col-xs-2">      
                
                <?=Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>
                
            </div>              
        </div>
        
    </div>


    <?php        
    ActiveForm::end();


    $gridViewPDF = [
        'mime' => 'application/pdf',     
        'config' => [        
            'cssInline' => file_get_contents(\Yii::getAlias('@app').'/web/css/kv-mpdf-report.css').
                'body {font-size: 10px;}',        
            'format' => 'A4',
            'orientation'=>'P',
            'destination' => 'I',
            'marginTop' => 22,      
            'methods' => [
                'SetHeader' => ['<h5>'.gihelper::comp_name().'</h5>'.
                '<br>'.$this->title.                
                '||Page : {PAGENO}/{nbpg}<br><br>Date : ' . date("d-m-Y")],  
                'SetFooter' => [''],   
                                 
            ],
        ],
    ];    

    include "rtf-html-php-master/rtf-html-php.php";
     
    ?> 

    
<!-- ---------------------------------------------------------------------------------- -->
    <?= GridView::widget([
        'panel'=>[
            'before'=>''
        ],

        'export'=>[
            'target' => GridView::TARGET_BLANK,
        ],

        'exportConfig'=>[
            GridView::PDF => $gridViewPDF,            
            //GridView::EXCEL => [],            
 
            
        ],  



        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
            ],

         
            [
                'attribute'=>'Assembly',            
                'width'=>'100px',    
            ],
            [
                'attribute'=>'CompoundCode',            
                'width'=>'100px',    
            ],
            [       
                'attribute'=>'EffectiveDate',            
                'format'=>'date',
                'width'=>'100px',    
            ],            
            
            'item.Item_Name',

            // [       
            //     'attribute'=>'ProcessRemark',            
            //     'format'=>'raw',
            //     'content'=>function($model){
            //         $reader = new RtfReader();
            //         $rtf = $model['ProcessRemark'];
            //         //$rtf = file_get_contents("1.rtf"); 
            //         $result = $reader->Parse($rtf);                    
            //         $formatter = new RtfHtml();
            //         $r = $formatter->Format($reader->root);                    
                
            //         return $r;
            //     }
                
            // ],            

            //'Formula_No',
            //'SpecNo',
            //'ProcessRemark:ntext',
            //'TransferRecord1',
            // 'TransferRecord2',
            // 'TransferRecord3',
            // 'StandardBatchSize',

            // 'Density',            
            // 'StandardYieldMin',
            // 'StandardYieldMax',
            // 'RegNo',
            // 'ProductType',

            [
                'header'=>'Cost',
                'class' => 'yii\grid\ActionColumn',                         
                'template'=>'{view}',
                'contentOptions' => ['style' => 'text-align:center','class'=>'skip-export'],
                'headerOptions' => ['class'=>'skip-export'],
            ],
        ],
    ]); ?>
</div>




    