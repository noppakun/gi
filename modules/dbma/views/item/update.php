<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\tabs\TabsX;


use app\widgets\se2Uom;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */
 
$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord)?'': ' : '. $model->Item_Number); 
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View':'Update'));

$staticOnly = true;
$staticOnly = $viewmode;
//$staticOnly = false;
//-----------------------------------------
    // ------------------------------------
    function checkboxStatic($var,$label){
        return '<span class=" text-'.(($var)?'success':'warning').' glyphicon glyphicon-'.(($var)?'ok':'remove').'" ></span> '.$label;                                                                       
    }                                      

    function dropdownStatic($var,$ArrayMap){
        return ((is_null($var)?'':trim($var)) == '')? '<p class="text-danger">(not set)</p>':
            $ArrayMap[$var];
    };        
    //--------------------------------------
//-----------------------------------------
$uomArrayMap=(new se2Uom)->itemsQueryArrayMap();

?>
<div class="etable-update">
    <div class="etable-form">
    <div class="panel panel-<?=(($viewmode)?'success':'warning')?>">
    <div class="panel-heading"><?=$this->title?>
    <div class="pull-right">
    <?php
 

    //$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
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
            'attributeDefaults' => [
                'type' => Form::INPUT_TEXT,
                'labelOptions' => ['class'=>'col-md-4'],
                'inputContainer' => ['class'=>'col-md-6'],
            ],            
            'attributes'=>[
                
                'Item_Number'=>[
                    'type'=>Form::INPUT_TEXT,
                ],
                'Item_Name'=>[
                    'type'=>Form::INPUT_TEXT,
                    'columnOptions'=>['colspan'=>4],                    
                ], 
                'QtyOnhand'=>[
                    'type'=>Form::INPUT_STATIC,
                     'staticValue'=>function($model){
                        return number_format($model->QtyOnhand,4);
                    },
                    'columnOptions'=>['align'=>'right'],                    
                ],
            ],
        ]);

        echo Html::hiddenInput('input-type-1'       ,$model->Loc_Number,    ['id'=>'input-type-1']);
        echo Html::hiddenInput('input-Group_Product',$model->Group_Product, ['id'=>'input-Group_Product']);
        echo Html::hiddenInput('input-Product'      ,$model->Product,       ['id'=>'input-Product']);
        echo Html::hiddenInput('input-Brand'        ,$model->Brand,         ['id'=>'input-Brand']);
        
        echo TabsX::widget([            
            'position'=>TabsX::POS_ABOVE,
            'bordered'=>true,            
            //'encodeLabels'=>false
            'items'=>[
                [
                    'label'=>'หน้า 1',
//                    'active'=>true,
                    'content'=>Form::widget([
                        'model'=>$model,
                        'form'=>$form,
                        'columns'=>4,
                        'staticOnly'=>$staticOnly,
                        'attributes'=>[
             
                                           
                            'WhCode'=>[
                                'type'=>Form::INPUT_DROPDOWN_LIST,
                                'items'=>(new app\widgets\se2Warehouse)->itemsQueryArrayMap(),                              
                                'options'=>[
                                    'id'=>'wh-id'
                                ],                                
                             
                            ], 
    
                            'Loc_Number' => [
                                'type'=>Form::INPUT_WIDGET,                              
                                'widgetClass'=>'\kartik\depdrop\DepDrop',
                                'options'=>[
                                    'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,
                                    'pluginOptions'=>[
                                        'initialize' => true,
                                        'depends'=>['wh-id'],
                                        'placeholder'=>'Select...',
                                        'url'=>Url::to(['/site/ddlocation']),
                                        'params'=>['input-type-1']
                                    ]
                
                                ],
                            ],                                        
                                        
            
                            'Uom'=>[
                                'type'=>Form::INPUT_DROPDOWN_LIST,                                
                                'items'=>$uomArrayMap,         
                                'staticValue'=>dropdownStatic($model->Uom,$uomArrayMap),
                            ], 
            
                            'Pack' => [],
                            'PackSize' => [],                            
                            'PackUom'=>[
                                'type'=>Form::INPUT_DROPDOWN_LIST,                                
                                'items'=>$uomArrayMap,                                
                                'staticValue'=>dropdownStatic($model->PackUom,$uomArrayMap),                                
                            ], 
                            
            
                            'Shrink' => [],
                            'ShrinkSize' => [],
                            'Lot_Size' => [],
            
                            'Maximum' =>  [],
                            'Minimum' => [],
                            'Class' =>  [],
                   
            
                            'LeadTime' => [],
                            'ShelfLife' => ['type'=>Form::INPUT_STATIC],             
                          
                            'InsteadCode' => [],
                            'Industry_Code' => [],                            
                            'CompanyCode'=>[
                                'type'=>Form::INPUT_DROPDOWN_LIST,
                                'items'=>(new app\widgets\se2Company)->itemsQueryArrayMap(),                              
                            ],            
                            
                            'ControlItemType'=>[
                                'type'=>Form::INPUT_DROPDOWN_LIST,
                                'items'=> app\models\item::$ControlItemType_LIST,  
                                'staticValue'=>dropdownStatic($model->ControlItemType,app\models\item::$ControlItemType_LIST),                                               
                            ],                             
            
                            'Remark' => [
                                'type'=>Form::INPUT_TEXT,
                                'columnOptions'=>['colspan'=>3],                    
                            ],                 
             
             
                        ],
                    ])
                    .Form::widget([
                        'model'=>$model,
                        'form'=>$form,
                        'columns'=>4,
                        'staticOnly'=>$staticOnly,
                        'attributes'=>[
             
             
                            'Flag_Ana' => [
                                'type'=>Form::INPUT_CHECKBOX,                                
                                'staticValue'=> checkboxStatic($model->Flag_Ana,$model->labels['Flag_Ana']),
                            ],
                            'Iqc_Check' => [
                                'type'=>Form::INPUT_CHECKBOX,                                
                                'staticValue'=> checkboxStatic($model->Iqc_Check,$model->labels['Iqc_Check']),
                            ],
                            'Life_Check' => [
                                'type'=>Form::INPUT_CHECKBOX,                                                                
                                'staticValue'=> checkboxStatic($model->Life_Check,$model->labels['Life_Check']),
                                
                            ],
                            'RetestDate_Check' => [
                                'type'=>Form::INPUT_CHECKBOX,                                
                                'staticValue'=> checkboxStatic($model->RetestDate_Check,$model->labels['RetestDate_Check']),
                            ],
                            'NotActive' => [
                                'type'=>Form::INPUT_CHECKBOX,                                
                                'staticValue'=> checkboxStatic($model->NotActive,$model->labels['NotActive']),      
                            ],
                            'UserName' => ['type'=>Form::INPUT_STATIC],  
                            'LastUpdate' => ['type'=>Form::INPUT_STATIC],  
  
                            
             
                        ],
                    ])

                ],
                [
                    'label'=>'หน้า 2',
                  //  'active'=>true,
                    'content'=>Form::widget([
                        'model'=>$model,
                        'form'=>$form,
                        'columns'=>3,
                        'staticOnly'=>$staticOnly,
                        'attributes'=>[
                            'Type_Invent_Code'=>[
                                'type'=>Form::INPUT_WIDGET,
                                'widgetClass'=>'\kartik\select2\Select2',
                                'options'=>[
                                    'data'=>(new app\widgets\se2Typeinvent)->itemsQueryArrayMap(),                         
                                ],          
                            ],                             
                            'Group_Product'=>[                                                                
                                'type'=>Form::INPUT_WIDGET,                              
                                'widgetClass'=>'\kartik\depdrop\DepDrop',
                                'options'=>[                               
                                    'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,                                                                                                            
                                    'pluginOptions'=>[
                                        
                                        'initialize' => true,                                                                                                                    
                                        'depends'=>[Html::getInputId($model, 'Type_Invent_Code')], 
                                        'url'=>Url::to(['/site/ddgroupproduct']),                                      
                                        'params'=>['input-Group_Product'],                                        
                                        'loadingText' => 'Loading...',
                                        
                                        
                                    ]
                
                                ],                                
                            ],
                            'Product'=>[                               
                                'type'=>Form::INPUT_WIDGET,                              
                                'widgetClass'=>'\kartik\depdrop\DepDrop',
                                'options'=>[                                 
                                    'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,                                                                        
                                    'pluginOptions'=>[
                                        'initialize' => true,
                                        'depends'=>[
                                            Html::getInputId($model, 'Group_Product'),
                                            Html::getInputId($model, 'Type_Invent_Code'),                                            
                                        ],                
                                        'url'=>Url::to(['/site/ddproduct']),                                        
                                        'params'=>['input-Product'],
                                        'loadingText' => 'Loading...',
                                    ]
                
                                ],                                
                            ],
                            'Brand'=>[                               
                                'type'=>Form::INPUT_WIDGET,                              
                                'widgetClass'=>'\kartik\depdrop\DepDrop',
                                'options'=>[                                 
                                    'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,                                                                        
                                    'pluginOptions'=>[
                                        'initialize' => true,
                                        'depends'=>[
                                            Html::getInputId($model, 'Product'),
                                            Html::getInputId($model, 'Group_Product'),
                                            Html::getInputId($model, 'Type_Invent_Code'),                                            
                                        ],                
                                        'url'=>Url::to(['/site/ddbrand']),                                        
                                        'params'=>['input-Brand'],
                                        'loadingText' => 'Loading...',
                                    ]
                
                                ],                                 
                            ],
                            'Type'=>[                               
                            ],
                            'SubType'=>[                               
                            ],

                        ],
                    ])
        
                    
                ],
                [
                    'label'=>'หน้า 3',
                    //'active'=>true,
                    
                    'content'=>Form::widget([
                        'model'=>$model,
                        'form'=>$form,
                        'columns'=>3,
                        'staticOnly'=>$staticOnly,
                        'attributes'=>[
                            'Source'=>[
                                'type'=>Form::INPUT_RADIO_LIST,                                 
                                'items'=> app\models\item::$Source_LIST,                                 
                                'staticValue'=>function($model,$index, $widget){
                                    return (app\models\item::$Source_LIST[$model->Source]);
                                }
                            ],
                            'Cost_Type'=>[
                                'type'=>Form::INPUT_RADIO_LIST, 
                                'items'=> app\models\item::$Cost_Type_LIST,                                 
                                'staticValue'=>function($model,$index, $widget){
                                    return (app\models\item::$Cost_Type_LIST[$model->Cost_Type]);
                                }                                
                            ],  
                            'Order_Policy'=>[
                                'type'=>Form::INPUT_RADIO_LIST, 
                                'items'=> app\models\item::$Order_Policy_LIST,                                 
                                'staticValue'=>function($model,$index, $widget){
                                    return (app\models\item::$Order_Policy_LIST[$model->Order_Policy]);
                                }                                
                            ],                   
                        ],
                    ])
                ],
            ],
        ]);
         
            
              
 
        
        // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
        ActiveForm::end();    
    ?>
      </div></div></div>
    </div>
</div>
