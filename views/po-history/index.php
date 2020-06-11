<?php
use kartik\grid\GridView;
use app\components\gihelper;
$TABLECAPTION = 'Purchase Order History';
$this->title = $TABLECAPTION;
$this->params['breadcrumbs'][] = $this->title;


if ($viewby!=null){    
    if ($viewby=='supp'){    
        $Supplier=app\models\Supplier::find()->where(['Supp_Number' => $viewby_code])->one();
        $this->params['breadcrumbs'][] = $viewby_code.' : '.$Supplier->Supp_Name;
    }else if ($viewby=='item'){    
        $Item=app\models\Item::find()->where(['Item_Number' => $viewby_code])->one();
        $this->params['breadcrumbs'][] = $viewby_code.' : '.$Item->Item_Name;
    }    
}

$qedit_index_columns = [
    'Order_Number',        
    [
        'attribute' => 'Order_date',
        'value' => 'po.Order_date',
        'format'=>'date',
    ],         
    [
        'attribute' => 'Supp_Number',
        'value' => 'po.Supp_Number',    
        'visible'=> ($viewby!='supp'),

        
    ],  
    [
        'attribute' => 'Supp_Name',
        'value' => 'po.supplier.Supp_Name',    
        'visible'=> ($viewby!='supp'),
    ],          
    [
        'attribute' => 'Item_Number',
       
        'visible'=> ($viewby!='item'),
    ],  
    [
        'attribute' => 'PurDet_Desc',
       
        'visible'=> ($viewby!='item'),
    ],  


    [
        'attribute' => 'Order_Qty',            
        'format' => ['decimal',2],   
        'hAlign'=>'right',
    ],  

    [
        'attribute' => 'Price',            
        'format' => ['decimal',2],   
        'hAlign'=>'right',
    ],  


];
$XQEDIT = [
    'index_rowoptions'=>null,
    'exportconfig_pdf_orientation'=>'P',
    'exportconfig_pdf_footer'=>null,
];
$grid_property = [
    'responsiveWrap' => false,    
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,    
    'columns' => $qedit_index_columns,   
    'rowOptions' => $XQEDIT['index_rowoptions'],          
    'toolbar'=>false, 
    'panel'=>[    
        'type'=> 'success',
        'before'=> false,
    ]      
];
    $grid_property['panel']['before']='';
    $grid_property['toolbar']='{toggleData}{export}';
    $grid_property['export']=[
        'target' => GridView::TARGET_BLANK,
    ];    
    $grid_property['exportConfig'] =[
        GridView::CSV => [],
        GridView::PDF => [
            'mime' => 'application/pdf',     
            'config' => [        
                'cssInline' => file_get_contents(\Yii::getAlias('@app').'/web/css/kv-mpdf.css'),        
                'format' => 'A4',
                'orientation'=>$XQEDIT['exportconfig_pdf_orientation'],
                'destination' => 'I',
                'marginTop' => 22,      
                'methods' => [
                    'SetHeader' => ['<h5>'.gihelper::comp_name().'</h5>'.
                    '<br>'.$TABLECAPTION.
                    '||Page : {PAGENO}/{nbpg}<br><br>Date : ' . date("d-m-Y")],  
                    'SetFooter' => isset($XQEDIT['exportconfig_pdf_footer']) ? $XQEDIT['exportconfig_pdf_footer'] : ['.'],   
                                     
                ],
            ],
        ]        
    ]; 
    
?>
<?= GridView::widget($grid_property)?>       

<!-- <?= GridView::widget([       
    'responsiveWrap' => false,
    'dataProvider' => $dataProvider,
    'headerRowOptions' => ['class' => 'success'],
    'floatHeader'=>true, 
    'filterModel' => $searchModel,        
    
     
    'columns'=> $qedit_index_columns
])?> -->