<?php
use kartik\form\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use \app\components\XLib;


/*
BD-office   BD-O // create+view
BD-Mg       BD-M // create+view+approve1
RD-office   RD-O // view
RD-Mg       RD-M // view+approve2
*/

$BD_O = \Yii::$app->user->can('/@XPDR/BD-O');
$BD_M = \Yii::$app->user->can('/@XPDR/BD-M');
$RD_O = \Yii::$app->user->can('/@XPDR/RD-O');
$RD_M = \Yii::$app->user->can('/@XPDR/RD-M');



// $BD_O = (1==0);
// $BD_M = (1==0);
// $RD_O = (1==1);
// $RD_M = (1==1);

// app\components\XLib::xprint_r( $BD_O );
// app\components\XLib::xprint_r( $BD_M );
// app\components\XLib::xprint_r( $RD_O );
// app\components\XLib::xprint_r( $RD_M );

$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord)?'': ' : '. $model->doc_no); 
$this->params['breadcrumbs'][] = ['label' => $tablecaption ,  'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View':'Update'))
    .' ( '
    .($BD_O?"BD_O ":' ')
    .($BD_M?"BD_M ":' ')
    .($RD_O?"RD_O ":' ')
    .($RD_M?"RD_M ":' ').' )';

$staticOnly = true;
$staticOnly = $viewmode;
 

 
$GLOBALS['BD_O'] = $BD_O;
$GLOBALS['BD_M'] = $BD_M;
$GLOBALS['user_approve_ready'] = $model->user_approve!=null;


function typeInput($p_type){    
    global $user_approve_ready,$BD_O,$BD_M;                
    return  ( ($BD_O or $BD_M)  and !$user_approve_ready)? $p_type : Form::INPUT_STATIC ;     
}


