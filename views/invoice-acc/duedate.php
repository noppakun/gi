<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use app\components\XLib;

//use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */

foreach ($model->tableSchema->primaryKey as $col) {
    $pkey = isset($pkey) ? $pkey . '-' . $model[$col] : $model[$col];
}


$scenarios = ($model->scenarios())[$model->getScenario()];
$viewmode = false;
$tablecaption = 'Invoice Due Date [by account]';
$this->title = $tablecaption . (($model->isNewRecord) ? '' : ' : ' . $pkey);
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View' : 'Update'));

$staticOnly = true;

// --------------------------------------------------------------------------
?>
<div class="etable-update">
    <div class="etable-form">
        <div class="panel  panel-primary">
            <div class="panel-heading"><?= $this->title ?>
                <div class="pull-right">
                    <?php
                    $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_VERTICAL
                    ]);


                    echo Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 2,
                        //'staticOnly' => true,
                        'attributes' => [
                            'actions' => ['type' => Form::INPUT_RAW, 'value' => Html::submitButton('Save', ['class' => 'btn btn-success btn-xs'])],

                        ],
                    ]);

                    ?>
                </div>
            </div>
            <div class="panel-body">
                <?php
                // ***AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA


                echo Form::widget([
                    'model' => $invModel,
                    'form' => $form,
                    'columns' => 3,
                    'attributes' => [
                        'CompanyCode' => ['type' => Form::INPUT_STATIC],
                        'Inv_Number' => ['type' => Form::INPUT_STATIC],
                        'Inv_Date' => [
                            'type' => Form::INPUT_STATIC,
                            'staticValue' => function ($model, $index, $widget) {                                
                                return  XLib::dateConv($model->Inv_Date, 'a');
                            }                            
                        ],
                        'Due_Date' => [
                            'type' => Form::INPUT_STATIC,
                            'staticValue' => function ($model, $index, $widget) {                                
                                return  XLib::dateConv($model->Due_Date, 'a');
                            }                            
                        ],                   

                        'Cust_No' => ['type' => Form::INPUT_STATIC],
                        'TotalAmount' => ['type' => Form::INPUT_STATIC],

                        // 'customer.Cust_Name' => [
                        //     'type' => Form::INPUT_STATIC,
                        //     'columnOptions' => ['colspan' => 3],
                        //     'staticValue' => function ($model, $index, $widget) {
                        //         return $model->customer->Cust_Name;
                        //     }

                        // ],


                    ],
                ]);
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 3,
                    'attributes' => [
                        '_cust' => [
                            'label'=>'ชื่อลูกค้า',
                            'type' => Form::INPUT_STATIC,
                            'columnOptions' => ['colspan' => 2],                            
                            'staticValue' => function () use ($invModel) {
                                return $invModel->customer->Cust_Name;
                            }                            
                                       
                        ],                          
                        'due_date_acc' => [
                            'type' => Form::INPUT_WIDGET,
                            //'columnOptions' => ['colspan' => 1],
                            'widgetClass' => 'kartik\date\DatePicker',
                            'options' => [
                                'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',
                                ],
                            ]
                        ],
                         
                    ],
                ]);

                // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>