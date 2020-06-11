<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */
$viewmode=true;
$tablecaption = '$TABLECAPTION';
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
                'Item_Number'=>[
                    'type'=>Form::INPUT_TEXT,
                ],
                'Item_Name'=>[
                    'type'=>Form::INPUT_TEXT,
                    'columnOptions'=>['colspan'=>2],                                    
                  
                ],              
            ],
        ]);
  
            
        // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
        ActiveForm::end();    
  
              
    ?>
      </div></div></div>
    </div>
</div>

 