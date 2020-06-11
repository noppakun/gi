<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\tabs\TabsX;

use dosamigos\tinymce\TinyMce;

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
                'columns' => 4,
                'staticOnly' => $staticOnly,
                'attributes' => [
                    'doc_no' => [
                        'type' => Form::INPUT_TEXT,
                    ],
                    'doc_date' => [
                        'type' => Form::INPUT_TEXT,
                        //'columnOptions' => ['colspan' => 2],
                    ],
                    'ref_doc_no' => [
                        'type' => Form::INPUT_TEXT,
                        //'columnOptions' => ['colspan' => 2],
                    ],
                    'dept_code' => [
                        'type' => Form::INPUT_TEXT,
                        //'columnOptions' => ['colspan' => 2],
                        //'label' => 'อัตรารับของเกิน',
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
                        'columnOptions' => ['colspan' => 2],
                    ],
                    'shipto' => [
                        'type' => Form::INPUT_TEXT,
                        'columnOptions' => ['colspan' => 1],
                    ],
                    'remark' => [
                        'type' => Form::INPUT_TEXT,
                        'columnOptions' => ['colspan' => 1],
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
                    <th>Id</th>
                    <th>item_desc</th>
                    <th>qty</th>
                    <th>uom</th>

                    <th>price</th>
                    <th>remark</th>

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
                        <td>{{item.id}}{{item.rec_status}}</td>
                        <td>{{item.item_desc}}</td>
                        <td>{{item.qty}}</td>
                        <td>{{item.uom}}</td>
                        <td>{{item.price}}</td>
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
        <?php

        // $formDialog = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
        // echo Form::widget([
        //     //'model'=>$model,
        //     'model'=>false,
        //     'form'=>$formDialog,
        //     'columns'=>2,
        //     'attributes'=>[
        //         'username'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter username...']],
        //         'password'=>['type'=>Form::INPUT_PASSWORD, 'options'=>['placeholder'=>'Enter password...']],
        //         'rememberMe'=>['type'=>Form::INPUT_CHECKBOX, 'label' => 'Remember your settings?'], // custom label
        //     ]
        // ]);
        // echo Html::button('Submit', ['type'=>'button', 'class'=>'btn btn-primary']);
        // ActiveForm::end();

        ?>


        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"> {{itemEdit.id}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="item">item_desc</label>
                        <input type="text" class="form-control" id="item_desc" v-model="itemEdit.item_desc">
                    </div>
                    <div class="form-group">
                        <label for="qty">qty</label>
                        <input type="text" class="form-control" id="qty" v-model="itemEdit.qty">
                    </div>
                    <div class="form-group">
                        <label for="uom">uom</label>
                        <input type="text" class="form-control" id="uom" v-model="itemEdit.uom">
                    </div>

                    <div class="form-group">
                        <label for="price">price</label>
                        <input type="text" class="form-control" id="price" v-model="itemEdit.price">
                    </div>

                    <div class="form-group">
                        <label for="remark">remark</label>
                        <input type="text" class="form-control" id="remark" v-model="itemEdit.remark">
                    </div>
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
$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue@2.6.11", ['position' => $this::POS_HEAD]);
$this->registerJsFile("https://unpkg.com/vuejs-paginate@latest", ['position' => $this::POS_HEAD]);
 
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


                items: <?= $modeldjson ?>,
                itemEdit: {
                    id: 0,
                    // -------------------
                    item_desc: '',
                    qty: 0,
                    uom: '',
                    price: 0,
                    remark: '',
                }



            }
        },
        mounted() {
            this.calDisplayedItems()
        },
        methods: {
            calDisplayedItems() {
                // aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                let _items = this.items.filter(r => r.rec_status !== 'd')
                this.totalRows = _items.length
                this.pageCount = Math.ceil(this.totalRows / this.perPage);
                //this.displayedItems = this.paginate(_items);   
                this.displayedItems = _items.slice(
                    (this.currentPage * this.perPage) - this.perPage,
                    (this.currentPage * this.perPage)
                );
                // bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb

            },
            paginate(items) {
                //console.log('-------------paginate----')
                return items.slice(
                    (this.currentPage * this.perPage) - this.perPage,
                    (this.currentPage * this.perPage)
                );
            },
            onClickPage(pageNum) {

                this.currentPage = pageNum

                // aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                this.calDisplayedItems();
                // bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb

            },
            onClickDelete(para) {
                //console.log('-------------onClickDelete----',para)
                let i = this.items.findIndex((e) => (e.id == para.id))
                if (this.items[i].rec_status == 'n') {
                    this.items.splice(i, 1)
                } else {
                    this.items[i].rec_status = 'd'
                }
                // aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                this.calDisplayedItems();
                // bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb

                //this.$forceUpdate();
            },
            onClickCreate(para) {
                //console.log('-------------onClickCreate----')
                Object.assign(this.itemEdit, {
                    id: 0,
                    // -------------------          
                    item_desc: '',
                    qty: 0,
                    uom: '',
                    price: 0,
                    remark: '',
                });
                //this.$refs.itemE.focus();
                //console.log(this.$refs.itemE)                
            },
            onClickEdit(para) {
                //console.log('-------onClickEdit---------') 

                Object.assign(this.itemEdit, para)
            },
            onClickDone() {
                console.log('-------onClickDone---------', this.items.length)
                if (this.itemEdit.id == 0) { // Create                    
                    this.items.push({
                        id: -(this.items.filter(r => r.rec_status !== 'a').length + 1),
                        // ---------------------------------
                        item_desc: this.itemEdit.item_desc,
                        qty: this.itemEdit.qty,
                        uom: this.itemEdit.uom,
                        price: this.itemEdit.price,
                        remark: this.itemEdit.remark,
                        // ---------------------------------
                        rec_status: 'n'
                    });
                    this.calDisplayedItems()

                } else { // update
                    let i = this.items.findIndex((e) => (e.id == this.itemEdit.id))
                    //console.log(i)
                    // ---------------------------------
                    this.items[i].item_desc = this.itemEdit.item_desc
                    this.items[i].qty = this.itemEdit.qty
                    this.items[i].uom = this.itemEdit.uom
                    this.items[i].price = this.itemEdit.price
                    this.items[i].remark = this.itemEdit.remark
                    // ---------------------------------
                    if (this.itemEdit.id > 0) {
                        this.items[i].rec_status = 'e'
                    }
                }
                // update hidden field for post to server
                var e1 = document.getElementById("modeldjson")
                e1.value = JSON.stringify(this.items)
            }
        },
    })
</script>