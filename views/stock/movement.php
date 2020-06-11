<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use app\widgets\se2CompanyItem;
use app\widgets\se2DocType;


use yii\data\ArrayDataProvider;
use app\components\gihelper;

 
$form = ActiveForm::begin([
    'method' => 'get',                        
    'options' => [
        'class' => 'well',
    ],                                    
]);
?>
<div class="form-group">    
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-5">
            <?=
                $form->field($SelectForm, 'date')->widget(DatePicker::className(),[
                    'type' => DatePicker::TYPE_INPUT,
                    'removeButton' => ['icon' => 'trash'],
                    'pickerButton' => false,
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ])                
            ?>             
        </div>            
        <div class="col-md-2 col-sm-2 col-xs-5">    
            <?=
                $form->field($SelectForm, 'date2')->widget(DatePicker::className(),[
                    'type' => DatePicker::TYPE_INPUT,
                    'removeButton' => ['icon' => 'trash'],
                    'pickerButton' => false,
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ])                
            ?>     
        </div>        
        <div class="col-md-2 col-sm-2 col-xs-5">   
            <?= se2CompanyItem::widget(['form' => $form, 'model' => $SelectForm, 
                'field' => 'co_code',
                'showToggleAll'=>false,
                //'selectAll'=>true,
                //'idFilter' => $SelectForm->var3
            ])?>        
        </div>  
        <div class="col-md-3 col-sm-3 col-xs-6">   
            <?= se2DocType::widget(['form' => $form, 'model' => $SelectForm, 
                'field' => 'doctype',
                'showToggleAll'=>false,
                //'selectAll'=>true,
                //'idFilter' => $SelectForm->var3
            ])?>        
        </div>                
    </div>
    <div class="row">    
        <div class="col-md-2 col-sm-2  col-xs-2">                  
            <?=Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>            
        </div>                  
    </div>    
</div>


<?php        
ActiveForm::end();


      



$gridViewPDF = [
    'mime' => 'application/pdf',     
    'config' => [        
        'cssInline' => file_get_contents(\Yii::getAlias('@app').'/web/css/kv-mpdf.css'),        
        'format' => 'A4',
        'orientation'=>'L',
        'destination' => 'I',
        'marginTop' => 22,      
        'methods' => [
            'SetHeader' => ['<h5>'.gihelper::comp_name().'</h5>'.    
            '<br>รายงานความเคลื่อนไหวของสินค้า'.                
            '||Page : {PAGENO}/{nbpg}<br><br>Date : ' . date("d-m-Y")],  
            //'SetFooter' => ['FM-068'],   
                             
        ],
    ],
];  

?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'export'=>[
            'target' => GridView::TARGET_BLANK,
        ],
        'panel'=>[
            'before'=>''
        ],        
        'exportConfig'=>[
            GridView::PDF => $gridViewPDF,
            
            // GridView::CSV => [],
            // GridView::EXCEL =>[],
            
        ],            
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                    
                },
                'detail' => function ($model, $key, $index, $column) {
                    $query = $model->stCard;
                  
            
                    $dataProvider = new ArrayDataProvider([
                        'allModels' => $query,
 
                     ]);

                    return Yii::$app->controller->renderPartial('_movement-details', ['dataProvider' => $dataProvider]);
                    //return Yii::$app->controller->renderPartial('_movement-details', ['dataProvider' => $query]);
                },
                //'headerOptions' => ['class' => 'kartik-sheet-style'] ,
                'expandOneOnly' => true,
                'hiddenFromExport'=> false,
            ],
            [
                'attribute'=>'DocDate',
                'format' => ['date'],
                'contentOptions' => ['width'=>100],
            ],  
            [
                'attribute'=>'VoucherNo',              
                'contentOptions' => ['width'=>100],
            ],                        
            [
                'attribute'=>'Order_Number',              
                'contentOptions' => ['width'=>100],
            ],                        
            
            [
                'attribute'=>'JobNo',              
                'contentOptions' => ['width'=>100],
            ],                        
            
         
          
            'RefDoc',
            'Remark',






            //'CompanyCode',
            // 'DocType',
            // [
            //     'attribute'=>'DocTypeDesc',                
            //     'value'=>'doctype_ref.DocTypeDesc',                
            //     'contentOptions' => ['style' => 'width:30px;    '], 
            // ],             
            
            
            
            
            
            
            //'AccountCode',
            //'Manufacturer',
            //'Supplier_Lot',
            //'RefDoc2',
            //'UserName',
            //'VatRate',
            //'VatAmt',
            //'RecvDocDate',
            //'PO_NO',
            //'Inv_Number',
            //'Inv_Date',
            //'Supp_Number',
            //'Supp_Name',
            //'Discount',
            //'Deposit',
            //'Amount',
            //'TotalAmount',
            //'PaidAmount',
            //'PostGL',
            //'UserPostGL',
            //'DateTimePostGL',
            //'PrintDocStatus',
            //'BranchCode',
            //'AccountCode_Tax',
            //'TransferStatus',
            //'TaxID',
            //'BranchNo',
            //'DivisionCode',
            //'DeptCode',
            //'AccountCode_Deposit',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>