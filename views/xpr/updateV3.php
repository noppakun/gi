<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
//use kartik\tabs\TabsX;

//use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */

$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord) ? '' : ' : ' . $model->doc_no);
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View' : 'Update'));

$staticOnly = true;
$staticOnly = $viewmode;
?>

<div id="app" class="etable-update">
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);    ?>
    <input type='hidden' id='masterid' value='<?=$model->doc_no?>' />                                
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
        <div class="panel-body"> 
            
            <input type='hidden' id='modeldjson' v-model='JSON.stringify(items)' name='modeldjson' />
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
                        'staticValue'=>function($model){
                            $r=app\models\Depart::find()->where(['DeptCode' =>$model->dept_code])->one();
                            $dname = ($r)?$r->DeptName:'';
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
                        'columnOptions' => ['colspan' => 6],
                        //'label' => 'อัตรารับของเกิน',
                    ], 
                ],
            ]);

            // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
            ActiveForm::end();
            ?>

        </div>



    </div>

    <div class="panel  panel-primary">
        <table class="table">
            <thead>
                <tr>
                    <!-- <th>Id</th> -->
                    <th>รายละเอียด</th>
                    <th>ราคาต่อหน่วย</th>
                    <th>จำนวน</th>
                    <th>หน่วย</th>
                    <th>รวม</th>
                    <th>หมายเหตุ</th>
                    <th>
                        <a class="btn btn-default glyphicon glyphicon-plus" @click="onClickCreate" data-toggle="modal" data-target="#myModal"></a>
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
                        <td>{{item.price}}</td>
                        <td>{{item.qty}}</td>
                        <td>{{item.uom}}</td>

                        <td>{{item.qty*item.price}}</td>
                        <td>{{item.remark}}</td>
                        <td>
                            <a class="btn btn-default glyphicon glyphicon-edit" @click="onClickEdit(item)" data-toggle="modal" data-target="#myModal"></a>
                            <a class="btn btn-default glyphicon glyphicon-trash" @click="onClickDelete(item)"></a>
                        </td>
                    </template>
                </tr>
            </tbody>
        </table>

    </div>
    <paginate v-if="pageCount>1" :page-count="pageCount" :container-class="'pagination'" :click-handler="onClickPage"></paginate>
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
                                'columnOptions'=>['colspan'=>2],
                                'options' => [
                                    'id'=>'item_desc',
                                    'v-model' => "itemEdit.item_desc"]
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
                                'columnOptions'=>['colspan'=>3],
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
    {{ Date()}}
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
                itemEdit: {},
                itemDefault: {},
            }
        },

        //async mounted() {
        async created() {
            //console.log(window.location.search)
            var e1 = document.getElementById("masterid")
             //console.log(e1.value)
            let vm = this            
            //await axios.get('index.php?r=/xpr/api_detail&id=' + e1.value)            
            await axios.get('?r=/xpr/api_detail&id=' + e1.value)            
            //await axios.get('?r=/xpr/api_detail&id=12')            
                .then(r => {
                    //console.log( r.data.rows)
                    vm.items = r.data.rows
                    vm.itemDefault = r.data.row
                    vm.itemDefault.id = 0
                    vm.itemDefault.rec_status = ''
                    Object.assign(this.itemEdit, this.itemDefault)                    
                });
            this.calDisplayedItems()
        },
        methods: {
            // display aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
            calDisplayedItems() {
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
                console.log(this.itemDefault)       
                console.log(this.itemEdit)       
                
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
                var e1 = document.getElementById("modeldjson")
                e1.value = JSON.stringify(this.items)
            }
        },
    })
</script>