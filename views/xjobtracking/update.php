<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use app\models\XJobtracking;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */
 
$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord)?'': ' : '. $model->id); 
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View':'Update'));

$staticOnly = true;    
//$viewmode  = true;
$staticOnly = $viewmode;
//$staticOnly = true; 
?>
<div class="etable-update">
    <div class="etable-form">
    <div class="panel  panel-primary">
    <div class="panel-heading"><?=$this->title?>
    <div class="pull-right">
    <?php
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
    if ( !$viewmode) {
        echo Form::widget([
            'model'=>$model,
            'form'=>$form,
            'columns'=>2,
            'staticOnly'=>$staticOnly,
            'attributes'=>[
                'actions'=>['type'=>Form::INPUT_RAW, 'value'=>Html::submitButton('Save', ['class'=>'btn btn-success btn-xs'])],
                
            ],
        ]);    
        }
    ?>
    </div>
    </div>
    <div class="panel-body">
    <?php
        // ***AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
        

        echo Form::widget([
            'model'=>$model,
            'form'=>$form,
            'columns'=>6,
            'staticOnly'=>$staticOnly,
            'attributes'=>[                
                'jobtype'=>['type'=>Form::INPUT_TEXT,],
                'detail'=>[
                    'type'=>Form::INPUT_TEXTAREA,
                    'columnOptions'=>['colspan'=>5],
                ],       
            ],
        ]);

        echo Form::widget([
            'model'=>$model,
            'form'=>$form,
            'columns'=>4,            
            'attributes'=>[
                
  
                'jobdate'=>[
                    'type'=>Form::INPUT_WIDGET, 
                    'widgetClass'=>'kartik\date\DatePicker',                                         
                    'options'=>[
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',                         
                        ],                        
                    ]                                                            
                ],
                'duedate'=>[
                    'type'=>Form::INPUT_WIDGET, 
                    'widgetClass'=>'kartik\date\DatePicker',                     
                    'options'=>[
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',                         
                        ],                        
                    ]                    
                ],
                'finishdate'=>[
                    'type'=>Form::INPUT_WIDGET, 
                    'widgetClass'=>'kartik\date\DatePicker',                     
                    'options'=>[
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',                         
                        ],                        
                    ]                    
                ],

 
                'responsible_user'=>['type'=>Form::INPUT_TEXT,],
                'remark'=>[
                    'type'=>Form::INPUT_TEXTAREA,
                    'columnOptions'=>['colspan'=>2],
                ],
                'calStatusText'=>[
                    'type'=>Form::INPUT_STATIC,
                ],
                'calPerformanceText2'=>[
                    'type'=>Form::INPUT_STATIC,
                ],
                // 'performance'=>[
                //     'type'=>Form::INPUT_STATIC,
                //     'staticValue' => function($model){                                                
                //         return ($model->finishdate <= $model->duedate) ? XJobtracking::$performance_LIST[XJobtracking::PERFORMANCE_NORMAL]:XJobtracking::$performance_LIST[XJobtracking::PERFORMANCE_OVERDUE];
                //     },

                // ],
                'owner_user'=>['type'=>Form::INPUT_STATIC,],
           
 
                'actions'=>[
                    'type'=>Form::INPUT_RAW, 
                    'value'=>function ($model){
                        
                        return  ($model->finishdate==null) && (!$model->cancel) && (!$model->isNewRecord)?
                        Html::a('ยกเลิก', 
                             ['cancel', 'id' => $model->id], 
                             [
                                 'class'=>'btn btn-danger btn-xs',
                                 'data' => [
                                    'confirm' => 'ต้องการยกเลิก',
                                    'method' => 'post',
                                ],
                             ]
                        ):'';
                    },                    
                ],  
              

            ],
        ]);

        
       
                     
        // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
        ActiveForm::end();    
    ?>
      </div></div></div>
    </div>
</div>
