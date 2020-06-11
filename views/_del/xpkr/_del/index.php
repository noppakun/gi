<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;

$BD_O = \Yii::$app->user->can('/@XPDR/BD-O');
$BD_M = \Yii::$app->user->can('/@XPDR/BD-M');
$RD_O = \Yii::$app->user->can('/@XPDR/RD-O');
$RD_M = \Yii::$app->user->can('/@XPDR/RD-M');

//  $BD_O = (1==0);
//  $BD_M = (1==0);
//  $RD_O = (1==1);
//  $RD_M = (1==1);


$this->title = $TABLECAPTION;
$this->params['breadcrumbs'][] = $this->title
    . ' ( '
    . ($BD_O ? "BD_O " : ' ')
    . ($BD_M ? "BD_M " : ' ')
    . ($RD_O ? "RD_O " : ' ')
    . ($RD_M ? "RD_M " : ' ') . ' )'.Yii::$app->controller->id;
?>

<?php
//  AAAAAAAAAAAAAAAAAAAAAAAAAAAA      select form
$form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'options' => [
        'class' => 'well',
    ],
]);
?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($SelectForm, 'checkbox')->checkboxList(
            [
                'N' => 'New',
                'B' => 'BD Approved',
                'R' => 'RD Approved',
            ],
            [
                'inline' => true,
            ]
        )->label(false);
        ?>
    </div>
    <div class="col-md-6  text-right">
        <?= Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>
    </div>
</div>
<?php
$form::end();
//  BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBb     select form    
?>
<div class="etable-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'options' => [
            'class' => 'YourCustomTableClass',
            
        ],

        'columns' => [
            [
                'header' => ($BD_O or $BD_M) ? Html::a(
                    '<i class="glyphicon glyphicon-plus"></i>',
                    [Yii::$app->controller->id . '/create'],
                    ['title' => 'เพิ่ม']
                ) : '#',

                'class' => 'kartik\grid\SerialColumn',
                'headerOptions' => ['align' => 'center'],
                'contentOptions' => ['align' => 'center'],
            ],


            [
                'attribute' => 'doc_no',
                'content' => function ($model, $key, $index, $column) {
                    return Html::a($model->doc_no, ['update', 'id' => $model->id]);
                }
            ],
            'doc_date',
            'cust_name',
            'product_name',
            'user_approve',
            'manager_approve',
            [
                'label' => 'BD',
                'content' => function ($model, $key, $index, $column) {
                    return $model->user_approve == null ? '' : '<span style="color:green"><i class="glyphicon glyphicon-ok"></i></span>';
                },
                'hAlign' => 'center',
            ],
            [
                'label' => 'RD',
                'content' => function ($model, $key, $index, $column) {
                    return $model->manager_approve == null ? '' : '<span style="color:green"><i class="glyphicon glyphicon-ok"></i></span>';
                },
                'hAlign' => 'center',
            ],

        ],

    ]);
    ?>

</div>