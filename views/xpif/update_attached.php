<?php
use yii\helpers\Html;
use yii\helpers\Url;

use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\grid\GridView;

//use kartik\tabs\TabsX;

use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */
 
$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord)?'': ' : '. $model->description); 
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelh->pif_id, 'url' => ['update','id'=>$modelh->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View':'Update'));

$staticOnly = true;
$staticOnly = $viewmode;

 
?>
<div class="etable-update">
    <div class="etable-form">
        <div class="panel  panel-primary">
            <div class="panel-heading"><?=$this->title?>
                <div class="pull-right">
                </div>
                </div>
                <div class="panel-body">
                <script>
                .col-centered{
                    float: none;
                    margin: 0 auto;
                    color:red;
                    border: 3px solid #73AD21;
                }
                </script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
                    <?php
                        $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); 
                        // ***AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                        echo Form::widget([
                            'model'=>$modelh,
                            'form'=>$form,
                            'columns'=>12,                           
                            'attributes'=>[
                                'pif_id'=>[
                                    'type'=>Form::INPUT_STATIC,                                  
                                    'columnOptions'=>['colspan'=>2],     
                                ],
                                'items_ref'=>[
                                    'type'=>Form::INPUT_STATIC,                                  
                                    'columnOptions'=>['colspan'=>3],     
                                ],
                                
                                'pif_name'=>[
                                    'type'=>Form::INPUT_STATIC,                    
                                    'columnOptions'=>['colspan'=>5],     
                                ],                                  
                            
                                    
                            ],
                        ]);                        
                        echo '<hr/>';

                        echo Html::hiddenInput('input-filename',$model->filename, ['id'=>'input-filename']);
                        echo Html::hiddenInput('input-pif_id',$modelh->pif_id, ['id'=>'input-pif_id']);
                        echo Form::widget([
                            'model'=>$model,
                            'form'=>$form,
                            'columns'=>12,
                            'staticOnly'=>$staticOnly,
                            'attributes'=>[
                                'description'=>[
                                    'type'=>Form::INPUT_TEXT,
                                    'columnOptions'=>['colspan'=>5],    
                                ],
                                // 'filename'=>[
                                //     'type'=>Form::INPUT_TEXT,
                                //     'columnOptions'=>['colspan'=>5],                                    
                                // ], 
                                // 'filegroup'=>[
                                //     'type'=>Form::INPUT_DROPDOWN_LIST,                                 
                                //     'items'=> app\models\XPifAttachedfile::$filegroup_LIST,                                 
                                //     'staticValue'=>function($model,$index, $widget){
                                //         return (app\models\XPifAttachedfile::$filegroup_LIST[$model->filegroup]);
                                //     },
                                //     'columnOptions'=>['colspan'=>2],    
                                // ],
                                'filegroup'=>[
                                    'type'=>Form::INPUT_WIDGET,
                                    'widgetClass'=>'\kartik\select2\Select2',
                                    'options'=>[
                                        'data'=>app\models\XPifAttachedfile::$filegroup_LIST,                          
                                    ],          
                                    'staticValue'=>function($model,$index, $widget){
                                        return (app\models\XPifAttachedfile::$filegroup_LIST[$model->filegroup]);
                                    },                                    
                                    'columnOptions'=>['colspan'=>2],    
                                ],                                  

                                'filename'=>[                                                                
                                    'type'=>Form::INPUT_WIDGET,                              
                                    'widgetClass'=>'\kartik\depdrop\DepDrop',
                                    'options'=>[                               
                                        'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,                                                                                                            
                                        'pluginOptions'=>[                                            
                                            'initialize' => true,                                                                                                                    
                                            'depends'=>[Html::getInputId($model, 'filegroup')], 
                                            'url'=>Url::to(['/site/ddpifattached']),                                      
                                            'params'=>['input-filename','input-pif_id'],                                        
                                            'loadingText' => 'Loading...',
                                            
                                            
                                        ]
                    
                                    ],                                
                                    'columnOptions'=>['colspan'=>3], 
                                ],

    
                                
                                'actions'=>[
                                    'type'=>Form::INPUT_RAW, 
                                    'value'=>Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary').'  col-centered'])
                                ],
                            ],
                        ]);
                            
                        // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
                        ActiveForm::end();    
                    ?>
        <?= GridView::widget([
            'dataProvider' => $modellist,            
            'responsiveWrap' => false,        
            'columns'=>[
                [
                    'attribute'=>'description',
                    'content'=>function($model, $key, $index, $column){                        
                        return Html::a(
                            $model->description,
                            [Yii::$app->controller->id.'/viewattached',
                                'id' => $model->id,
                                'idh' => $model->master_id]);
                    }
                ],
                [
                    'attribute'=>'filename',
                    'content'=>function($model, $key, $index, $column){                                                
                        return Html::a(
                            $model->filename ,
                            [Yii::$app->controller->id.'/viewattached',
                                'id' => $model->id,
                                'idh' => $model->master_id]);
                    }
                ],                
                           
                [                
                    'class' => 'kartik\grid\ActionColumn',
                    'template' =>'{update}{delete}',
                    'urlCreator' => function ($action, $model, $key, $index) use($modelh) {
                      
                        $url = Yii::$app->urlManager->createUrl(                                            
                            [Yii::$app->controller->id.'/'.$action.'attached', //$action = 'update' or 'delete'                            
                            'id' => $model->id,
                            'idh' => $model->master_id,
    
                            ]
                        );
                        return $url;                
                    },       
                    'header' => Html::a(
                        '<i class="glyphicon glyphicon-plus"></i>',
                        [Yii::$app->controller->id.'/createattached','idh' => $model->master_id],
                        ['title'=>'เพิ่ม']
                    )  
                ],                

            ]
        ])
        ?>
                </div>
            </div>
        </div>

    </div>
</div>
