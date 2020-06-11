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



// $BD_O = (1==1);
// $BD_M = (1==1);

// $RD_O = (1==1);
// $RD_M = (1==1);

// app\components\XLib::xprint_r( $BD_O );
// app\components\XLib::xprint_r( $BD_M );
// app\components\XLib::xprint_r( $RD_O );
// app\components\XLib::xprint_r( $RD_M );
//app\components\XLib::xprint_r( $VIEWPARA );

$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord) ? '' : ' : ' . $model->doc_no);
$this->params['breadcrumbs'][] = ['label' => $tablecaption,  'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View' : 'Update'))
    . ' ( '
    . ($BD_O ? "BD_O " : ' ')
    . ($BD_M ? "BD_M " : ' ')
    . ($RD_O ? "RD_O " : ' ')
    . ($RD_M ? "RD_M " : ' ') . ' )';

$staticOnly = true;
$staticOnly = $viewmode;



$GLOBALS['BD_O'] = $BD_O;
$GLOBALS['BD_M'] = $BD_M;
$GLOBALS['user_approve_ready'] = $model->user_approve != null;


$GLOBALS['RD_M'] = $RD_M;
$GLOBALS['model'] = $model;



function typeInput($p_type)
{
    global $user_approve_ready, $BD_O, $BD_M;
    return (($BD_O or $BD_M)  and !$user_approve_ready) ? $p_type : Form::INPUT_STATIC;
}

function canInputRD_M()
{
    global $RD_M,$model;    
    return (
        $RD_M
        and ($model->user_approve!==null)
        and ($model->user_accept =='Y')                            
        and ($model->manager_approve ==null)                            
    ) ? true : false;
}
function typeInputRD_M($p_type)
{        
    global $RD_M,$model;
    return (
        $RD_M
        and ($model->user_approve!==null)
        and ($model->user_accept =='Y')                            
        and ($model->manager_approve ==null)                            
    )  ? $p_type : Form::INPUT_STATIC;    
}
           

?>

