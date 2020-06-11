<?php

use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Top 10 purchase' . ' (raw material)';
$this->params['breadcrumbs'][] = $this->title;

$GLOBALS['sql'] = $sql;
// -------------------------------------------------------------- 
function funGridView($dataProvider, $title)
{
    $_reuse_column = [
        [
            'attribute' => 'min_price',
            'label' => 'ราคาซื้อต่ำสุด',
            'format' => ['decimal', 2],
            'hAlign' => 'right',
        ],
        [
            'attribute' => 'max_price',
            'label' => 'ราคาซื้อสูงสุด',
            'format' => ['decimal', 2],
            'hAlign' => 'right',
        ],
        [
            'attribute' => 'qty',
            'label' => 'จำนวนซื้อ',
            'format' => ['decimal', 0],
            'hAlign' => 'right',
        ],
        [
            'attribute' => 'uom',
            'label' => 'หน่วย',
        ],
        [
            'attribute' => 'amount',
            'label' => 'มูลค่า',
            'format' => ['decimal', 2],
            'hAlign' => 'right',
        ]
    ];
    $column_detail = array_merge([
        [
            'attribute' => 'yyear',
            'label' => 'ปี',
        ]
    ], $_reuse_column);
    $column_main = array_merge(
        [
            [
                // ------------------  LOT ------------------
                //'header' => 'Lot',
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model) use ($column_detail) {
                    global $sql;
                    $connection = \Yii::$app->erpdb;
                    $command = $connection->createCommand($sql . ' order by yyear');
                    $command->bindParam(":Item_Number", $model['Item_Number']);
                    $rows = $command->queryAll();
                    $dataProvider = new ArrayDataProvider([
                        'allModels' => $rows,
                        'pagination' => [
                            'pageSize' => 20,
                        ],
                    ]);

                    $ret = GridView::widget([
                        'responsiveWrap' => false,
                        'dataProvider' => $dataProvider,
                        'panel' => [
                            'type' => 'default',                            
                        ],                        
                        'panelTemplate' => '                            
                            {items}        
                        ',
                        'columns' => $column_detail,
                    ]);
                    return '<div class="row">   
                            <div class="col-md-8 col-md-offset-4">' . $ret . '</div>
                        </div>';
                },
                //'headerOptions'=>['class'=>'kartik-sheet-style'], 
                'expandOneOnly' => true,

            ],
            [
                'attribute' => 'Item_Number',
                'label' => 'รายการ',
                'value' => function ($model) {
                    return $model['description'] . ' (' . rtrim($model['Item_Number']) . ')';
                }
            ]
        ],
        $_reuse_column
    );

    return GridView::widget([
        'responsiveWrap' => false,
        'dataProvider' => $dataProvider,
        'headerRowOptions' => ['class' => 'success'],
        'floatHeader' => false,
        'panel' => [
            'type' => 'default',
            'heading' => '<h3class="panel-title">' . $title . '</h3>',
        ],
        'panelTemplate' => '
            {panelHeading}
            {items}        
        ',
        'panelHeadingTemplate' => '
            {title}
        ',
        'rowOptions' => function ($model) {
            return $model['status'] == 1 ? ['class' => GridView::TYPE_WARNING] : null;
        },
        'columns' => $column_main

    ]);
}
echo '<h4>ปี : ' . (date("Y") - 2) . ' - ' . (date("Y")) . '</h4>';
echo funGridView($dataProvider,     $this->title . ' by quantity');
echo funGridView($dataProvider2,    $this->title . ' by amount');
