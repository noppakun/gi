<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SparepartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Spare Parts';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sparepart-index">

    <h1><?= Html::encode($this->title) ?></h1>
    


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Item_Number',
            'Item_Name',
            'Uom',
            'Remark1_Coding',            

        ],
    ]); ?>

</div>
