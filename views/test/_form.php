<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\xTr */
/* @var $form yii\widgets\ActiveForm */

//echo $model->doc_no;

// echo '<pre>';
// //print_r(implode('", "', $modeld));
// //print_r($modeld);
// //print_r(json_encode($modeldjson));
// print_r(($modeldjson));

// echo '</pre>';
?>
<div id="app">
    <!-- <v-app> -->
    <div class="x-tr-form">
        <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <input type='hidden' id='modeldjson' v-model='JSON.stringify(items)' name='modeldjson' />
        <?= $form->field($model, 'doc_no')->textInput(['maxlength' => true])    ?>
        <?= $form->field($model, 'cust_no')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'cust_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
        <?php ActiveForm::end(); ?>

    </div>


    <table class="table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Item</th>
                <th>Material</th>
                <th>Rmark</th>
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
                    <td>{{item.item}}</td>
                    <td>{{item.material}}</td>
                    <td>{{item.remark}}</td>
                    <td>


                        <a class="btn btn-default glyphicon glyphicon-edit" @click="onClickEdit(item)" data-toggle="modal" data-target="#myModal"></a>
                        <a class="btn btn-default glyphicon glyphicon-trash" @click="onClickDelete(item)"></a>

                    </td>
                </template>


            </tr>
        </tbody>
    </table>

    <paginate :page-count="pageCount" :container-class="'pagination'" :click-handler="onClickPage">
    </paginate>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"> {{itemEdit.id}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="item">item</label>
                        <input type="text" class="form-control" id="itemE" v-model="itemEdit.item" ref="itemE">
                    </div>
                    <div class="form-group">
                        <label for="material">material</label>
                        <input type="text" class="form-control" id="material" v-model="itemEdit.material">
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

</div> <!-- id = app -->



<!-- For prototyping or learning purposes, you can use the latest version with: -->
<!-- <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
<script src="https://unpkg.com/vuejs-paginate@latest"></script>

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
                    item: '',
                    material: '',
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
                    item: '',
                    material: '',
                    remark: '',
                });

                this.$refs.itemE.focus();
                //console.log(this.$refs.itemE)                
            },
            onClickEdit(para) {
                //console.log('-------onClickEdit---------') 

                Object.assign(this.itemEdit, para)
            },
            onClickDone() {
                //console.log('-------onClickDone---------')
                if (this.itemEdit.id == 0) { // Create

                    this.items.push({
                        id: -(this.items.length),
                        item: this.itemEdit.item,
                        material: this.itemEdit.material,
                        remark: this.itemEdit.remark,
                        rec_status: 'n'
                    });
                    this.calDisplayedItems()

                } else { // update
                    let i = this.items.findIndex((e) => (e.id == this.itemEdit.id))
                    //console.log(i)
                    this.items[i].item = this.itemEdit.item
                    this.items[i].material = this.itemEdit.material
                    this.items[i].remark = this.itemEdit.remark
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