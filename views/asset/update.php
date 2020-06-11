<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
//use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */
 
$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord)?'': ' : '. $model->CompanyCode); 
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View':'Update'));

$staticOnly = true;
$staticOnly = $viewmode;
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
            'columns'=>3,
            'staticOnly'=>$staticOnly,
            'attributes'=>[
                'AssetCode'=>[                    
                    'type'=>Form::INPUT_STATIC,
                ],
                'AssetName'=>[
                    'type'=>Form::INPUT_STATIC,
                 //  'columnOptions'=>['colspan'=>2],                
                ],                           
                'CalcDepreciation'=>[
         
                    'format'=>'raw',
                    'value'=>$model->CalcDepreciation ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>',
                    'widgetClass'=>'kartik\switchinput\SwitchInput', 
                    'type'=>Form::INPUT_WIDGET,  
                    'options' => [
                        'pluginOptions' => [
                            'onText' => 'Yes',
                            'offText' => 'No',
                        ]
                    ],
                    'valueColOptions'=>['style'=>'width:30%']                                       
                  
                ],


                'AssetDate'=> [
                     'type'=>Form::INPUT_WIDGET,                      
                    'widgetClass'=>'kartik\date\DatePicker', 
                    'options'=>[
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',                         
                        ],                        
                    ]                     
            
                ],
                

                'Depreciate'=>['type'=>Form::INPUT_TEXT],
                'DepreciationRemain'=>['type'=>Form::INPUT_TEXT],
                'Asset_AccountNo'=>['type'=>Form::INPUT_TEXT],
                'Acc_Depreciation'=>['type'=>Form::INPUT_TEXT],
                'Acc_AccumulatedDepreciation'=>['type'=>Form::INPUT_TEXT],
                'Acc_ScrapValue'=>['type'=>Form::INPUT_TEXT],










            ],
        ]);

        
       
        
               
        // echo Form::widget([
        //     'model'=>$model,
        //     'form'=>$form,
        //     'columns'=>6,
        //     'staticOnly'=>$staticOnly,
        //     'attributes'=>[
        //         'TelePhone'=>[
        //             'type'=>Form::INPUT_TEXT,
        //             'columnOptions'=>['colspan'=>2],
        //         ],
        //         'Fax'=>[
        //             'type'=>Form::INPUT_TEXT,                       
        //             'columnOptions'=>['colspan'=>2],
        //         ],              
        //         'VatPercent'=>[
        //             'type'=>Form::INPUT_TEXT,
        //             'columnOptions'=>['colspan'=>1],
        //         ],      
        //         'LimitOverOrderRate'=>[
        //             'type'=>Form::INPUT_TEXT,                    
        //             'columnOptions'=>['colspan'=>1],
        //             'label'=>'อัตรารับของเกิน',
        //         ],                
                           
             
        //     ],
        // ]);  
        // echo Form::widget([
        //     'model'=>$model,
        //     'form'=>$form,
        //     'columns'=>6,
        //     'staticOnly'=>$staticOnly,
        //     'attributes'=>[
        //         'PayForName'=>[
        //             'type'=>Form::INPUT_TEXT,  
     
        //         ],                
        //     ]
        // ]);              
        // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
        ActiveForm::end();    
    ?>
      </div></div></div>
    </div>
</div>
