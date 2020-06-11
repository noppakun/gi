<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\XTrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'X Trs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="x-tr-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create X Tr', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'doc_no',
            'cust_no',
            'cust_name',
            'product_name',
            //'product_cat',
            //'product_cat_other',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
