<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\tabs\TabsX;

use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */


$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . ' : ' . $model->doc_no;
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->doc_no, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = strtoupper(Yii::$app->controller->action->id);

 


if(Yii::$app->controller->action->id=='rdowner'){
    echo Html::hiddenInput('page', $page);
    $attributes = [
        'rd_owner' => [
            'type' => Form::INPUT_DROPDOWN_LIST,
            'items' => $rdOwnerList,
        ],
        // 'page' => [
        //     'type' => Form::INPUT_HIDDEN_STATIC,            
        // ],        
        'actions' => [
            'type' => Form::INPUT_RAW,
            'value' => Html::submitButton('Save', ['class' => 'btn btn-warning ']),
            'columnOptions' => ['colspan' => 4]
        ],
    ];
} else { // if(Yii::$app->controller->action->id=='cancel'){
    $attributes = [
        'cancel_resson' => [
            'type' => Form::INPUT_TEXT,
            'columnOptions' => ['colspan' => 4]
        ],
        'actions' => [
            'type' => Form::INPUT_RAW,
            'value' => Html::submitButton('ยืนยันการยกเลิก', ['class' => 'btn btn-warning '])
        ],
    ];
}



?>
<div class="etable-update">
    <div class="etable-form">
        <div class="panel  panel-primary">
            <div class="panel-heading"><?= $this->title ?>
                <div class="pull-right">
                    <?php
                    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
                    ?>
                </div>
            </div>
            <div class="panel-body">
                <?php
                // ***AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
    
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 4,                    
                    'attributes' => $attributes,
                ]);

                // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>