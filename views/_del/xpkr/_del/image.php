<?php
use kartik\form\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;

 
$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . ' : '. $modelmaster->doc_no; 
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = $modelmaster->doc_no;
$this->params['breadcrumbs'][] = 'Image' ;
 
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ;
    echo $form->field($model, 'uploadFile')->fileInput(['accept'=>'*.jpg'])->label('Upload Image (.jpg)') ; 
    echo Html::submitButton('Upload', ['class' => 'submit']) ;
            
ActiveForm::end(); 
$image_file = 'images/xpkr/'.$modelmaster->doc_no.'.jpg';

?>               
<br>
<div class="panel panel-primary"  style = <?=(file_exists($image_file))?"":"display:none" ?>>
    <div class="panel-body">    
        <div class="row text-right">
            <div class="col-md-12">                             
            <?= Html::a('Delete',['deleteimage','id'=>$modelmaster->id,'image_file'=>$image_file],[
                    //'class' => 'btn btn-danger '.($modelmaster->user_approve == null? '':'hidden' ),                       
                    'class' => 'btn btn-danger ',
                    'data' => [
                        'method' => 'post',
                    ],                        
                    "data-confirm"=>"ต้องการลบรูปภาพนี้ ?"
                    ]) ?>
            </div>                             
        </div>
        <div class="row">
                <div class="col-md-6 col-md-offset-3 thumbnail">                             
                <?= Html::a(Html::img($image_file),$image_file)?>                     
            </div>
        </div>
    </div>
</div> 