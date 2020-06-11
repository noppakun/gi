<?php

use kartik\form\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
//use \app\components\XLib;

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

$tablecaption = $TABLECAPTION;
$viewmode = ($model->cancel_user != null);
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


$GLOBALS['BD_M'] = $BD_M;
$GLOBALS['BD_O'] = $BD_O;
$GLOBALS['user_approve_ready'] = $model->user_approve != null;

$GLOBALS['RD_M'] = $RD_M;
$GLOBALS['RD_O'] = $RD_O;
$GLOBALS['model'] = $model;



function typeInput($p_type)
{

    global $user_approve_ready, $BD_O, $BD_M, $model;
    return (
        ($BD_O or $BD_M)
        and !$user_approve_ready
        and ($model->cancel_user == null)) ? $p_type : Form::INPUT_STATIC;
}

function canInputRD_M()
{
    global $RD_M, $model;
    return ($RD_M
        and ($model->user_approve !== null)
        and ($model->user_accept == 'Y')
        and ($model->manager_approve == null)) ? true : false;
}
function typeInputRD_M($p_type)
{
    global $RD_M, $model;
    return ($RD_M
        and ($model->user_approve !== null)
        and ($model->user_accept == 'Y')
        and ($model->manager_approve == null))  ? $p_type : Form::INPUT_STATIC;
}

// AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAaAAAAAAAAAAAAAAAAAAAAAA
// AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAaAAAAAAAAAAAAAAAAAAAAAA
// AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAaAAAAAAAAAAAAAAAAAAAAAA
//app\components\XLib::xprint_r( $model[0] );
// app\components\XLib::xprint_r( $model[0] );
// string get_class ([$model ] )
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
                        'attributes' => [
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
        <?php
        function btnHidden($btn = null)
        {
            global  $model, $BD_O, $BD_M, $RD_O, $RD_M;
            $show = true;
            if (($btn == 'Image') or ($btn == 'Delete')) {
                $show = (($BD_O or $BD_M) and (!$model->isNewRecord)
                    and ($model->user_approve == null));
            } else if ($btn == 'Copy') {
                $show = (($BD_O or $BD_M) and (!$model->isNewRecord));
            } else if ($btn == 'Revise') {
                $show = (($BD_O or $BD_M) and (!$model->isNewRecord));
            } else if ($btn == 'Print') {
                $show = !$model->isNewRecord;
            } else if (($btn == 'Cancel')) {
                $show = (($BD_O or $BD_M) and (!$model->isNewRecord));
            } else if (($btn == 'RDOwner')) {
                $show = (($RD_O or $RD_M) and (!$model->isNewRecord)
                    and ($model->manager_approve != null));
            } else if (($btn == 'NewDone')) {
                $show = (($BD_O or $BD_M) and ($model->bd_approve_request_date == null));
            }


            return $show ? '' : 'hidden';
        }
        ?>
        <div class="panel-body ">
            <div class="row   <?= ($model->cancel_user == null) ? 'hidden' : '' ?>">
                <div class="col-md-12 bg-danger">
                    รายการยกเลิก โดย :
                    <?= $model->cancel_user ?>

                    <?= \app\components\XLib::dateTimeConv($model->cancel_date, 'a') ?>
                    สาเหตุ :
                    <?= $model->cancel_resson ?>
                </div>
            </div>

            <div class="row ">
                <div class="col-md-12 text-right <?= ($model->cancel_user != null) ? 'hidden' : '' ?>">
                    <?= Html::a('', ['print', 'id' => $model->id], [
                        'class' => 'btn btn-warning glyphicon glyphicon-print ' . btnHidden('Print')
                    ]) ?>

   
                    <?= Html::a('', ['newdone', 'id' => $model->id], [
                        'class' => 'btn btn-warning glyphicon glyphicon-ok ' .  btnHidden('NewDone'),
                        "data-confirm" => "พร้อมให้ BD. Approve รายการนี้ ?"
                    ]) ?>

                    <?= Html::a('Image', ['image', 'id' => $model->id], [
                        'class' => 'btn btn-success ' . btnHidden('Image')
                    ]) ?>
                    <?= Html::a('Copy', ['copy', 'id' => $model->id], [
                        'class' => 'btn btn-warning ' .  btnHidden('Copy'),
                        "data-confirm" => "ต้องการสำเนารายการนี้ ?"
                    ]) ?>
                    <?= Html::a('Revise', ['revise', 'id' => $model->id], [
                        'class' => 'btn btn-warning ' .  btnHidden('Revise'),
                        "data-confirm" => "ต้องการ revise รายการนี้ ?"
                    ]) ?>
                    <!-- ยกเลิกการใช้ปุ่ม delete k.jeed 6/9/2019
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger ' .  btnHidden('Delete'),
                        'data' => [
                            'method' => 'post',
                        ],
                        "data-confirm" => "ต้องการลบรายการนี้ ?"
                    ]) ?> -->

                    <?= Html::a('Cancel', ['cancel', 'id' => $model->id], [
                        'class' => 'btn btn-danger ' . btnHidden('Cancel')
                    ]) ?>
                    <?= Html::a('RD. ผู้รับผิดชอบ', ['rdowner', 'id' => $model->id], [
                        'class' => 'btn btn-success ' . btnHidden('RDOwner')
                    ]) ?>

                </div>
            </div>
            <?php
            //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
            // ***AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

            if (Yii::$app->controller->id == 'xpdr') {
                $imag_file = 'images/xpdr/' . $model->doc_no . '.jpg';
                include("_update_pdr.php");
            } else if (Yii::$app->controller->id == 'xpkr') {
                $imag_file = 'images/xpkr/' . $model->doc_no . '.jpg';
                include("_update_pkr.php");
            }

            echo $model->isNewRecord ? '' : '<hr/>' . Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 6,
                'staticOnly' => $model->isNewRecord,
                //'visible'=>!$model->isNewRecord,
                //'visible'=>false,
                'attributes' => [


                    'user_accept' => [
                        //'type' => typeInput(Form::INPUT_RADIO_LIST),
                        'type' => (($model->user_approve !== null) or (!$BD_M)) ? Form::INPUT_STATIC : typeInput(Form::INPUT_RADIO_LIST),
                        'options' => ['inline' => true],
                        'items' => ['Y' => 'Yes', 'N' => 'No'],
                        //'columnOptions'=>['colspan'=>2],  
                        'staticValue' => function ($model, $index, $widget) {
                            return ($model->user_accept == 'Y' ? 'Yes' : ($model->user_accept == 'N' ? 'No' : '-'));
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
                        'value' => Html::submitButton(
                            'Confirm.',
                            [
                                'class' => 'btn btn-success btn-xs ' . ((($model->user_approve !== null) or (!$BD_M)) ? 'hidden' : ''),
                                /* for check in actionUpdate */
                                'name' => 'bt_approve1',


                            ]
                        )
                    ],


                ],
            ]);

            ?>

        </div> <!-- "panel-body" -->
    </div> <!-- panel -->
    <div class="panel panel-primary" style = <?= (($model->user_approve != null)) ? "" : "display:none" ?>>
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
                        'options' => ['inline' => true],
                        'type' => typeInputRD_M(Form::INPUT_RADIO_LIST),
                        'items' => ['Y' => 'Yes', 'N' => 'No'],
                        // 'columnOptions'=>['colspan'=>2],  
                        'staticValue' => function ($model, $index, $widget) {
                            return ($model->manager_accept == 'Y' ? 'Yes' : ($model->manager_accept == 'N' ? 'No' : '-'));
                        }
                    ],
                    'manager_remark' => [

                        'type' => typeInputRD_M(Form::INPUT_TEXT),
                        'columnOptions' => ['colspan' => 5]
                    ],
                    'manager_approve' => ['type' => Form::INPUT_STATIC],
                    'manager_approve_date' => ['type' => Form::INPUT_STATIC],

                    'actions' => [
                        'type' => Form::INPUT_RAW,
                        'value' => Html::submitButton('Confirm', [
                            'class' => 'btn btn-success btn-xs ' . (!canInputRD_M() ? 'hidden' : ''),
                            // // 1111111111111111111111111111111111111111111111111111111111111                                                            
                            'name' => 'bt_approve2',
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