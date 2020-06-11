<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\widgets\se2Typeinvent;
use yii\bootstrap\ActiveForm;
use app\models\ItemSearch;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemLocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quotation Price By Supplier';
$this->params['breadcrumbs'][] = $this->title;




$columns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'hAlign'=>'center', 
    ],


    'Supp_Number',
    'Supp_Name',
    // [
    //     'header'=>'เสนอราคาล่าสุด',
    //     'value'=>function ($model, $key, $index, $column) {                  
    //         $searchModel    = new ItemSearch();
    //         $rows           = $searchModel->quotationPrice1($model->Item_Number);
    //         if (!empty($rows)){
    //             $text = Yii::$app->formatter->format(strtotime($rows[0]['doc_date']), 'date');             ;
    //         } else {
    //             $text = '';
    //         }                    
    //         return $text;
    //     },
    //     'width'=>'100px',
    //     'hAlign'=>'center',                        
    // ],
    
    [
        // ------------------  Detail ------------------
        'header'=>'Detail',
        'class'=>'kartik\grid\ExpandRowColumn', 
        'value'=>function ($model, $key, $index, $column) {                              
            //return GridView::ROW_COLLAPSED;
            return GridView::ROW_EXPANDED;
        },    
        'detail'=>function ($model, $key, $index, $column)  {                              
            $searchModel    = new ItemSearch();
            $poHistory      = $searchModel->poHistory($model->Supp_Number,['bySupplier','top10']);
            $quotationPrice = $searchModel->quotationPrice($model->Supp_Number,['bySupplier','top10']);            
            
            return Yii::$app->controller->renderPartial('priceDetail', [
                'poHistory'         => $poHistory,
                'quotationPrice'    => $quotationPrice,
                'viewby'            => 'supp',                
                'viewby_code'       => $model->Supp_Number,
                //'suppNumber'        => $model->Supp_Number,
            ]);                
        },
        'expandOneOnly'=>true,        
    ],  
 
      
                         


];






?>
<div class="item-loc-index">

 
    
  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns' => $columns,
        'responsiveWrap'=>false,  
        
    ]); ?>

</div>
