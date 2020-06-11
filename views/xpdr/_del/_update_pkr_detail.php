<?php
use kartik\grid\GridView;
use yii\helpers\Html;
 



?>
        <?php

        echo GridView::widget([
            'dataProvider' => $modeld,
            'responsiveWrap' => false,
            //'showPageSummary' => false,
            'columns' => [
                //['class' => 'kartik\grid\SerialColumn'],

                [
                    'attribute' => 'item',
                    'headerOptions' => ['width' => '200px'],
                ],
                [
                    'attribute' => 'material',
                    'headerOptions' => ['width' => '100px'],
                ],
                [
                    'attribute' => 'owner',
                    'headerOptions' => ['width' => '100px'],
                    'value' => function ($model) {
                        return (\app\models\xpkr::$owner_LIST[$model->owner]);
                    },
                ],


                [
                    'attribute' => 'remark',
                    'headerOptions' => ['width' => '200px'],
                ],


                [
                    //glyphicon glyphicon-edit

                    'class' => 'kartik\grid\ActionColumn',
                    //'template' =>'{update}{insert}{delete}',
                    'template' => '{update}{delete}',
                    'buttons' => [
                        'insert' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                                'title' => 'Insert',
                            ]);
                        }
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        $url = Yii::$app->urlManager->createUrl(
                            [
                                Yii::$app->controller->id . '/' . $action . '_detail', //$action = 'update' or 'delete'                            
                                'id' => $model->id,
                                'idh' => $model->pkr_id,

                            ]
                        );
                        return $url;
                    },
                    //'header' => $model->isNewRecord ? 'NEW':Html::a('<i class="glyphicon glyphicon-plus"></i>',
                    // 'header' => Html::a('<i class="glyphicon glyphicon-plus"></i>',                        
                    //     [Yii::$app->controller->id.'/create_detail',  'idh' => $model->pkr_id],
                    //     ['title'=>'เพิ่ม']
                    // ),
                    'visible' => ($editmode),
                    //'visible'=>false,

                ],

            ]
        ]);

        ?>