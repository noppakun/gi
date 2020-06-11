<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;

$page = isset(Yii::$app->request->queryParams['page'])
    ? Yii::$app->request->queryParams['page']
    : 1;

$BD_O = \Yii::$app->user->can('/@XPDR/BD-O');
$BD_M = \Yii::$app->user->can('/@XPDR/BD-M');
$RD_O = \Yii::$app->user->can('/@XPDR/RD-O');
$RD_M = \Yii::$app->user->can('/@XPDR/RD-M');

$GLOBALS['BD_M'] = $BD_M;
$GLOBALS['BD_O'] = $BD_O;
$GLOBALS['RD_M'] = $RD_M;
$GLOBALS['RD_O'] = $RD_O;

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
    . ($RD_M ? "RD_M " : ' ') . ' )'
    //    .Yii::$app->controller->id
;

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
        // ->options(
        //     'onchange=this.form.submit()'                
        // );
        ?>
    </div>
    <div class="col-md-6  text-right">
        <?= Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>

        <?= Html::a(
            '<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export ( XLS )',
            [
                'tospreadsheet',
                'searchModel' => $searchModel->toArray(),
            ],
            ['class' => 'btn btn-success']
        ) ?>

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
  
        'rowOptions' => function ($model, $index, $widget, $grid){            
            if (($model->bd_approve_request_date == null)
            &&  ($model->user_approve_date == null)
            ) {
                return ['style' => 'background-color:orange'];           
            }     

            if ($model->cancel_user != null) {
                return ['class' => 'danger strikeout'];
            } 
 

        },
        'options' => [
            'class' => 'YourCustomTableClass11',
        ],        
        'columns' => [
            // 'bd_approve_request_date',
            // 'user_approve_date',
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
                },
                'width' => '105px',
                // for test สีไม่ขึ้น  4/3/2020
                // aaaaaaaaaaaaaaaaa
                'contentOptions' => function($model){
                    if ($model->cancel_user != null) {
                        return ['class' => 'danger strikeout'];
                    } else if (($model->bd_approve_request_date == null)
                    &&  ($model->user_approve_date == null)
                    ) {
                        return ['style' => 'background-color:orange'];           
                    }                 
                }
                //bbbbbbbbbbbbbbbbbbbbb
        

            ],
            [
                'attribute' => 'doc_date',
                'width' => '105px',
            ],
            [
                'attribute' => 'cust_name',
                'width' => '105px',
            ],
            [
                'attribute' => 'product_name',
                'contentOptions' => ['style' => 'width:30%;'],
                'content' => function ($model) {
                    $_pre = ($model->cancel_user != null)
                        ? '<span class="label label-danger">ยกเลิก</span> '
                        : '';

                    return $_pre . $model['product_name']
                        . ((Yii::$app->controller->id == 'xpkr')
                            ? ' <i>' . $model['size_text'] . '</i>'
                            : '');
                },
            ],
            [
                'attribute' => 'user_approve',
                'content' => function ($model) {
                    return ('<span style="font-size: 16px;color:' . ((is_null($model->user_approve) ? '' : ($model->user_accept == 'Y' ? 'green' : 'red')))
                        . '" class="glyphicon ' . (is_null($model->user_approve) ? 'glyphicon-minus' : ($model->user_accept == 'Y' ? 'glyphicon-ok-sign' : 'glyphicon-remove-sign')) . '"></span>');
                },
                'hAlign' => 'center',
                'width' => '80px',
            ],
            [
                //   'label' => 'RD.App.',
                'attribute' => 'manager_approve',
                'content' => function ($model) {
                    return ('<span style="font-size: 16px;color:' . ((is_null($model->manager_approve) ? '' : ($model->manager_accept == 'Y' ? 'green' : 'red')))
                        . '" class="glyphicon ' . (is_null($model->manager_approve) ? 'glyphicon-minus' : ($model->manager_accept == 'Y' ? 'glyphicon-ok-sign' : 'glyphicon-remove-sign')) . '"></span>');
                },

                // 'content' => function ($model) {
                //     return (is_null($model->manager_approve) ? '-' : $model->manager_approve)
                //         . (' (' . '<b  style="color:' . ($model->manager_accept == 'Y' ? 'green' : 'red') . '">' . (is_null($model->manager_approve)  ? '-' : ($model->manager_accept == 'Y' ? 'yes' : 'no')) . '</b>)');
                // },

                'hAlign' => 'center',
                'width' => '80px',
            ],
            [
                'attribute' => 'bd_owner',
                'hAlign' => 'center',
                'width' => '70px',

                'filter' => $bdOwnerList,

            ],
            //'manager_approve',
            [
                'attribute' => 'rd_owner',
                'hAlign' => 'center',
                'width' => '120px',
                'filter' => $rdOwnerList,
                'content' => function ($model) use ($page) {
                    global   $BD_O, $BD_M, $RD_O, $RD_M;
                    //$show = 
                    //--$model['rd_owner']                    


                    $st2 = (($RD_O or $RD_M)
                        and ($model['cancel_user'] == null)
                        //and ($model->manager_approve == 'N')) ? Html::a(
                        and ($model->manager_approve != null)) ? Html::a(
                        '',
                        ['rdowner', 'id' => $model->id, 'page' => $page],
                        [
                            'style' => "font-size: 16px",
                            'class' => "glyphicon glyphicon-edit"
                        ]
                    ) : '';


                    return $model['rd_owner'] . ' ' . $st2;
                }

            ],

            [
                //'attribute' => 'doc_no',
                'content' => function ($model, $key, $index, $column) {
                    return Html::a(
                        '',
                        ['print', 'id' => $model->id],
                        [
                            'style' => "font-size: 16px",
                            'class' => "glyphicon glyphicon-print"
                        ]
                    );
                },
                'width' => '80px',
            ],

        ],

    ]);
    ?>

</div>
<span class="label label-danger">รายการยกเลิก</span> 
<span class="label label-warning" style ='background-color:orange'>รายการกำลังแก้ไข</span>
