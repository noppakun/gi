<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\UrlManager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

 

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CompanyCode',
            'Order_Number',
            'Order_date:date',
            'Pr_Number',
            'DivisionCode',
            'DeptCode',
            'Supp_Number',
            'Buyers',

            //-- ----------


            //
            
            
            // 'Shipto_Addr1',
            // 'Shipto_Addr2',
            // 'Currency_Type',
            /*
             'Remark1',
             'Remark2',
             'Remark3',
             */
            
            
            //'Remarks:ntext',
            
            // 'Terms',
            // 'Po_Issue',
            // 'Open_Close',
            // 'Close_Date',
            // 'Service',
            // 'Insurance',
            // 'Carriage',
            // 'Vat_Percent',
            // 'Vat_Amt',
            // 'Disc_Percent',
            // 'Disc_Cash',
            // 'Revision_No',
            // 'Revision_Date',
            // 'Vat_Type',
            // 'ForWork',
            
            // 'LimitOverOrderRate',
            // 'currency_Rate',
            // 'ShipMent',
            [
                'attribute'=>'Amount',
                'format'=>['decimal',2],
                'label'=>'ยอดรวม',                
                'contentOptions' => ['align' => 'right' ],
            ],
            // 'TotalAmount',
            // 'UserName',
            // 'LastUpdate',
            // 'PO_Approve',
            // 'UserName_Approve',
            // 'DateTime_Approve',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' =>'{update}{delete}{print}',
                'buttons' => [
                    'print' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-print"></span>', $url);
                    }
                ],  
                'urlCreator' => function ($action, $model, $key, $index)  {
                    $url = Yii::$app->urlManager->createUrl(                                            
                              [
                                Yii::$app->controller->id.'/'.$action, //$action = 'update' or 'delete'
                                //'id' => $model->Order_Number,                                
                                'CompanyCode'=>$model->CompanyCode,
                                'id'=>$model->Order_Number,
                                
                              ]                      
                        );                 
                    return $url ;
                },  
                'header' => Html::a(
                    '<i class="glyphicon glyphicon-plus"></i>',
                    [Yii::$app->controller->id.'/create'],
                    ['title'=>'เพิ่ม']
                ), 
            ],            
        ],
    ]); ?>

</div>
