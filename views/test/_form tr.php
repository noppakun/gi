<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\xTr */
/* @var $form yii\widgets\ActiveForm */

//echo $model->doc_no;

//echo '<pre>';
//print_r(implode('", "', $modeld));
//print_r($modeld);
//print_r(json_encode($modeld));

//echo '</pre>';
?>
 
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
 
<div id="app">
    <v-app>
        <div class="x-tr-form">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
            <input type='hidden' id='modeldj' v-model='JSON.stringify(items)' name='modeldj' />
            <input v-model="cust_name" placeholder="edit me">
            <?= $form->field($model, 'doc_no')->textInput(['maxlength' => true])    ?>

            <?= $form->field($model, 'cust_no')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'cust_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>


            <?php ActiveForm::end(); ?>

        </div>

        {{message}} <br>
        {{cust_name}} <br>


        <button @click="onClick1">Default</button>


        <table class="table">
            <thead>
                <tr>
                    <th v-for="item in headers">{{item.text}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items">
                    <td> {{item.id}}</td>
                    <td>{{item.item}}</td>
                    <!-- <td> <input v-model="item.item"> </td> -->
                    <td>{{item.material}}</td>
                    <td>{{item.remark}}</td>
                </tr>
            </tbody>
        </table>

        <!-- <v-data-table :headers="headers" :items="items" ></v-data-table> 

         -->
        <!-- <v-row v-for="item in items">
 


    </v-row> -->
    </v-app>
</div>

<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui"> -->

<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script> 


<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>


<script>
    var app = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data() {
            return {
                headers: [{
                        text: 'ID',
                        value: 'id',
                    },
                    {
                        text: 'ITEM',
                        value: 'item'
                    },
                    {
                        text: 'MAT.',
                        value: 'material'
                    },
                    {
                        text: 'REM.',
                        value: 'remark'
                    },
                ],
                message: '<?= $model->doc_no ?>',
                cust_name: '<?= $model->cust_name ?>',

                items: <?= $modeldj ?>
            }
        },
        methods: {
            onClick1: function(event) {
                var e1 = document.getElementById("modeldj")
                // e1.value=  this.cust_name 

                this.items[0].item = this.cust_name
                e1.value = JSON.stringify(items)



                console.log(e1)
                //e1
                //this.cust_name = 'abc'
            }
        },

    })
</script>