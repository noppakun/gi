<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use yii\web\JsExpression;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use app\models\Product;
//use kartik\tabs\TabsX;

//use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */

$BD_O = \Yii::$app->user->can('/@XPDR/BD-O');
$BD_M = \Yii::$app->user->can('/@XPDR/BD-M');
$RD_O = \Yii::$app->user->can('/@XPDR/RD-O');
$RD_M = \Yii::$app->user->can('/@XPDR/RD-M');



// $BD_O = (1==0);
// $BD_M = (1==0);
// $RD_O = (1==1);
// $RD_M = (1==1);

$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord)?'': ' : '. $model->item); 
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelh->doc_no, 'url' => ['update','id'=>$modelh->id]];
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
$GLOBALS['user_approve_ready'] = $modelh->user_approve!=null;
//$approve1_ready =  ($model->user_approve!=null); 

function typeInput($p_type){    
    global $user_approve_ready,$BD_O,$BD_M;                
    return  ( ($BD_O or $BD_M)  and !$user_approve_ready)? $p_type : Form::INPUT_STATIC ;     
} 
?>
<div class="etable-update">
    <div class="etable-form">
        <div class="panel  panel-primary">
            <div class="panel-heading"><?=$this->title?>
      
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
           
                  
                        <?php

                            Pjax::begin([
                                // Pjax options
                            ]);                    
                            $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); 
                            // ***AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                            echo Form::widget([
                                'model'=>$modelh,
                                'form'=>$form,
                                'columns'=>12,                           
                                'attributes'=>[
                                    'doc_no'=>[
                                        'type'=>Form::INPUT_STATIC,                                  
                                        'columnOptions'=>['colspan'=>2],     
                                    ],
                                    'doc_date'=>[
                                        'type'=>Form::INPUT_STATIC,          
                                        'staticValue'=>function($model){                                        
                                            return ($model->doc_date==null)?null:date ('d-m-Y', strtotime($model->doc_date));
                                        },                                                               
                                        'columnOptions'=>['colspan'=>2],     
                                    ],                                
                                    'cust_name'=>[
                                        'type'=>Form::INPUT_STATIC,          
                                        'columnOptions'=>['colspan'=>4],     
                                    ],
                                    'product_name'=>[
                                        'type'=>Form::INPUT_STATIC,          
                                        'columnOptions'=>['colspan'=>4],     
                                    ],
                                        
                                ],
                            ]);                        
                            echo '<hr/>';
                        ?>
 
                    <div id = "detail_edit"  style = <?=( ($BD_O or $BD_M)  and ($modelh->user_approve==null) )?"":"display:none" ?> >                        
                        <?php                            
                            echo Form::widget([
                                'model'=>$model,
                                'form'=>$form,
                                'columns'=>12,
                                'staticOnly'=>$staticOnly,
                                'attributes'=>[
                                    
    
                                    'item'=>[
                                        'type'=>Form::INPUT_TEXT,                                        
                                        'columnOptions'=>['colspan'=>3],                                    
                                    ],
                                    'material'=>[
                                        'type'=>Form::INPUT_TEXT,
                                        
                                        'columnOptions'=>['colspan'=>2],                                    
                                    ],                                     
                                    'owner'=> [                            
                                        'type'=>Form::INPUT_RADIO_LIST,
                                        'options'=>['inline'=>true],                       
                                        'items'=>\app\models\xpkr::$owner_LIST,    
                                        'staticValue'=>function($model,$index, $widget){
                                            return (\app\models\xpkr::$owner_LIST[$model->owner]);
                                        },
                                        'columnOptions'=>['colspan'=>2],
                                    ],                                 
                                    'remark'=>[
                                        'type'=>Form::INPUT_TEXT,                                    
                                        'columnOptions'=>['colspan'=>4],
                                    ],
        
                            
                                    'actions'=>[
                                        'type'=>Form::INPUT_RAW, 
                                        'value'=>'<br>'.Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary').'  col-centered']),
                                    ],                      
        
                                    
                                ],
                            ]);
                                
                            // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
                            ActiveForm::end();    
                            Pjax::end();                        
                        ?>
                    </div>  <!-- id = "detail_edit"  -->
                  
                    <?= $this->render('_update_pkr_detail', [
                        'model' => $model,
                        //'editmode' => ( ($BD_O or $BD_M)  and !($modelh->user_approve!=null) ),
                        'editmode' => ( ($BD_O or $BD_M)  and ($modelh->user_approve==null) ),
                        'modeld' => $modeld,                        
                    ]) ?>
                </div>
            </div>
        </div>

    </div>
</div>
