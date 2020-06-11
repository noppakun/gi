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

$staticOnly = true;
$staticOnly = $viewmode;
$staticOnly = ($model->review_user != null);

$review_deptcode_list = \app\models\XPrSearchByUser::review_deptcode_list();
$GLOBALS['model'] = $model;
$GLOBALS['review_deptcode_list'] = $review_deptcode_list;

?>


<div id="app">
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);    ?>
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
                            //'class' => "radio-inline"
                        ],
                    ],
                ],
            ]);

            // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
            ActiveForm::end();
            ?>

        </div>

        <div class="table-responsive" id="table_detail">
            <table class="table">
                <thead>
                    <tr>
                        <!-- <th>Id</th> -->
                        <th width='50%'>รายละเอียด</th>
                        <th>ราคาต่อหน่วย</th>
                        <th>จำนวน</th>
                        <th>หน่วย</th>
                        <th>รวม</th>
                        <th>หมายเหตุ</th>
                        <th style=<?= ($model->review_user == null) ? "" : "display:none" ?>>
                            <a class="btn  btn-xs btn-default glyphicon glyphicon-plus" @click="onClickCreate" data-toggle="modal" data-target="#myModal"></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index)  in displayedItems">
                        <!-- 
                <td v-for="itemfield in headers">{{item[itemfield.value]}}</td> -->
                        <template v-if="item.rec_status!=='d'">
                            <!-- <td>{{item.id}}{{item.rec_status}}</td> -->
                            <td>{{item.item_desc}}</td>
                            <td style="text-align:right">{{item.price| numeral('0,0.00') }}</td>
                            <td style="text-align:right">{{item.qty| numeral('0,0.00') }}</td>
                            <td>{{item.uom}}</td>
                            <td style="text-align:right">{{item.qty*item.price| numeral('0,0.00') }}</td>
                            <td>{{item.remark}}</td>
                            <td style=<?= ($model->review_user == null) ? "" : "display:none" ?>>
                                <a class="btn btn-xs  btn-default glyphicon glyphicon-edit" @click="onClickEdit(item)" data-toggle="modal" data-target="#myModal"></a>
                                <a class="btn btn-xs  btn-default glyphicon glyphicon-trash" @click="onClickDelete(item)"></a>
                            </td>
                        </template>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-footer">

            <!-- vat_percent: 7,
                vat_amount: 0,
                amount: 0,
                total_amount: 0, -->

            <div class="row">
                <!-- <div class="col-md-3  text-right">อัตราภาษี : {{vat_percent| numeral('0,0.00')}}%</div> -->
                <div class="col-md-6  text-right">รวมมูลค่าสินค้า : {{amount| numeral('0,0.00')}}</div>
                <div class="col-md-3  text-right">จำนวนภาษีมูลค่าเพิ่ม : {{vat_amount| numeral('0,0.00')}}</div>
                <div class="col-md-3  text-right">จำนวนเงินรวมทั้งสิ้น : {{total_amount| numeral('0,0.00')}}</div>




            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">

            <?= 'prepare : ' . $model->prepare_user . '@' . XLib::dateTimeConv($model->prepare_date, 'a')
                . '<br>review : ' . $model->review_user . '@' . XLib::dateTimeConv($model->review_date, 'a')
                . '<br>approve : ' . $model->approve_user . '@' . XLib::dateTimeConv($model->approve_date, 'a')
            ?>
        </div>
        <div class="col-md-6  text-right">
            <paginate v-if="pageCount > 1" :page-count="pageCount" :container-class="'pagination'" :click-handler="onClickPage"></paginate>

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
                    <?php // https://demos.krajee.com/builder-details/form
                    echo Form::widget([
                        'formName' => 'kvform',
                        'columns' => 2,
                        'attributes' => [
                            'item_desc' => [
                                'label' => 'รายละเอียด',
                                'columnOptions' => ['colspan' => 2],
                                'options' => [
                                    'id' => 'item_desc',
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

    {{vat_percent}}
    {{vat_type}}

</div><!-- app id  -->
<?php


//   echo '<pre>';
//   //print_r($u->xEmployeeExt->employee_code);
//   //print_r($u->employee->DeptCode);
//   print_r(XUser::findOne(Yii::$app->user->identity->id)->employee->DeptCode);

//   echo '</pre>';

$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue@2.6.11", ['position' => $this::POS_HEAD]);
$this->registerJsFile("https://unpkg.com/vuejs-paginate@latest", ['position' => $this::POS_HEAD]);
$this->registerJsFile("https://unpkg.com/axios/dist/axios.min.js", ['position' => $this::POS_HEAD]);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue-numeral-filter/dist/vue-numeral-filter.min.js", ['position' => $this::POS_HEAD]);

?>

<script>
    var app = new Vue({
        el: '#app',
        components: {
            'paginate': VuejsPaginate,
        },
        data() {
            return {
                displayedItems: [],
                //------------
                pageCount: 0,
                totalRows: 0,
                perPage: 5,
                currentPage: 1,
                //------------                
                items: [],
                itemDefault: {},
                //itemEdit: {},
                itemEdit: {
                    id: 0,
                    // -------------------
                    item_desc: '',
                    qty: 0,
                    uom: '',
                    price: 0,
                    remark: '',

                },

                vat_type: '',
                vat_percent: 0,
                vat_amount: 0,
                amount: 0,
                total_amount: 0,


            }
        },

        async mounted() {
            //async created() {
            var mastermodel = JSON.parse(document.getElementById("mastermodel").value)

            this.vat_type = mastermodel.vat_type
            this.vat_percent = mastermodel.vat_percent
            


            let vm = this
            //var _v = new Object();
            //console.log(e1.value)
            //await axios.get('index.php?r=/xpr/api_detail&id=' + e1.value)            
            await axios.get('?r=/xpr/api_detail&id=' + mastermodel.id)
                //await axios.get('?r=/xpr/api_detail&id=12')            
                .then(r => {
                    //console.log( r.data.rows)
                    vm.items = r.data.rows
                    vm.itemDefault = r.data.row
                    vm.itemDefault.id = 0
                    vm.itemDefault.rec_status = ''
                    // Object.assign(_v, vm.itemDefault)
                    // Object.assign(vm.itemEdit,_v)
                });
            this.calDisplayedItems()
        },
        filters: {
            formatNumber(value) {
                return new Intl.NumberFormat().format(value)
                //return numeral(value).format("0,0"); // displaying other groupings/separators is possible, look at the docs
            }
        },

        methods: {

            onVat_percentChange(e) {
                this.vat_percent = e.event.target.value
                this.calDisplayedItems()
            },
            onVat_typeClick(e) {
                this.vat_type = e.event.target.value
                this.calDisplayedItems()
            },
            // display aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
            calTotalAmt() {
                var _price
                this.amount = 0
                this.total_amt = 0
                this.items.forEach(r => {
                    if (r.rec_status !== 'd') {
                        this.amount = this.amount + Math.round(r.qty * r.price * 100) / 100;
                    }
                })

                this.vat_amount = (this.vat_type == 'i') ?
                    (this.amount * this.vat_percent / (100 + this.vat_percent)) :
                    (this.amount * (this.vat_percent / 100))

                this.amount = (this.vat_type == 'i') ?
                    this.amount - this.vat_amount :
                    this.amount

                this.total_amount = this.amount + this.vat_amount

            },
            calDisplayedItems() {
                this.calTotalAmt()

                let _items = this.items.filter(r => r.rec_status !== 'd')
                this.totalRows = _items.length
                this.pageCount = Math.ceil(this.totalRows / this.perPage);
                this.displayedItems = _items.slice(
                    (this.currentPage * this.perPage) - this.perPage,
                    (this.currentPage * this.perPage)
                );
            },
            paginate(_items) {
                //console.log('-------------paginate----')
                return _items.slice(
                    (this.currentPage * this.perPage) - this.perPage,
                    (this.currentPage * this.perPage)
                );
            },
            onClickPage(pageNum) {
                this.currentPage = pageNum
                this.calDisplayedItems();
            },
            // display bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb
            onClickDelete(para) {
                //console.log('-------------onClickDelete----',para)
                let i = this.items.findIndex((e) => (e.id == para.id))
                if (this.items[i].rec_status == 'n') {
                    this.items.splice(i, 1)
                } else {
                    this.items[i].rec_status = 'd'
                }
                this.calDisplayedItems();
            },
            onClickCreate() {
                //     id: 0,
                //console.log(this.itemDefault)
                //console.log(this.itemEdit)

                Object.assign(this.itemEdit, this.itemDefault)
                //this.$refs.itemE.focus();
                //console.log(this.$refs.itemE)                
            },
            onClickEdit(_item) {
                //console.log('-------onClickEdit---------') 
                Object.assign(this.itemEdit, _item)
            },
            onClickDone() {
                //console.log('-------onClickDone---------', this.items.length)
                if (this.itemEdit.id == 0) { // Create                    
                    this.itemEdit.id = -(this.items.filter(r => r.rec_status !== 'a').length + 1)
                    this.itemEdit.rec_status = 'n'
                    let _v = new Object();
                    Object.assign(_v, this.itemEdit)
                    this.items.push(_v)
                    this.calDisplayedItems()
                } else { // update
                    let _i = this.items.findIndex((e) => (e.id == this.itemEdit.id))
                    //console.log(i)
                    if (this.itemEdit.id > 0) {
                        this.itemEdit.rec_status = 'e'
                    }
                    Object.assign(this.items[_i], this.itemEdit)
                }
                // update hidden field for post to server
                this.calTotalAmt()
                var e1 = document.getElementById("modeldjson")
                e1.value = JSON.stringify(this.items)



            }
        },
    })
</script>
<style>
    #table_detail th {
        text-align: center;
    }
</style>