<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//echo action; 
?>
<style>
.xxxYourCustomTableClass table thead {
    background-color: 	 #ffff99
}
</style>
<div class="etable-index">
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,        
        //'autoXlFormat'=>false,
        'options' => [
            'class' => 'YourCustomTableClass',
         ],        
      
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'headerOptions' => ['align'=>'center'],
                'contentOptions' => ['align'=>'center'],                                
            ],
            [
                'attribute'=>'pif_id',
                'contentOptions' => ['width'=>200],
                'content'=>function($model, $key, $index, $column){                        
                    return Html::a(
                        $model->pif_id,
                        [Yii::$app->controller->id.'/view',
                            'id' => $model->id,
                        ]);
                }

 
            ],
            [
                'attribute'=>'items_ref',                
            ],
            [
                'attribute'=>'pif_name',                
            ],
            //'approve_datetime',

            [
                'class' => 'kartik\grid\ActionColumn',
                //'template'=>'{view}{update}{delete}',
                'template'=>'{update}{delete}',
                'header' => Html::a(
                    '<i class="glyphicon glyphicon-plus"></i>',
                    [Yii::$app->controller->id.'/create'],
                    ['title'=>'เพิ่ม']
                ),         
                'visible' => ($actionmode == 'INDEX') ,
            ],        
        ],
  
    ]); 
    ?>

</div>
