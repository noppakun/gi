<style>
    /* cchange : content change*/
    .cchange {
        background-color: #ffcccc;
    }
</style>
<?php

use kartik\builder\Form;
use \app\components\XLib;


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
            'type' => Form::INPUT_STATIC,
            'widgetClass' => 'kartik\date\DatePicker',
            //'labelOptions' => ['class'=>'cchange'],                
            'options' => [
                //'labelOptions' => ['class'=>'cchange'],                  
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    //'labelOptions' => ['class'=>'cchange'],                
                ],
                //'style'=>'background-color:#ffcccc;'
                //'class'=>'cchange'
            ],

            //:style="background-color:powderblue;"

        ],
        'cust_no' => [
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
        ],
        'product_name' => [
            'type' => typeInput(Form::INPUT_TEXT),
        ],

    ],
]);

echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    //'staticOnly'=>$model->user_approve!=null ,
    'attributes' => [
        'product_cat' => [
            //'type'=>Form::INPUT_DROPDOWN_LIST,                            
            'type' => typeInput(Form::INPUT_RADIO_LIST),
            'options' => ['inline' => true],
            'items' => \app\models\xpdr::$product_cat_LIST,
            'staticValue' => function ($model, $index, $widget) {
                return (\app\models\xpdr::$product_cat_LIST[$model->product_cat]);
            }
        ],
        'product_cat_other' => [
            'type' => typeInput(Form::INPUT_TEXT),
            //'columnOptions' => ['colspan' => 2],
        ],
    ],
]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
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
            'columnOptions' => ['colspan' => 6],
        ],
        'packaging_conclude' => [
            //'type'=>Form::INPUT_DROPDOWN_LIST,                            
            'type' => typeInput(Form::INPUT_RADIO_LIST),
            'columnOptions' => ['colspan' => 3],
            'options' => ['inline' => true],
            'items' =>  [
                false => 'รอสรุป',
                true => 'สรุปแล้ว',
            ],
            'staticValue' => function ($model, $index, $widget) {
                return $model->packaging_conclude ? 'สรุปแล้ว' : 'รอสรุป';
            }
        ],

    ],
]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    //'staticOnly'=>$staticOnly,
    'columns' => 4,
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
        //'bd_owner' => ['type' => Form::INPUT_STATIC],
        'bd_owner' => [            
            'type' => typeInput(Form::INPUT_DROPDOWN_LIST),            
            'items' => $bdOwnerList,
        ],        
        //return $this->form->field($this->model, $this->field)->dropDownList($itemsArray,$this->options)->label($label);





    ],
]);