<div class="etable-form">
    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
    ?>
    <div class="panel  panel-primary">
        <div class="panel-heading">
            <?= $this->title ?>
            <div class="pull-right">
                <?php


                if (!$viewmode) {
                    echo Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 2,
                        //'staticOnly'=>$staticOnly,
                        //'staticOnly'=>true,
                        'attributes' => [ //                            Html::a('<i class="glyphicon glyphicon-picture"></i>', $url):null;                            
                            'actions' => [
                                'type' => Form::INPUT_RAW,
                                'value' => Html::submitButton(
                                    'Save',
                                    [
                                        'class' => 'btn btn-success btn-xs',

                                        // v.1
                                        //'disabled'=>!($BD_O or $BD_M or ($model->user_approve!=null)),
                                        // v2
                                        'disabled' => !(($BD_O or $BD_M)  and !($model->user_approve != null)),
                                        // // 1111111111111111111111111111111111111111111111111111111111111                                  
                                        'name' => 'bt_save',
                                        'value' => 'bt_save10',



                                    ]
                                ),                                
                            ],
                        ],
                        //($BD_O or $BD_M)
                    ]);
                }

                ?>
            </div>
        </div>

        <div class="panel-body">
            <div class="row <?= (($BD_O or $BD_M) ? '' : 'hidden') ?>">

                <div class="col-md-12 text-right ">
                    <?= Html::a('Image', ['image', 'id' => $model->id], [
                        'class' => 'btn btn-success ' . ($model->user_approve == null ? '' : 'hidden')
                    ]) ?>
                    <?= Html::a('Copy', ['copy', 'id' => $model->id], [
                        'class' => 'btn btn-warning ',
                        "data-confirm" => "ต้องการสำเนารายการนี้ ?"
                    ]) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger ' . ($model->user_approve == null ? '' : 'hidden'),
                        'data' => [
                            'method' => 'post',
                        ],
                        "data-confirm" => "ต้องการลบรายการนี้ ?"
                    ]) ?>

                </div>
            </div>
            <?php

            // ***AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA


            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 3,
                //'staticOnly'=>$staticOnly,                    
                'attributes' => [
                    'doc_no' => [
                        'type' => Form::INPUT_STATIC,
                    ],
                    'doc_date' => [
                        //'type'=>Form::INPUT_WIDGET,                      
                        'type' => Form::INPUT_STATIC,
                        'widgetClass' => 'kartik\date\DatePicker',
                        'options' => [
                            'pluginOptions' => [
                                'format' => 'dd-mm-yyyy',
                            ],
                        ]
                    ],
                    'cust_no' => [
                        //'type'=>typeInput(Form::INPUT_TEXT),    
                        'type' => typeInput(Form::INPUT_TEXT),
                        'staticOnly' => ($model->user_approve != null),
                    ],
                ]
            ]);



            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'attributes' => [
                    'cust_name' => [
                        'type' => typeInput(Form::INPUT_TEXT),
                        //'columnOptions'=>['colspan'=>3],
                    ],
                    'product_name' => [
                        'type' => typeInput(Form::INPUT_TEXT),
                        //'columnOptions'=>['colspan'=>3],
                    ],

                ],
            ]);

            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 3,
                //'staticOnly'=>$model->user_approve!=null ,
                'attributes' => [
                    'product_cat' => [
                        //'type'=>Form::INPUT_DROPDOWN_LIST,                            
                        'type' => typeInput(Form::INPUT_DROPDOWN_LIST),

                        // 'type'=>function () use ($approve1_ready){
                        //     return ($approve1_ready?Form::INPUT_STATIC:Form::INPUT_DROPDOWN_LIST);
                        // },
                        'items' => \app\models\xpdr::$product_cat_LIST,
                        'staticValue' => function ($model, $index, $widget) {
                            return (\app\models\xpdr::$product_cat_LIST[$model->product_cat]);
                        }
                    ],
                    'product_cat_other' => [
                        'type' => typeInput(Form::INPUT_TEXT),
                        'columnOptions' => ['colspan' => 2],
                    ],
                ],
            ]);
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                //'staticOnly'=>$model->user_approve!=null ,
                'attributes' => [
                    'description' => ['type' => typeInput(Form::INPUT_TEXT)],
                    'active_ingredients' => ['type' => typeInput(Form::INPUT_TEXT)],
                    'appearance' => ['type' => typeInput(Form::INPUT_TEXT)],
                    'color' => ['type' => typeInput(Form::INPUT_TEXT)],
                    'taste' => ['type' => typeInput(Form::INPUT_TEXT)],
                    'odor' => ['type' => typeInput(Form::INPUT_TEXT)],
                    'viscosity' => ['type' => typeInput(Form::INPUT_TEXT)],
                    'bubble' => ['type' => typeInput(Form::INPUT_TEXT)],
                    'other' => ['type' => typeInput(Form::INPUT_TEXT)],
                    'benchmark' => ['type' => typeInput(Form::INPUT_TEXT)],
                    'feeling_after_use' => ['type' => typeInput(Form::INPUT_TEXT)],
                    'target_group' => ['type' => typeInput(Form::INPUT_TEXT)],
                ],
            ]);
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                //'staticOnly'=>$staticOnly,
                'columns' => 12,
                'attributes' => [
                    'size_text' => [
                        'type' => typeInput(Form::INPUT_TEXT),
                        'columnOptions' => ['colspan' => 3],
                    ],
                                  
                    'order_text' => [
                        'type' => typeInput(Form::INPUT_TEXT),
                        'columnOptions' => ['colspan' => 9],
                    ],

                                        
                ],
            ]);
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                //'staticOnly'=>$staticOnly,
                'columns' => 3,
                'attributes' => [
                    'sample_req_date' => [
                        'type' => typeInput(Form::INPUT_WIDGET),
                        'widgetClass' => 'kartik\date\DatePicker',
                        'options' => [
                            'pluginOptions' => [
                                'format' => 'dd-mm-yyyy',
                            ],
                        ],
                        'staticValue' => function ($model, $index, $widget) {
                            return XLib::dateConv($model->sample_req_date, 'a');
                        }
                    ],
                    'price_req_date' => [
                        'type' => typeInput(Form::INPUT_WIDGET),
                        'widgetClass' => 'kartik\date\DatePicker',
                        'options' => [
                            'pluginOptions' => [
                                'format' => 'dd-mm-yyyy',
                            ],
                        ]
                    ],

                    //
                    'user_inform' => ['type' => Form::INPUT_STATIC],
                     


                ],
            ]);

            echo $model->isNewRecord ? '' : '<hr/>' . Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 6,
                'staticOnly' => $model->isNewRecord,
                //'visible'=>!$model->isNewRecord,
                //'visible'=>false,
                'attributes' => [


                    'user_accept' => [
                        'type' => typeInput(Form::INPUT_RADIO_LIST),
                        'options' => ['inline' => true],
                        'items' => ['Y' => 'Yes', 'N' => 'No'],
                        //'columnOptions'=>['colspan'=>2],  
                        'staticValue' => function ($model, $index, $widget) {
                            return ($model->user_accept == 'Y' ? 'Yes' : ($model->user_accept == 'N'?'No':'-'));
                        }
                    ],
                    'user_remark' => [                        
                        'type' => (($model->user_approve !== null) or (!$BD_M)) ? Form::INPUT_STATIC : Form::INPUT_TEXT,
                        'columnOptions' => ['colspan' => 5]
                    ],

                    'user_approve' => ['type' => Form::INPUT_STATIC],
                    'user_approve_date' => ['type' => Form::INPUT_STATIC],

                    'actions' => [
                        'type' => Form::INPUT_RAW,
                        'value' => Html::submitButton (
                            'Confirm1',
                            [
                                'class' => 'btn btn-success btn-xs',
                                'disabled' => (($model->user_approve !== null) or (!$BD_M)),
                                //111111111111111111111111111111111111111111111111111111111111111111                                
                                //'name'=>'bt_approve1',
                                'name' => 'bt_approve1',
                                //'value' => 'bt_save20',

                            ]
                        )
                    ],


                ],
            ]);

            ?>

        </div> <!-- "panel-body" -->
    </div> <!-- panel -->
    <div class="panel panel-primary" style=<?= (($model->user_approve != null)) ? "" : "display:none" ?>>
        <div class="panel-heading">
            ตอบรับงานวิจัยและพัฒนาผลิตภัณฑ์
        </div>
        <div class="panel-body">
            <?php
            //xxxxxxxxxxxxxxxxxxx'type'=>typeInput(Form::INPUT_TEXT),
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 6,
                //'staticOnly'=>$model->user_approve!=null ,
                'attributes' => [


                    'manager_accept' => [
                        //'type'=>$model->manager_accept=='Y'?Form::INPUT_STATIC:Form::INPUT_DROPDOWN_LIST,                            
                        //'type'=>($model->manager_approve!==null)?Form::INPUT_STATIC:Form::INPUT_DROPDOWN_LIST,                            
                        //'type' => typeInput(Form::INPUT_DROPDOWN_LIST),                        
                        //'type' => typeInput(Form::INPUT_RADIO_LIST),
                        'options' => ['inline' => true],
                        'type' => typeInputRD_M(Form::INPUT_RADIO_LIST),
                        // 'type'=>(
                        //         $RD_M
                        //         and ($model->user_approve!==null)
                        //         and ($model->user_accept =='Y')                            
                        //         and ($model->manager_approve ==null)                            
                        //     ) 
                        //     ? Form::INPUT_DROPDOWN_LIST 
                        //     : Form::INPUT_STATIC,                            
                        'items' => ['Y' => 'Yes', 'N' => 'No'],
                        // 'columnOptions'=>['colspan'=>2],  
                        'staticValue' => function ($model, $index, $widget) {
                            return ($model->manager_accept == 'Y' ? 'Yes' : ($model->manager_accept == 'N'?'No':'-'));
                        }
                    ],
                    'manager_remark' => [

                        //'type'=>$model->manager_accept=='Y'?Form::INPUT_STATIC:Form::INPUT_TEXT,                            
                        //'type'=>($model->manager_approve!==null)?Form::INPUT_STATIC:Form::INPUT_TEXT,    
                        'type' => typeInputRD_M(Form::INPUT_TEXT),
                        'columnOptions' => ['colspan' => 5]
                    ],
                    'manager_approve' => ['type' => Form::INPUT_STATIC],
                    'manager_approve_date' => ['type' => Form::INPUT_STATIC],

                    'actions' => [
                        'type' => Form::INPUT_RAW,
                        'value' => Html::submitButton('Confirm', [
                            'class' => 'btn btn-success btn-xs',
                            //'disabled'=>($model->manager_approve!==null),    
                            'disabled' => !canInputRD_M(),
                            // // 1111111111111111111111111111111111111111111111111111111111111                                                            
                            'name' => 'bt_approve2',
                            

                            //"style"=>"display: none;",
                            ////and ($model->manager_approve==null)
                        ])
                    ],


                ],
            ]);
            ?>
        </div>
    </div>

    <!-- ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB -->
    <?php
    ActiveForm::end();

    $imag_file = 'images/xpdr/' . $model->doc_no . '.jpg';
    ?>


    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 thumbnail">
                    <?= Html::a(Html::img($imag_file), $imag_file) ?>
                </div>
            </div>
        </div>
    </div>
</div>