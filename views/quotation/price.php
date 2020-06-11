<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\widgets\se2Typeinvent;
use yii\bootstrap\ActiveForm;
use app\models\ItemSearch;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemLocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quotation Price By Items';
$this->params['breadcrumbs'][] = $this->title;

$itemSearch   = new ItemSearch();


$columns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'hAlign'=>'center', 
    ],
    'Item_Number',
    'Item_Name',
    //'quotedetcount',
    [
        'header'=>'เสนอราคาล่าสุด',
        'value'=>function ($model, $key, $index, $column) {                  
            $searchModel    = new ItemSearch();
            //$rows           = $searchModel->quotationPrice1($model->Item_Number);
            $rows = $searchModel->quotationPrice($model->Item_Number,['byItems','top10','array']);
            
            if (!empty($rows)){
                $text = Yii::$app->formatter->format(strtotime($rows[0]['doc_date']), 'date');             ;
            } else {
                $text = '';
            }                    
            return $text;
        },
        //'text-align'=>'right',
        //'format'=>'date',
        'width'=>'100px',
        'hAlign'=>'center',                
        //'headerOptions' => ['class' => 'text-center'],                
        //'contentOptions' => ['style'=>'text-align:right'],                
        
    ],
    
    [
        // ------------------  Detail ------------------
        //'header'=>'Detail',
        'class'=>'kartik\grid\ExpandRowColumn',
 
        'expandOneOnly'=>false, 
  
        'defaultHeaderState'=>GridView::ROW_EXPANDED,
        'value'=>function ($model, $key, $index, $column) use ($itemSearch) {                  

            
            $poHistory      = $itemSearch->poHistory($model->Item_Number);
            $quotationPrice = $itemSearch->quotationPrice($model->Item_Number);

            if (($poHistory->totalCount==0) and ($quotationPrice->totalCount==0)){
                return GridView::ROW_COLLAPSED;
            }else{ 
                return GridView::ROW_EXPANDED;
            }

            //return GridView::ROW_COLLAPSED;
            return GridView::ROW_EXPANDED;
            //return GridView::ROW_NONE ;
            //print_r($column);

            //return (rtrim($model['Item_Number']) ==='R0090') ? (GridView::ROW_EXPANDED) : (GridView::ROW_COLLAPSED);

        },    
        'detail'=>function ($model, $key, $index, $column) use ($itemSearch) {                    
          
            
            $poHistory      = $itemSearch->poHistory($model->Item_Number,['byItems','top10']);
            $quotationPrice = $itemSearch->quotationPrice($model->Item_Number,['byItems','top10']);
          
            return Yii::$app->controller->renderPartial('priceDetail', [
                'poHistory'         => $poHistory,
                'quotationPrice'    => $quotationPrice,
                'viewby'            => 'item',
                'viewby_code'       => $model->Item_Number,

            ]);   
                    
        },
        //'headerOptions'=>['class'=>'kartik-sheet-style'], 
        'expandOneOnly'=>true,
        //'ExpandRowColumn'=>1,
        
    ],  
 
      
                         


];






?>
<div class="item-loc-index">

 
    


<?php
 ;
    $form = ActiveForm::begin([
            'method' => 'get',
            'layout' => 'horizontal',
            'fieldConfig' => [
                /*
                'horizontalCssClasses' => [
                    'label' => 'col-sm-1',
                    'offset' => 'col-sm-offset-3',
                    'wrapper' => 'col-sm-2'
                ]
                */
                
            ],
            'options' => [
                'class' => 'well',
            ],
        ]);

?>

    <div class="row">    
        <div class="col-md-5 col-sm-6  col-xs-12">     
            <?= se2Typeinvent::widget(['form' => $form, 'model' => $SelectForm, 
                'field'         => 'ti_code',             
                'idFilter'      => '|04|05|',
                'hideSearch'    => true,
                'options'       => ['onchange'=>'this.form.submit()'],   
                ])?>
                <!-- 
                    04	Raw Materials                                     
                    05	Packaging Materials                                
                -->        
        </div>    
                                                                                                                                                    

    </div>    
    

        
    

<?php
    $form::end();
?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns' => $columns,
        'responsiveWrap'=>false,  
        
    ]); ?>

</div>