//$approve1_ready =  ($model->user_approve!=null);
//app\components\XLib::xprint_r( Yii::$app->formatter);
?>

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
                        //'staticOnly'=>$staticOnly,
                        //'staticOnly'=>true,
                        'attributes'=>[
                            'actions'=>[
                                'type'=>Form::INPUT_RAW, 
                                'value'=>Html::submitButton('Save', 
                                    [
                                        'class'=>'btn btn-success btn-xs',
                                        'disabled'=>!($BD_O or $BD_M or ($model->user_approve!=null)),
                                    ]),                                    
                            ],                           
                            
                        ],
                        //($BD_O or $BD_M)
                    ]);    
                    }
                    
                ?>
            </div>
        </div>
        

        <div class="panel-body" >
            <div class="row <?= (($BD_O or $BD_M) ? '':'hidden')?>">        
            
                <div class="col-md-12 text-right ">
                    <?= Html::a('Picture',['image','id'=>$model->id],[
                            'class' => 'btn btn-success '.($model->user_approve == null? '':'hidden' )
                        ]) ?>
                    <?= Html::a('Copy',['copy','id'=>$model->id],[
                        'class' => 'btn btn-warning ',
                        "data-confirm"=>"ต้องการสำเนารายการนี้ ?"
                        ]) ?>
                    <?= Html::a('Delete',['delete','id'=>$model->id],[
                        'class' => 'btn btn-danger '.($model->user_approve == null? '':'hidden' ),                       
                        'data' => [
                            'method' => 'post',
                        ],                        
                        "data-confirm"=>"ต้องการลบรายการนี้ ?"
                        ]) ?>

                </div>
            </div>
            <?php
            
                // ***AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
     
                
                echo Form::widget([
                    'model'=>$model,
                    'form'=>$form,
                    'columns'=>3,
                    //'staticOnly'=>$staticOnly,                    
                    'attributes'=>[                       
                        'doc_no'=>[
                            'type'=>Form::INPUT_STATIC,                            
                        ],            
                        'doc_date'=> [
                            //'type'=>Form::INPUT_WIDGET,                      
                            'type'=>Form::INPUT_STATIC,                            
                            'widgetClass'=>'kartik\date\DatePicker', 
                            'options'=>[
                                'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',                         
                                ],                        
                            ]
                        ],                                                                                 
                        'cust_no'=>[                            
                            //'type'=>typeInput(Form::INPUT_TEXT),    
                            'type'=>typeInput(Form::INPUT_TEXT),
                            'staticOnly'=>($model->user_approve!=null),
                        ],                        
                    ]
                ]);

                        

                echo Form::widget([
                    'model'=>$model,
                    'form'=>$form,
                    //'columns'=>1,
                    //'staticOnly'=>$staticOnly,
                    'attributes'=>[                                                                 
                        'cust_name'=>[
                            'type'=>typeInput(Form::INPUT_TEXT),
                            //'columnOptions'=>['colspan'=>3],
                        ],                
                        'product_name'=>[
                            'type'=>typeInput(Form::INPUT_TEXT),
                            //'columnOptions'=>['colspan'=>3],
                        ],                       

                    ],
                ]);

                echo Form::widget([
                    'model'=>$model,
                    'form'=>$form,
                    'columns'=>2,
                    //'staticOnly'=>$model->user_approve!=null ,
                    'attributes'=>[                                                                 
                        'product_cat'=> [
                            //'type'=>Form::INPUT_DROPDOWN_LIST,                            
                            'type'=>typeInput(Form::INPUT_RADIO_LIST),
                            'options'=>['inline'=>true],
                            //  'type'=>typeInput(Form::INPUT_DROPDOWN_LIST),
                            
                            // 'type'=>function () use ($approve1_ready){
                            //     return ($approve1_ready?Form::INPUT_STATIC:Form::INPUT_DROPDOWN_LIST);
                            // },
                            'items'=>\app\models\xpkr::$product_cat_LIST,    
                            'staticValue'=>function($model,$index, $widget){
                                return (\app\models\xpkr::$product_cat_LIST[$model->product_cat]);
                            },                
                            //'columnOptions'=>['colspan'=>2],
                        ],                        
                        'product_cat_other'=>[
                            'type'=>typeInput(Form::INPUT_TEXT),
                            //'columnOptions'=>['colspan'=>1],
                        ],                        
                    ],
                ]);
                echo Form::widget([
                    'model'=>$model,
                    'form'=>$form,                    
                    //'staticOnly'=>$model->user_approve!=null ,
                    'attributes'=>[
                        'bulk'=> [                            
                            'type'=>typeInput(Form::INPUT_RADIO_LIST),
                            'options'=>['inline'=>true],                       
                            'items'=>\app\models\xpkr::$bulk_LIST,    
                            'staticValue'=>function($model,$index, $widget){
                                return (\app\models\xpkr::$bulk_LIST[$model->bulk]);
                            }                
                        ],                          
                        'benchmark'=>['type'=>typeInput(Form::INPUT_TEXT)],
                        //'feeling_after_use'=>['type'=>typeInput(Form::INPUT_TEXT)],
                        'target_group'=>['type'=>typeInput(Form::INPUT_TEXT)], 
                    ],
                ]);

                echo Form::widget([
                    'model'=>$model,
                    'form'=>$form,                                        
                    'columns'=>12,
                    'attributes'=>[ 
                        'size'=>[
                            'type'=>typeInput(Form::INPUT_TEXT),
                            'columnOptions'=>['colspan'=>3],
                        ],                        
                        'size_unit'=> [                            
                            'type'=>typeInput(Form::INPUT_DROPDOWN_LIST),                          
                            'items'=>\app\models\xpkr::$size_unit_LIST,    
                            'label'=>'Unit',
                            'columnOptions'=>['colspan'=>2],
                            'staticValue'=>function($model,$index, $widget){
                                return (\app\models\xpkr::$size_unit_LIST[$model->size_unit]);
                            }                
                        ],                        
                        'first_order'=>[
                            'type'=>typeInput(Form::INPUT_TEXT),
                            'columnOptions'=>['colspan'=>2],
                        ],
                    

                        'total_order'=>[
                            'type'=>typeInput(Form::INPUT_TEXT),
                            'columnOptions'=>['colspan'=>2],
                        ],
                        'order_unit'=> [                            
                            'type'=>typeInput(Form::INPUT_DROPDOWN_LIST),
                            'items'=>\app\models\xpkr::$order_unit_LIST,    
                            'label'=>'Unit',
                            'columnOptions'=>['colspan'=>2],
                            'staticValue'=>function($model,$index, $widget){
                                return (\app\models\xpkr::$order_unit_LIST[$model->order_unit]);
                            }                
                        ],                        
                    ],                    
                ]);
                echo Form::widget([
                    'model'=>$model,
                    'form'=>$form,                                        
                    'columns'=>4,
                    'attributes'=>[                 
                        'artwork_design'=> [                            
                            //'type'=>typeInput(Form::INPUT_DROPDOWN_LIST),
                            'type'=>typeInput(Form::INPUT_RADIO_LIST),
                            'options'=>['inline'=>true],
                            'items'=>\app\models\xpkr::$artwork_design_LIST,    
                            //'label'=>'Unit',
                            'columnOptions'=>['colspan'=>2],
                            'staticValue'=>function($model,$index, $widget){
                                return (\app\models\xpkr::$artwork_design_LIST[$model->artwork_design]);
                            }                
                        ],                        
                        '_detail'=> [
                            'visible'=>!$model->isNewRecord,
                            'type'=>Form::INPUT_RAW,                            
                            //'value'=>Html::a('รายละเอียดบรรจุภัณฑ์',['create_detail','idh'=>$model->doc_no],
                            'value'=>Html::a('รายละเอียดบรรจุภัณฑ์',['create_detail','idh'=>$model->id],                            
                            //'value'=>Html::a('รายละเอียดบรรจุภัณฑ์',['create_detail','id'=>$model->id],
                            [
                                'class' => 'btn btn-success',                           
                            ])                            
                        ],

                    ]
                ]);

                                
                echo Form::widget([
                    'model'=>$model,
                    'form'=>$form,                    
                    //'staticOnly'=>$staticOnly,
                    'columns'=>4,
                    'attributes'=>[                                         
                        'present_req_date'=> [                            
                            'type'=>typeInput(Form::INPUT_WIDGET),                
                            'widgetClass'=>'kartik\date\DatePicker', 
                            'options'=>[
                                'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',                         
                                ],                        
                            ],
                            'staticValue'=>function($model,$index, $widget){
                                return XLib::dateConv($model->present_req_date,'a');  
                            }                            
                        ],
                        'price_req_date'=> [                            
                            'type'=>typeInput(Form::INPUT_WIDGET),                
                            'widgetClass'=>'kartik\date\DatePicker', 
                            'options'=>[
                                'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',                         
                                ],                        
                            ]
                        ],
                        
                        //
                        'user_inform'=>['type'=>Form::INPUT_STATIC],
                        'user_approve'=>$model->user_approve!=null 
                            ? ['type'=>Form::INPUT_STATIC]
                            : [
                            'visible'=>!$model->isNewRecord,
                            'type'=>Form::INPUT_RAW,                            
                            'value'=>                                
                                (
                                    Html::label('ผู้อนุมัติ') .'<br>'
                                    .(
                                        $model->user_approve!=null 
                                        ?   $model->user_approve
                                        :   (
                                              
                                                ($BD_M)
                                                
                                                ? Html::a('Approve',['approve1','id'=>$model->id],
                                                    [
                                                        'class' => 'btn btn-success',
                                                        "data-confirm"=>"ต้องการอนุมัติรายการนี้ ?"
                                                    ])
                                                : Html::a('Approve',null,['class' => 'btn btn-success','disabled'=>true])
                                            )
                                        
                                    )
                                ),                               
                        ],

                        'user_approve_date'=>[
                            'type'=>Form::INPUT_STATIC,
                            'visible'=>!$model->isNewRecord,
                        ],
                                  
                        
                    ],
                ]);                

            ?>
            
        </div> <!-- "panel-body" -->
    </div>  <!-- panel -->
   
    <div class="panel panel-primary" style = <?=(($RD_M) and ($model->user_approve!=null))?"":"display:none" ?>>
        <div class="panel-heading">
            ตอบรับงานวิจัยและพัฒนาผลิตภัณฑ์
        </div>
        <div class="panel-body">
            <?php
                echo Form::widget([
                    'model'=>$model,
                    'form'=>$form,
                    'columns'=>6,
                    //'staticOnly'=>$model->user_approve!=null ,
                    'attributes'=>[                                                                 
                
                        'manager_accept'=> [
                            'type'=>$model->manager_accept=='Y'?Form::INPUT_STATIC:Form::INPUT_DROPDOWN_LIST,                            
                            'items'=>['Y'=>'Yes','N'=>'No'],  
                        // 'columnOptions'=>['colspan'=>2],  
                            'staticValue'=>function($model,$index, $widget){
                                return ($model->manager_accept=='Y'?'Yes':'No');
                            }                
                        ],  
                        'manager_remark'=>[
                           
                            'type'=>$model->manager_accept=='Y'?Form::INPUT_STATIC:Form::INPUT_TEXT,                            
                            'columnOptions'=>['colspan'=>3]
                        ],               

                        'manager_approve'=>['type'=>Form::INPUT_STATIC],
                        'manager_approve_date'=>['type'=>Form::INPUT_STATIC],   
                        
                        'actions'=>['type'=>Form::INPUT_RAW, 'value'=>Html::submitButton('Save', 
                            [
                                'class'=>'btn btn-success btn-xs',
                                'disabled'=>($model->manager_accept=='Y'),
                            ])],
                            
                        
                    ],
                ]);
            ?>
        </div>
    </div> 
    
    <!-- ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB -->
    <?php               
        ActiveForm::end();    

      
        $imag_file = 'images/xpkr/'.$model->doc_no.'.jpg';
        //$imag_file = 'images/xpdr/'.$model->picture_filename;
        
    ?>
 

    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 thumbnail">                             
                    <?= Html::a(Html::img($imag_file),$imag_file)?>                     
                </div>
            </div>
        </div>
    </div> 
</div>


