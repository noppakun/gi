<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\tabs\TabsX;

use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */
 
$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord)?'': ' : '. $model->CompanyCode); 
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View':'Update'));

$staticOnly = true;
$staticOnly = $viewmode;
?>
<div class="etable-update"  >
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
                'CompanyCode'=>[
                    'type'=>Form::INPUT_TEXT,
                ],
                'TaxID'=>[
                    'type'=>Form::INPUT_TEXT,
                    'columnOptions'=>['colspan'=>2],                                    
                  
                ],              
            ],
        ]);

        
        echo TabsX::widget([            
            'position'=>TabsX::POS_ABOVE,
            'bordered'=>true,            
            //'encodeLabels'=>false
            'items'=>[
                [
                    'label'=>'ภาษาไทย',
                    'active'=>true,
                    'content'=>Form::widget([
                        'model'=>$model,
                        'form'=>$form,
                        'columns'=>1,
                        'staticOnly'=>$staticOnly,
                        'attributes'=>[                
                            'CompanyName'=>['type'=>Form::INPUT_TEXT],
                            //'Addr1'=>['type'=>Form::INPUT_TEXT],                                
                            'address_detail' => [   // complex nesting of attributes along with labelSpan and colspan
                                'label'=>'ที่อยู่',
                                'labelSpan'=>2,
                                'columns'=>1,                    
                                'attributes'=>[
                                    'Addr1'=>[
                                        'type'=>Form::INPUT_TEXT, 
                                        //'columnOptions'=>['colspan'=>6],
                                    ],
                                    
                                    'Addr2'=>[
                                        'type'=>Form::INPUT_TEXT, 
                                        //'columnOptions'=>['colspan'=>3],
                                    ],
                                    'Addr3'=>[
                                        'type'=>Form::INPUT_TEXT, 
                                        //'columnOptions'=>['colspan'=>3],
                                    ],
            
                                ]
                            ],
                        ],
                    ]),
                    
                ],
                [        
                    'label'=>'ภาษาอังกฤษ',
                    'content'=>Form::widget([
                        'model'=>$model,
                        'form'=>$form,
                        'columns'=>1,
                        'staticOnly'=>$staticOnly,
                        'attributes'=>[                
                            'CompanyEngName'=>['type'=>Form::INPUT_TEXT],  
                            //'Addr1'=>['type'=>Form::INPUT_TEXT],                                
                            'address_detail' => [   // complex nesting of attributes along with labelSpan and colspan
                                'label'=>'ที่อยู่',
                                'labelSpan'=>2,
                                'columns'=>1,                    
                                'attributes'=>[
                                    'AddrE1'=>[
                                        'type'=>Form::INPUT_TEXT, 
                                        //'columnOptions'=>['colspan'=>6],
                                    ],                        
                                    'AddrE2'=>[
                                        'type'=>Form::INPUT_TEXT, 
                                        //'columnOptions'=>['colspan'=>3],
                                    ],
                                    'AddrE3'=>[
                                        'type'=>Form::INPUT_TEXT, 
                                        //'columnOptions'=>['colspan'=>3],
                                    ],
                                ]
                            ],
                        ],
                    ]), 
                ]
            ],
        ]).'<br>';
        
               
        echo Form::widget([
            'model'=>$model,
            'form'=>$form,
            'columns'=>6,
            'staticOnly'=>$staticOnly,
            'attributes'=>[
                'TelePhone'=>[
                    'type'=>Form::INPUT_TEXT,
                    'columnOptions'=>['colspan'=>2],
                ],
                'Fax'=>[
                    'type'=>Form::INPUT_TEXT,                       
                    'columnOptions'=>['colspan'=>2],
                ],              
                'VatPercent'=>[
                    'type'=>Form::INPUT_TEXT,
                    'columnOptions'=>['colspan'=>1],
                ],      
                'LimitOverOrderRate'=>[
                    'type'=>Form::INPUT_TEXT,                    
                    'columnOptions'=>['colspan'=>1],
                    'label'=>'อัตรารับของเกิน',
                ],                
                           
             
            ],
        ]);  
        echo Form::widget([
            'model'=>$model,
            'form'=>$form,
            'columns'=>6,
            'staticOnly'=>$staticOnly,
            'attributes'=>[
                'PayForName'=>[
                    'type'=>Form::INPUT_TEXT,  
                    // 'type'=>Form::INPUT_WIDGET,                              
                    // 'widgetClass'=>'\dosamigos\tinymce\TinyMce',                    
                    // 'options' => [
                    //     'options' => ['rows' => 6],
                    //     //'language' => 'es',
                    //     'clientOptions' => [
                    //         'plugins' => [
                    //             "advlist autolink lists link charmap print preview anchor",
                    //             "searchreplace visualblocks code fullscreen",
                    //             "insertdatetime media table contextmenu paste"
                    //         ],
                    //         'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    //     ]    
                    // ],    
                ],                
                'PrintJobFormNo'=>[
                    'type'=>Form::INPUT_STATIC,  
                ],
            ]
        ]);              
        // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
        ActiveForm::end();    
  
              
    ?>
      </div></div></div>
    </div>
</div>

 