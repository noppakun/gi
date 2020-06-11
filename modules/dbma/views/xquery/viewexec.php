<style>
    .vcenter {
        display: inline-block;
        vertical-align: middle;
        float: none;
    }
</style>
<?php

use yii\helpers\Html;
use kartik\grid\GridView;



$this->title = str_replace("#count", "", $model->description);
if ($this->context->action->id == 'view') {   //  run in xquery
    $this->params['breadcrumbs'][] = ['label' => 'XQuery', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
} else { // run in gi app menu
    $this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => [$this->context->action->id]];
}

?>


<div class="xquery-index">
    <div class="row well">
        <div class="col-md-9 vcenter">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
        <?php
        //print_r($this->layout); 
        //print_r(Yii::$app->controller->id); 
        //print_r(Yii::$app->controller->layout); 
        
        ?>
        <div class="col-md-2 text-right vcenter <?= $viewOptions['export_xls']? '':'hidden'?>">
            <?= Html::a(
                '<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export ( XLS )',                
                [$this->context->action->id, 'id' => $id, 'TOSPREADSHEET' => true],
                ['class' => 'btn btn-success']
            ) ?>
        </div>
    </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        //'floatHeader' => true,
        'columns' => $searchColumns
    ]); ?>
</div>