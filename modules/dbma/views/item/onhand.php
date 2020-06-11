<?php

use yii\helpers\Html;

use kartik\grid\GridView;
use app\models\ItemLocSearch;
use app\widgets\se2Warehouse;
use app\widgets\se2Typeinvent;
use app\widgets\se2CompanyItem;
use yii\bootstrap\ActiveForm;
use app\models\ItemSearch;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemLocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สินค้าคงเหลือ';
$this->params['breadcrumbs'][] = $this->title  ;
?>
<div class="item-loc-index">



    <?php
    // echo $this->render('_search', ['model' => $searchModel]); 
    // echo ddlYear::widget();
    $form = ActiveForm::begin([
        'method' => 'get',
        'layout' => 'horizontal',
        'fieldConfig' => [
            /*
                'horizontalCssClasses' => [
                    'label' => 'col-sm-1',
                    'offset' => 'col-sm-offset-3',
                    'wrapper' => 'col-sm-2'
                ]
                */],
        'options' => [
            'class' => 'well',
        ],
    ]);

    ?>

    <div class="row">
        <div class="col-md-5 col-sm-6  col-xs-12">
            <?= se2Warehouse::widget([
                'form' => $form, 'model' => $SelectForm,
                'field' => 'wh_code',
                'idFilter' => $SelectForm->var1
            ]) ?>
        </div>
        <div class="col-md-5 col-sm-6  col-xs-12">
            <?= se2Typeinvent::widget([
                'form' => $form, 'model' => $SelectForm,
                'field' => 'ti_code',
                'idFilter' => $SelectForm->var2
            ]) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-sm-6  col-xs-12">
            <?= se2CompanyItem::widget([
                'form' => $form, 'model' => $SelectForm,
                'field' => 'co_code',
                'showToggleAll' => false,
                //'selectAll'=>true,
                'idFilter' => $SelectForm->var3
            ]) ?>

        </div>
        <div class="col-md-5 col-sm-6  col-xs-12">
            <?= Html::submitButton('Process', ['class' => 'btn btn-primary']) ?>
        </div>

    </div>





    <?php
    $form::end();
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Item_Number',
            'Item_Name',

            [
                
                'attribute' => 'Group_Product',
                // 'value'=>function($model){
                //     return $model->gproduct['Group_Product_Desc'];
                // },
                // 'filter' => ArrayHelper::map(\app\models\GProduct::find()->where(['Type_Invent_Code' =>  $SelectForm->ti_code])->asArray()->all(), 'Group_Product', 'Group_Product_Desc'),
                // 'value'=>function($model){
                //      return ($model->gproduct == null)?'N':'d';
                // },

            ],
            [
                'attribute' => 'Product',
                // 'filter' => ArrayHelper::map(\app\models\Product::find()->where(
                //     [
                //         'Type_Invent_Code' =>  $SelectForm->ti_code,
                //         'Group_Product' =>  $searchModel->Group_Product,
                //     ]
                //     )->asArray()->all(), 'Product', 'Product_Desc'),
            ],

            //'Product',
            //'WhCode',            
            [
                'attribute' => 'calQty',
                'format' => ['decimal', 2],
                'contentOptions' => ['align' => 'right'],
                'headerOptions' => ['width' => '80px'],


            ],
            [
                'attribute' => 'calQuarantine',
                'format' => ['decimal', 2],
                'contentOptions' => ['align' => 'right'],
                'headerOptions' => ['width' => '80px'],
            ],


            [
                // ------------------  LOT ------------------
                'header' => 'Lot',
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) use ($SelectForm) {


                    $searchModel = new ItemlocSearch();
                    $dataProvider = $searchModel->onhandSearchByItem($model['Item_Number'], $SelectForm->wh_code);

                    return Yii::$app->controller->renderPartial('onhandDesc', [
                        'dataProvider'  =>  $dataProvider,
                        'showPrice'     => ($SelectForm->wh_code !== 'FIN')
                    ]);
                },
                //'headerOptions'=>['class'=>'kartik-sheet-style'], 
                'expandOneOnly' => true,

            ],
            [
                // ------------------  Movement ------------------
                'header' => 'Movement',
                'class' => 'kartik\grid\ExpandRowColumn',
                //'width'=>'50px',    
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) use ($SelectForm) {


                    $searchModel = new ItemSearch();
                    $dataProvider = $searchModel->onhandMovement($SelectForm->wh_code, $model->Item_Number, $SelectForm->co_code);
                    /*        test            
                    $balance = 0;
                    foreach($dataProvider->allModels as $key => $value){
                        $balance =  $balance + ($value['recv_qty'] -  $value['issue_qty']);
                        $dataProvider->allModels[$key]['balance']=$balance;
                        //$dataProvider->allModels[$key]['balance']=999;
                        //$value['balance']=999;
                    }
                    
                    echo '<pre>';
                    print_r($dataProvider->allModels);
                    echo '</pre>';
                    */



                    return Yii::$app->controller->renderPartial('onhandMovement', [
                        //'inv_number'=>$model['inv_number'],
                        'dataProvider' => $dataProvider,
                    ]);
                },
                //'headerOptions'=>['class'=>'kartik-sheet-style'], 
                'expandOneOnly' => true,

            ],


        ],
    ]); ?>

</div>
* Finished Goods : ไม่แสดงราคา