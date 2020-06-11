<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\xTr */
/* @var $form yii\widgets\ActiveForm */

//echo $model->doc_no;

//echo '<pre>';
//print_r(implode('", "', $modeld));
//print_r($modeld);
//print_r(json_encode($modeld));

//e
?>

<div id="app">
    <v-app>
        <div class="x-tr-form">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            {{message}} ==== {{text1}}
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
            <input type='hidden' id='modeldj' v-model='JSON.stringify(items)' name='modeldj' />
            <input v-model="text1" placeholder="edit me">


            <?= $form->field($model, 'doc_no')->textInput(['maxlength' => true])    ?>

            <?= $form->field($model, 'cust_no')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'cust_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>


            <?php ActiveForm::end(); ?>

        </div>


        <button @click="onClick1">Default</button>
        <v-data-table :headers="headers" :items="items"></v-data-table>


    </v-app>
</div>
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui"> -->

<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
    new Vue({
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
                text1: '<?= $model->cust_name ?>',

                items: <?= $modeldj ?>
            }
        },
        methods: {
            onClick1: function(event) {
                var e1 = document.getElementById("modeldj")
                // e1.value=  this.cust_name 

                this.items[0].item = this.text1
                e1.value = JSON.stringify(items)



                console.log(e1)
                //e1
                //this.cust_name = 'abc'
            }
        },
    })
</script>