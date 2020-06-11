<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = $TABLECAPTION;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="xpr-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'hover' => true,
        'condensed' => true,
        // 'rowOptions' => function ($model, $key, $index, $grid) {
        //     return ['id' => $model['doc_no'], 'onclick' => 'alert(this.id);'];
        // },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'doc_status',
            [
                'attribute' => 'doc_no',
                'content' => function ($model, $key, $index, $column) {
                    return Html::a($model->doc_no, ['update', 'id' => $model->doc_no]);
                },
            ],
            'doc_date',
            'ref_doc_no',
            'supp_name',
            'shipto',
            [

                'label' => 'ยอดรวม',
                'attribute' => 'amount',
                'format' => ['decimal', 2],
                'contentOptions' => ['align' => 'right']
            ],
            [
                'label' => 'Review',
                //'attribute' => 'review_date',
                'attribute' => 'review_user',
                'format' => 'raw',
                'contentOptions' => ['align' => 'center'],
                'value' => function ($model) {
                    return ($model->review_user !== null) ? $model->review_user : '-';
                }
                // 'value' => function ($model) {
                //     return ($model->review_user !== null)
                //         ? rtrim($model->review_user) . '<br>' . XLib::dateTimeConv($model->review_date, 'a')
                //         : null;
                // }
            ],
            [
                'label' => 'Approve',
                //'attribute' => 'approve_date',
                'attribute' => 'dp_approve_user',
                'format' => 'raw',
                'contentOptions' => ['align' => 'center'],
                'value' => function ($model) {
                    return ($model->dp_approve_user !== null) ? $model->dp_approve_user : '-';
                }                
                // 'value' => function ($model) {
                //     return ($model->approve_user !== null)
                //         ? rtrim($model->approve_user) . '<br>' . XLib::dateTimeConv($model->approve_date, 'a')
                //         : null;
                // }
            ],
            //'remark',
            //'dept_code',
            //'prepare_user',
            //'prepare_date',
            //'review_user',
            //'review_date',
            //'approve_user',
            //'approve_date',


            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return ($model->review_user == null)
                            ? Html::a(
                                '<i class="glyphicon glyphicon-trash"></i>',
                                $url,
                                [
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => "Are you sure to delete " . $model->doc_no . " ?",
                                    ],
                                ]
                            )
                            : null;
                        //                        data-method="post"
                    }
                ],
                ///@XPR/APPROVE'
                //(\Yii::$app->user->can('/@XPR/APPROVE'))

                'header' => Html::a(
                    '<i class="glyphicon glyphicon-plus"></i>',
                    [Yii::$app->controller->id . '/create'],
                    ['title' => 'เพิ่ม']
                ),
                'hidden' => (\Yii::$app->user->can('/@XPR/APPROVE')),
            ],
        ],
    ]); ?>


</div>