
<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $TABLECAPTION;
$this->params['breadcrumbs'][] = $this->title; 
?>
 
<?= $this->render('_list', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'actionmode'=>'READ',
]) ?>
 
