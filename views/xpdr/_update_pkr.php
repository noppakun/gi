<?php
use kartik\builder\Form;
use yii\helpers\Html;
use \app\components\XLib;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

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
            'options' => [
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                ],
            ]
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
            'items' => \app\models\xpkr::$product_cat_LIST,
            'staticValue' => function ($model, $index, $widget) {
                return (\app\models\xpkr::$product_cat_LIST[$model->product_cat]);
            },
        ],
        'product_cat_other' => [
            'type' => typeInput(Form::INPUT_TEXT),
            //'columnOptions'=>['colspan'=>1],
        ],
    ],
]);
echo Form::widget([
    'model'=>$model,
    'form' => $form,
    'columns' => 6,
    'attributes' => [
        'bulk' => [
            //'type' => typeInput(Form::INPUT_RADIO_LIST), // not work with   validate 'whenClient' in model rules()
            //'type' => typeInput(Form::INPUT_LIST_BOX),     // work            
            'type' => typeInput(Form::INPUT_DROPDOWN_LIST),     // work                        
            'options'=>['inline' => true, ],             
            'items' => \app\models\xpkr::$bulk_LIST,            
            'staticValue' => function ($model, $index, $widget) {
                return (\app\models\xpkr::$bulk_LIST[$model->bulk]);
            },            
        ],
        'bulk_note' => [
            'type' => typeInput(Form::INPUT_TEXT),
            'columnOptions' => ['colspan' => 5],
        ],
    ],
]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [

        'benchmark' => ['type' => typeInput(Form::INPUT_TEXT)],
        //'feeling_after_use'=>['type'=>typeInput(Form::INPUT_TEXT)],
        'target_group' => ['type' => typeInput(Form::INPUT_TEXT)],
    ],
]);

echo Form::widget([
    'model' => $model,
    'form' => $form,
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

        // 'size' => [
        //     'type' => typeInput(Form::INPUT_TEXT),
        //     'columnOptions' => ['colspan' => 3],
        // ],
        // 'size_unit' => [
        //     'type' => typeInput(Form::INPUT_DROPDOWN_LIST),
        //     'items' => \app\models\xpkr::$size_unit_LIST,
        //     'label' => 'Unit',
        //     'columnOptions' => ['colspan' => 2],
        //     'staticValue' => function ($model, $index, $widget) {
        //         return (\app\models\xpkr::$size_unit_LIST[$model->size_unit]);
        //     }
        // ],
        // 'first_order' => [
        //     'type' => typeInput(Form::INPUT_TEXT),
        //     'columnOptions' => ['colspan' => 2],
        // ],

        // // RD แจ้งไม่ใช้
        // // 'total_order' => [
        // //     'type' => typeInput(Form::INPUT_TEXT),
        // //     'columnOptions' => ['colspan' => 2],
        // // ],
        // 'order_unit' => [
        //     'type' => typeInput(Form::INPUT_DROPDOWN_LIST),
        //     'items' => \app\models\xpkr::$order_unit_LIST,
        //     'label' => 'Unit',
        //     'columnOptions' => ['colspan' => 2],
        //     'staticValue' => function ($model, $index, $widget) {
        //         return (\app\models\xpkr::$order_unit_LIST[$model->order_unit]);
        //     }
        // ],
    ],
]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 4,
    'attributes' => [
        'artwork_design' => [
            //'type'=>typeInput(Form::INPUT_DROPDOWN_LIST),
            'type' => typeInput(Form::INPUT_RADIO_LIST),
            'options' => ['inline' => true],
            'items' => \app\models\xpkr::$artwork_design_LIST,
            //'label'=>'Unit',
            'columnOptions' => ['colspan' => 2],
            'staticValue' => function ($model, $index, $widget) {
                return (\app\models\xpkr::$artwork_design_LIST[$model->artwork_design]);
            }
        ],
        '_detail' => [
            'visible' => (!$model->isNewRecord and ($model->user_approve==null)),


            'type' => Form::INPUT_RAW,
            //'value'=>Html::a('รายละเอียดบรรจุภัณฑ์',['create_detail','idh'=>$model->doc_no],
            'value' => Html::a(
                'รายละเอียดบรรจุภัณฑ์',
                ['create_detail', 'idh' => $model->id],
                //'value'=>Html::a('รายละเอียดบรรจุภัณฑ์',['create_detail','id'=>$model->id],
                [
                    'class' => 'btn btn-success',
                ]
            )
        ],
         

    ]
]);

// AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
//if (Yii::$app->user->identity->username == 'noppakun') {
//if (!$model->isNewRecord){
if  ($model->user_approve!==null){
    $query =  app\models\XPkrD::find()->andFilterWhere(['pkr_id' => $model->id]);
    $modeld = new ActiveDataProvider([
        'query' => $query,
    ]); 
    echo Yii::$app->controller->renderPartial('@app/views/xpdr/_update_pkr_detail', 
    [
        'model'=>$model,
        'modeld'=>$modeld,
        'editmode'=>$viewmode,
    ]);
}

//BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB----- 


function cbImg($check)
{
    // checkboxImage
    //return $check ? 'images/icons8-checked-checkbox-50.png' : 'images/icons8-unchecked-checkbox-50.png';
    return Html::img(($check ? 'images/icons8-checked-checkbox-50.png' : 'images/icons8-unchecked-checkbox-50.png'), ['width' => '20']);
}
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 6,
    'attributes' => [
        'label' => [
            'type' => Form::INPUT_RAW,
            'value' => Html::tag('label', 'รายละเอียดอื่นๆ(ถ้ามี)', ['class' => 'form-group checkbox']),
        ],
        'other_detail_picture' => [
            'type' => typeInput(Form::INPUT_CHECKBOX),
            'staticValue' => function ($model, $index, $widget) {
                return cbImg($model->other_detail_picture);
            }
        ],
        'other_detail_sample' => [
            'type' => typeInput(Form::INPUT_CHECKBOX),
            'staticValue' => function ($model, $index, $widget) {
                return cbImg($model->other_detail_sample);
            }

        ],
        'other_detail_other' => [
            'type' => typeInput(Form::INPUT_CHECKBOX),
            'staticValue' => function ($model, $index, $widget) {
                return cbImg($model->other_detail_other);
            }
        ],
        'other_detail_other_text' => [
            'type' => typeInput(Form::INPUT_TEXT),
            'columnOptions' => ['colspan' => 6],
        ],


    ],
]);


echo Form::widget([
    'model' => $model,
    'form' => $form,
    //'staticOnly'=>$staticOnly,
    'columns' => 4,
    'attributes' => [
        'present_req_date' => [
            'type' => typeInput(Form::INPUT_WIDGET),
            'widgetClass' => 'kartik\date\DatePicker',
            'options' => [
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                ],
            ],
            'staticValue' => function ($model, $index, $widget) {
                return XLib::dateConv($model->present_req_date, 'a');
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

        'bd_owner' => [            
            'type' => typeInput(Form::INPUT_DROPDOWN_LIST),            
            'items' => $bdOwnerList,
        ],  

    ],
]);
