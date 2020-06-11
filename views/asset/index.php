<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $TABLECAPTION;
$this->params['breadcrumbs'][] = $this->title;
  
?>
<div class="etable-index">
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'hAlign' => 'center',
            ],
            

            [
                'attribute'=>'AssetCode',
                'contentOptions' => ['width'=>100],
            ],
            'AssetName',

            [
                'attribute'=>'AssetDate',
                'format' => ['date'],
                'contentOptions' => ['width'=>100],
            ],
            
            [
                'attribute'=>'Recv_Date',                
                'format' => ['date'],
                'contentOptions' => ['width'=>100],
            ],            
            [
                'attribute'=>'VoucherNo',
                'contentOptions' => ['width'=>100],
            ],            
            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{update}',
            ],        
        ],
  
    ]); 
    ?>

</div>



