<?php

use yii\helpers\Html;

use kartik\form\ActiveForm; 
use kartik\grid\GridView;
use app\widgets\se2aItem;

use yii\data\ArrayDataProvider;

$this->title = 'สินค้าที่ถึงจุดสั่งซื้อ';

//$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => [$this->context->action->id]];
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([
    'method' => 'get',    
    'type' => 'horizontal',
    'options' => [
        'class' => 'well',
    ],
]);
?>

<div class="row">
    <div class="col-md-12">
        <?= se2aItem::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'item_number']);   ?>
    </div>
    <div class="col-md-12">
        <?= se2aItem::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'item_number2']);   ?>
    </div>
    <div class="col-md-3">
        <?= Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>
    </div>
</div>

<?php
$form::end();

?>


<div class="etable-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'responsiveWrap' => false,
        
        // Item_Number
        // ,Item_Name
        // ,Uom
        // ,Group_Product
    	// ,Item_type
    	// ,Type_Invent_Code
        // ,Lot_Size
        // ,LeadTime
        // ,Minimum
        // ,Maximum
        // ,QtyOnhand
        // ,LastBuyPrice
        // ,LastBuyDate
        // ,Supp_Number
        // ,Supp_Name
        // ,doctype
        // ,doc_no
        // ,due_date
        // ,qty         

        'columns' => [        
            [                
                'attribute' => 'Item_Number',                
            ],
            [
                'attribute' => 'Item_Name',
            ],
            'Uom',
            
            [
                'attribute' => 'Minimum',
                'hAlign' => 'right',
                'format'=>['decimal',2],                                    
            ],
            [
                'attribute' => 'QtyOnhand',
                'hAlign' => 'right',
                'format'=>['decimal',2],                                    
            ],

            [
                'attribute' => 'LeadTime',
                'hAlign' => 'right',
                'format'=>['decimal',2],                                    
            ],
            
           
            //'Group_Product',
            'LastBuyDate:date',
           
            [
                'attribute' => 'LastBuyPrice',
                'hAlign' => 'right',
                'format'=>['decimal',2],                                    
            ],            
            'Supp_Number',
            'Supp_Name',
            [               
                //'header' => 'PR/PO',
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function () {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model)  {  
                    
                    
                  

                    return 
                    '<div class="row">
                        <div class="col-md-11 col-md-offset-1">'.
                        GridView::widget([
                            'dataProvider' => _item_pr_po($model['Item_Number']),
                            'responsiveWrap' => false,
                            'columns'=>[
                                
                                'doctype',
                                'doc_no',
                                'due_date:date',
                                [
                                    'attribute' => 'qty',
                                    'hAlign' => 'right',
                                    'format'=>['decimal',2],                                    
                                ],
                                
                            ]
                        ])
                        .'</div>
                    </div>';
                    
                    

   
                },
                //'headerOptions'=>['class'=>'kartik-sheet-style'], 
                'expandOneOnly' => true,

            ],


        ]
        // 'columns' => [
        //     [                
        //         'attribute' => 'Item_Number',
        //         'group' => true,
        //     ],
        //     [                
        //         'attribute' => 'Item_Name',
        //         'group' => true,
        //         'subGroupOf' => 0,
        //     ],
        //     [
        //         'label'=>'จำนวนรับ',
        //         'attribute' => 'Recv_Qty',
        //         'format' => ['decimal', 2], 'hAlign' => 'right',
        //     ],          
        //     [
        //         'label'=>'เลขที่ใบรับ',
        //         'attribute' => 'VoucherNo',
        //     ],                                  
        //     [
        //         'label'=>'วันที่รับ',
        //         'attribute' => 'DocDate',
        //         'format' => 'date',
        //     ],                                  
        //     [                
        //         'attribute' => 'Ana_No',
        //     ],                                  

        // ]
    ]);
    ?>
</div> 
<?php
    // ******************************************************************************************
    function _item_pr_po($Item_Number){
        $sql = "
            declare @item_number varchar(20)

            set @item_number =  '8850279427167'

            set @item_number =  :item_number


            Select c.* from 
            (
                select 'PO' as doctype, A.Order_Number as doc_no,B.Item_Number,B.due_date
                --,B.Order_Qty,B.Rlse_Qty,B.Rej_Qty        
                ,b.Order_Qty-b.Rlse_Qty-b.Rej_Qty as qty          

                From PO A,PODetail B
                where 1=1
                --Where B.Item_Number=:cItem_Number        
                And A.CompanyCode=B.CompanyCode
                And A.Order_Number=B.Order_Number
                And A.Open_Close=0 And ((B.Order_Qty>(B.Rlse_Qty-B.Rej_Qty)) or B.Rlse_Qty is null)
                And B.Type_Desc=0
                -- Order By B.Item_Number,B.Due_Date,A.Order_Number
                union        
                

                Select 'PR' as doctype,A.PR_Number  as doc_no,B.Item_Number,B.Due_Date
                --,B.Order_Qty,B.Rlse_Qty
                ,b.Order_Qty-b.Rlse_Qty as qty
                From PR A,PRDetail B
                Where 1=1 
                -- B.Item_Number=:cItem_Number
                And A.CompanyCode=B.CompanyCode
                And A.PR_Number=B.PR_Number
                And A.Open_Close=0 And (B.Order_Qty>B.Rlse_Qty or B.Rlse_Qty is null)
                And A.PO_Issue=0
                And B.Type_Desc=0
                --Order By B.Item_Number,B.Due_Date,A.PR_Number
                    
            )c where c.item_number=@item_number        
            ORDER by c.Due_Date,c.doctype   
        ";    
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $command->bindParam(":item_number", $Item_Number);        

        $rows = $command->queryAll();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            // 'pagination'=>[
            //     'pageSize'=>50,
            // ],
        ]);     
        return $dataProvider;
    }

?>