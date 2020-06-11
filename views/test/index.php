<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\XTrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'X Trs';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<SCRIPT
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});;
/* To initialize BS3 popovers set this below */
$(function () { 
    $("[data-toggle='popover']").popover(); 
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
echo 'Testing for ' . Html::tag('span', 'tooltip', [
    'title' => 'This is a test tooltip',
    'data-toggle' => 'tooltip',
    //'style'=>'text-decoration: underline; cursor:pointer;'
    'style' => 'text-decoration:  cursor:pointer;'
]);


echo 'Testing for ' . Html::tag('span', 'popover', [
    'data-title' => 'Heading',
    'data-content' => 'This is the content for the popover',
    'data-toggle' => 'popover',
    'style' => 'text-decoration: underline; cursor:pointer;'
]);
?>
<div class="x-tr-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create X Tr', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            'id',
            [

                'attribute' => 'doc_no',
                'format' => 'raw',
                'value' => function ($model) {
                    $tr = Html::tag('span', $model->doc_no, [
                        'title' => $model->product['product_name'],
                        'data-toggle' => 'tooltip',
                        'style' => 'text-decoration: underline; cursor:pointer;'
                    ]);
                    return $tr;
                }
            ],
            'cust_no',
            'cust_name',
            'product_name',
            //'product_cat',
            //'product_cat_other',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>