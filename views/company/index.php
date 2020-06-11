<?php

use yii\helpers\Html;
use app\components\gihelper;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $TABLECAPTION;
$this->params['breadcrumbs'][] = $this->title;
$gridViewPDF = [
    'mime' => 'application/pdf',     
    'config' => [        
        'cssInline' => file_get_contents(\Yii::getAlias('@app').'/web/css/kv-mpdf.css')
            .   '.kv-heading-1{font-size:58px}', 
                
        'format' => 'A4',
        'orientation'=>'P',
        'destination' => 'I',
        'marginTop' => 22,      
        'methods' => [
            'SetHeader' => ['<h5>'.gihelper::comp_name().'</h5>'.
            '<br>Company Report'.
            '||Page : {PAGENO}/{nbpg}<br><br>Date : ' . date("d-m-Y")],            
            'SetFooter' => ['.'],   
                             
        ],
    ],
];  
?>
<div class="etable-index">
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,        
        //'autoXlFormat'=>false,
        'panel'=>[
            'type'=>GridView::TYPE_DEFAULT ,
            'heading'=>'Company',

        ],
        'export'=>[
            'target'=>GridView::TARGET_BLANK,
            'encoding'=>'utf-8',            
        ],
        'exportConfig' => [   
            GridView::PDF => $gridViewPDF, 
            GridView::EXCEL => true, 
        ],               
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'headerOptions' => ['align'=>'center'],
                'contentOptions' => ['align'=>'center'],                                
            ],
            [
                'attribute'=>'CompanyCode',
                'label'=>'รหัส',
                'contentOptions' => ['width'=>100],
            
              
            ],
            [
                'attribute'=>'CompanyName',
                'contentOptions' => ['width'=>300],
                
                
            ],
            
            'Addr1',
            'TelePhone',
            'Fax',
         
            'CompanyEngName',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{view}{update}{delete}',
                'header' => Html::a(
                    '<i class="glyphicon glyphicon-plus"></i>',
                    [Yii::$app->controller->id.'/create'],
                    ['title'=>'เพิ่ม']
                )          
            ],        
        ],
  
    ]); 
    ?>

</div>
