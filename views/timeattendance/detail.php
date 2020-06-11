<?php

use kartik\grid\GridView;
use phpDocumentor\Reflection\Types\Context;

?>

<div class="row" >
    <div class="col-md-10 col-md-offset-2">
        <?= GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'rowOptions' => function ($model) {
                    //(date("w", strtotime($model['cdate'])) == 0 ? 'red' : '')
                    if (date("w", strtotime($model['cdate'])) == 0) {
                        return ['style' => "background-color:#F5F6CE;"];
                        //return ['class' => " bg-warning"];                        
                    }
                },                
                'columns' => [

                    [
                        'label' => 'วันที่',
                        'attribute' => 'cdate',
                        'format' => ['raw'],
                        'width' => '140px',
                        'content' => function ($model) {
                            $_d = strtotime($model['cdate']);
                            return date('d-m-Y', $_d)
                                . '&nbsp&nbsp&nbsp&nbsp<font color="' . (date("w", strtotime($model['cdate'])) == 0 ? 'red' : '')
                                . '">' . date('D', $_d) . '</font>';
                        }
                    ],
                    /* timelogColumn in index.php */
                    timelogColumn('r1'),
                    timelogColumn('r2'),
                    timelogColumn('r3'),
                    [
                        'label' => 'หมายเหตุ',
                        'attribute' => 'calendardesc',
                        'content' => function ($model) {
                            return (($model['calendardesc'] == null) ? '' : $model['calendardesc'])
                             .($model['rall'] == null ?'':'( '.$model['rall'].' )')
                            ;
                        },

                    ],
                    // [
                    //     'header' => 'Time',
                    //     'class' => 'kartik\grid\ExpandRowColumn',

                    //     'value' => function ($model, $key, $index, $column) {
                    //         return GridView::ROW_COLLAPSED;
                    //     },
                    //     'detail' => function ($model, $key)   {
                    //         return $model['rall'];

                    //         // return  
                    //         // '<div class="row">'
                    //         //     .'<div class="col-md-9 col-md-offset-3">'
                    //         //     .$model['rall']
                    //         // .'</div></div>';
                    //     },
                    //     //'headerOptions'=>['class'=>'kartik-sheet-style'], 
                    //     'expandOneOnly' => true,

                    // ],

                ]
            ]

        );
        ?>
    </div>
</div>