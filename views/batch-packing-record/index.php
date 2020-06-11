<?php

use yii\helpers\Html;
use app\components\gihelper;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use app\widgets\ddlYear;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$TABLECAPTION = 'BATCH PACKING RECORD';
$this->title = $TABLECAPTION;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="etable-index">
  <?php

  $form = ActiveForm::begin([
    'method' => 'get',
    'layout' => 'horizontal',

    // 'fieldConfig' => [
    //     'horizontalCssClasses' => [
    //         'label' => 'col-sm-2  ',
    //         'offset' => 'col-sm-offset-2',
    //         'wrapper' => 'col-sm-2 col-sx-4'
    //     ]
    // ], 
    'options' => [
      'class' => 'well',
    ],
  ]);
  ?>
  <span class="label label-default">Year (Start Date Time)</span>

  <!-- // echo ddlMonth::widget(['form'=>$form,'model' => $SelectForm,'field'=>'month','SelectQuarter'=>true]);   -->
  <div class="row">
    <div class="col-md-6">
      <?= ddlYear::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'year']);   ?>
    </div>
    <div class="col-md-6">
      <?= ddlYear::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'year2']);   ?>
    </div>
  </div>


  <div class="row">

    <div class="col-md-6">
      <?= Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>
    </div>
  </div>






  <?php
  $form::end();

  echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'responsiveWrap' => false,
    'columns' => [


      'Order_No',
      [
        'attribute' => 'Item_Number',
        'label' => 'Product',
        'value' => function ($model) {
          return Html::a(
            $model['Item_Number'],
            [
              'view',
              'order_no' => $model['Order_No'],
              'item_number' => $model['Item_Number'],
            ]
          );
        },
        'format' => 'raw',
      ],
      'item.Item_Name',
      [
        'attribute' => 'JobQty',
        'format' => ['decimal', 0],
        'hAlign' => 'right',
      ],
      [
        'attribute' => 'item.Uom',
        'header' => 'หน่วยนับ<br>(Uom)',
        'hAlign' => 'center',
      ],

      // [
      //   'attribute'=>'priority_TEXT', 
      //   'hAlign' => 'center',             
      // ],        
      [
        'attribute' => 'jobStatus_TEXT',
        'hAlign' => 'center',
      ],


      [
        'attribute' => 'StartDateTime',
        'format' => ['datetime'],
        'hAlign' => 'center',

      ],
      'JobNo',

    ],

    // 'columns' => [
    //     [
    //         'class' => 'kartik\grid\SerialColumn',
    //         'headerOptions' => ['align'=>'center'],
    //         'contentOptions' => ['align'=>'center'],                                
    //     ],
    //     [
    //         'attribute'=>'CompanyCode',
    //         'label'=>'รหัส',
    //         'contentOptions' => ['width'=>100],


    //     ],
    //     [
    //         'attribute'=>'CompanyName',
    //         'contentOptions' => ['width'=>300],


    //     ],

    //     'Addr1',
    //     'TelePhone',
    //     'Fax',

    //     'CompanyEngName',

    //     [
    //         'class' => 'kartik\grid\ActionColumn',
    //         'template'=>'{view}{update}{delete}',
    //         'header' => Html::a(
    //             '<i class="glyphicon glyphicon-plus"></i>',
    //             [Yii::$app->controller->id.'/create'],
    //             ['title'=>'เพิ่ม']
    //         )          
    //     ],        
    // ],

  ]);
  ?>

</div>