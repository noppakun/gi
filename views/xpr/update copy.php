<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use \app\components\XLib;



/* @var $this yii\web\View */
/* @var $model app\models\Araptran */

$tablecaption = $TABLECAPTION;
//$this->title = $tablecaption . (($model->isNewRecord) ? '' : ' : ' . $model->doc_no);
$this->title = $tablecaption . ' : ' . $model->doc_no;
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View' : 'Update'));


//$staticOnly = $viewmode;


$staticOnly = ($model->review_user != null);
//$staticOnly = true;
$viewmode = $staticOnly;





$review_deptcode_list = \app\models\XPrSearchByUser::review_deptcode_list();

$_model = $model->attributes;
$_model['id'] = trim($model->doc_no);
$_model = json_encode($_model);
//--$a->id=999;
echo '<pre>';

print_r($_model);
echo '</pre>';
/*
 
<!-- <input type='hidden' id='mastermodel' value='<?= json_encode(
    [
        'id' => $model->doc_no,
        'vat_type' => $model->vat_type,
        'vat_percent' => $model->vat_percent,
    ]
) ?>' />
-->
*/
$GLOBALS['model'] = $model;
$GLOBALS['review_deptcode_list'] = $review_deptcode_list;

?>


<div id="app">
    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
    ]);    ?>
<!-- 
    <input type='hidden' id='mastermodel' value='<?= json_encode($_model) ?>' />
 -->

