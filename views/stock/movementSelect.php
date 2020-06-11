<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\date\DatePicker;
use app\widgets\se2CompanyItem;
use app\widgets\se2DocType;
$this->title = 'รายงานการเคลื่อนไหวสินค้า';
$this->params['breadcrumbs'][] = $this->title;

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
        <div class="col-md-2 col-sm-2 col-xs-5">   
            <?= se2CompanyItem::widget(['form' => $form, 'model' => $SelectForm, 
                'field' => 'co_code',
                'showToggleAll'=>false,
                //'selectAll'=>true,
                //'idFilter' => $SelectForm->var3
            ])?>        
        </div>  
        <div class="col-md-3 col-sm-3 col-xs-6">   
            <?= se2DocType::widget(['form' => $form, 'model' => $SelectForm, 
                'field' => 'doctype',
                'showToggleAll'=>false,
                //'selectAll'=>true,
                //'idFilter' => $SelectForm->var3
            ])?>        
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


      

 

?>
   