<input type='hidden' id='mastermodel' value='<?= json_encode(
    [
        'id' => $model->doc_no,
        'vat_type' => $model->vat_type,
        'vat_percent' => $model->vat_percent,
    ]
) ?>' />

    <div class="panel  panel-primary">
        <div class="panel-heading" id='xform1'><?= $this->title ?>
            <div class="pull-right">
                <?php

                if (!$viewmode) {
                    echo Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 2,
                        'staticOnly' => $staticOnly,
                        'attributes' => [
                            'actions' => ['type' => Form::INPUT_RAW, 'value' => Html::submitButton('Save', ['class' => 'btn btn-success btn-xs'])],
                        ],
                    ]);
                }
                ?>
            </div>
        </div>
        <?php
        function btnHidden($btn = null)
        {
            global  $model, $review_deptcode_list;
            $show = true;

            if ($btn == 'review') {
                $show = (
                    (in_array($model->dept_code, $review_deptcode_list))
                    and (!$model->isNewRecord)
                    and (!$model->review_user));
            } else if ($btn == 'approve') {
                $show = (
                    (\Yii::$app->user->can('/@XPR/APPROVE'))
                    and (!$model->isNewRecord))
                    and ($model->review_user);
            }


            return $show ? '' : 'hidden';
        }
        ?>
        <div class="panel-body">

            <input type='hidden' id='modeldjson' v-model='JSON.stringify(items)' name='modeldjson' />
            <input type='hidden' id='vat_amount' v-model='vat_amount' name='XPr[vat_amount]' />
            <input type='hidden' id='amount' v-model='amount' name='XPr[amount]' />
            <input type='hidden' id='total_amount' v-model='total_amount' name='XPr[total_amount]' />

            <div class="row ">
                <div class="col-md-12 text-right">
                    <?= Html::a('Review', ['docaction', 'id' => $model->doc_no, 'action' => 'review'], [
                        'class' => 'btn btn-warning ' .  btnHidden('review'),
                        "data-confirm" => "ต้องการ Review รายการนี้ ?"
                    ]) ?>
                    <?= Html::a('Approve', ['docaction', 'id' => $model->doc_no, 'action' => 'approve'], [
                        'class' => 'btn btn-warning ' .  btnHidden('approve'),
                        "data-confirm" => "ต้องการ Approve รายการนี้ ?"
                    ]) ?>
                </div>
            </div>
            <?php
            // ***AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA


            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 6,
                'staticOnly' => $staticOnly,



                'attributes' => [
                    'doc_no' => [
                        'type' => Form::INPUT_STATIC,

                    ],
                    'doc_date' => [
                        'type' => Form::INPUT_STATIC,

                    ],
                    'dept_code' => [
                        'type' => Form::INPUT_STATIC,
                        'staticValue' => function ($model) {
                            $r = app\models\Depart::find()->where(['DeptCode' => $model->dept_code])->one();
                            $dname = ($r) ? $r->DeptName : '';
                            return $dname;
                        },
                        'columnOptions' => ['colspan' => 2],
                    ],
                    'ref_doc_no' => [
                        'type' => Form::INPUT_TEXT,
                        'columnOptions' => ['colspan' => 2],
                    ],
                ],
            ]);

            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 6,
                'staticOnly' => $staticOnly,
                'attributes' => [
                    'supp_name' => [
                        'type' => Form::INPUT_TEXT,
                        'columnOptions' => ['colspan' => 3],
                    ],
                    'shipto' => [
                        'type' => Form::INPUT_TEXT,
                        'columnOptions' => ['colspan' => 3],
                    ],
                    'remark' => [
                        'type' => Form::INPUT_TEXT,
                        'columnOptions' => ['colspan' => 3],
                        //'label' => 'อัตรารับของเกิน',
                    ],

                    'vat_percent' => [
                        'type' => Form::INPUT_TEXT,
                        'columnOptions' => ['colspan' => 1],
                        'options' => [
                            '@change' => 'onVat_percentChange(this)',
                            //'v-model'=>'vat_percent' 
                        ]
                        //'label' => 'อัตรารับของเกิน',
                    ],
                    'vat_type' => [

                        'type' => Form::INPUT_RADIO_LIST,
                        'items' => ['i' => 'รวมภาษี', 'e' => 'ไม่รวมภาษี'],
                        'options' => [
                            //'id' => 'vat_type',
                            'inline' => true,
                            '@click' => 'onVat_typeClick(this)'
                        ],
                        'columnOptions' => [
                            'colspan' => 2,

                        ],
                        'staticValue' => function ($model, $index, $widget) {
                            return ($model->vat_type == 'i' ? 'รวมภาษี' : 'ไม่รวมภาษี');
                        }
                    ],
                ],
            ]);

            // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
            ActiveForm::end();
            ?>
        </div>

        <div class="table-responsive" id="table_detail">
            <table class="table table-hover table-condensed ">
                <thead class="text-primary">
                    <tr>
                        <!-- <th>Id</th> -->
                        <th width='50%'>รายละเอียด</th>
                        <th style="text-align:right;width:120px">ราคาต่อหน่วย</th>
                        <th style="text-align:right;width:80px">จำนวน</th>
                        <th>หน่วย</th>
                        <th style="text-align:right;width:120px">รวม</th>
                        <th>หมายเหตุ</th>
                        <th style="text-align:center; <?= ($staticOnly) ? 'display:none' : '' ?>">
                            <a class="btn  btn-xs btn-default glyphicon glyphicon-plus" @click="onClickCreate" data-toggle="modal" data-target="#myModal"></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template>
                        <tr v-if="item.rec_status!=='d'" v-for="(item, index)  in items" :item-id="item.id">
                            <template>
                                <!-- <td>{{item.id}} - {{item.rec_status}}</td> -->
                                <td>{{item.item_desc}}</td>
                                <td style="text-align:right">{{item.price| numeral('0,0.00') }}</td>
                                <td style="text-align:right">{{item.qty| numeral('0,0.00') }}</td>
                                <td>{{item.uom}}</td>
                                <td style="text-align:right">{{item.qty*item.price| numeral('0,0.00') }}</td>
                                <td> {{item.remark}}</td>
                                <td style="text-align:center; <?= ($staticOnly) ? 'display:none' : '' ?>">
                                    <a class="btn btn-xs  btn-default glyphicon glyphicon-edit" @click="onClickEdit(item)" data-toggle="modal" data-target="#myModal"></a>
                                    <a class="btn btn-xs  btn-default glyphicon glyphicon-trash" @click="onClickDelete(item)"></a>
                                </td>
                            </template>

                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <div class="row">
                <!-- <div class="col-md-3  text-right">อัตราภาษี : {{vat_percent| numeral('0,0.00')}}%</div> -->
                <div class="col-md-6  text-right">รวมมูลค่าสินค้า : {{amount| numeral('0,0.00')}}</div>
                <div class="col-md-3  text-right">จำนวนภาษีมูลค่าเพิ่ม : {{vat_amount| numeral('0,0.00')}}</div>
                <div class="col-md-3  text-right">จำนวนเงินรวมทั้งสิ้น : {{total_amount| numeral('0,0.00')}}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= 'prepare : ' . $model->prepare_user . '@' . XLib::dateTimeConv($model->prepare_date, 'a') ?>
        </div>
        <div class="col-md-3" style="text-align:left; <?= !($model->review_user) ? 'display:none' : '' ?>">
            <?= 'review : ' . $model->review_user . '@' . XLib::dateTimeConv($model->review_date, 'a') ?>
        </div>
        <div class="col-md-3" style="text-align:left; <?= !($model->approve_user) ? 'display:none' : '' ?>">
            <?= 'approve : ' . $model->approve_user . '@' . XLib::dateTimeConv($model->approve_date, 'a') ?>
        </div>


    </div>


    <!-- <div class="panel  panel-primary">
        <div class="panel-body"> -->

    <!-- -------------------------------------------------------------------------------------- -->
    <!--    Modal   aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa -->
    <!-- -------------------------------------------------------------------------------------- -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"> {{itemEdit.id}}</h4>
                </div> -->
                <div class="modal-body">
                    <input type="hidden" v-model="itemEdit.id">
                    <?php // https://demos.krajee.com/builder-details/form
                    echo Form::widget([
                        'formName' => 'kvform',
                        'columns' => 2,
                        'attributes' => [
                            'item_desc' => [
                                'label' => 'รายละเอียด',
                                'columnOptions' => ['colspan' => 2],
                                'options' => [
                                    'id' => 'itemEdit.item_desc',
                                    'v-model' => "itemEdit.item_desc"
                                ]
                            ],
                        ]
                    ]);
                    echo Form::widget([
                        'formName' => 'kvform',
                        'columns' => 3,
                        'attributes' => [
                            'price' => [
                                'label' => 'ราคา',
                                'options' => ['v-model' => "itemEdit.price"]
                            ],
                            'qty' => [
                                'label' => 'จำนวน',
                                'options' => ['v-model' => "itemEdit.qty"]
                            ],
                            'uom' => [
                                'label' => 'หน่วย',
                                'options' => ['v-model' => "itemEdit.uom"]
                            ],
                            'remark' => [
                                'label' => 'หมายเหตุ',
                                'columnOptions' => ['colspan' => 3],
                                'options' => ['v-model' => "itemEdit.remark"]
                            ],
                        ]
                    ]);
                    ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click="onClickDone">Done</button>
                </div>
            </div>
        </div>
    </div>
    <!--    Modal   bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb -->
    <!-- 
    {{vat_percent}}
    {{vat_type}} -->

</div><!-- app id  -->


<?php
// For prototyping 
//$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue@2.6.11", ['position' => $this::POS_END]);

// For production
$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue/dist/vue.js", ['position' => $this::POS_END]);
$this->registerJsFile("https://unpkg.com/axios/dist/axios.min.js", ['position' => $this::POS_END]);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue-numeral-filter/dist/vue-numeral-filter.min.js", ['position' => $this::POS_END]);

$this->registerJsFile("js/views/xpr/update.js", ['position' => $this::POS_END]);

?>