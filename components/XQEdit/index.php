<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\gihelper;
use yii\helpers\Url;
$this->title = $TABLECAPTION;
$this->params['breadcrumbs'][] = $this->title;
 
$qedit_index_columns= index_columns([
    'columns'=>$XQEDIT['index_columns'],
    'template'=>$XQEDIT['index_actioncolumn_template'],  
    'urlcreator'=>index_urlcreator($XQEDIT['index_actioncolumn_urlcreator']),
    //'model'=> $dataProvider->getModels(),
    'modelClass'=> $dataProvider->query->modelClass,    
    
]);


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
 

    
if (isset($XQEDIT['exportconfig_pdf_orientation'])){  // 'P' , 'L'
    $grid_property['panel']['before']='';
    $grid_property['toolbar']='{toggleData}{export}';
    $grid_property['export']=[
        'target' => GridView::TARGET_BLANK,
    ];    
    $grid_property['exportConfig'] =[
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
}
if (isset($XQEDIT['properties'])){ 
    $grid_property = array_merge($grid_property,$XQEDIT['properties']);
    //\app\components\XLib::xprint_r($grid_property);
    ///\app\components\XLib::xprint_r($XQEDIT['properties']);
    
}

?>

<?=(isset($XQEDIT['index_text_before']))?$XQEDIT['index_text_before']:null; ?>        
    
<div class="etable-index">
    <?= GridView::widget($grid_property);?>
</div>
 
<?php
    // -------------------------------------------------------------------------------------------------------------------
    function index_urlcreator($param){
    // -------------------------------------------------------------------------------------------------------------------
        if (isset($param)){
            return $param;
        }else{
            return function ($action, $model, $key, $index) { 
                foreach($model->tableSchema->primaryKey as $key => $value ){            
                    $xid = isset($xid)?$xid.'|'.$model[$value]:$model[$value];
                }             
                return Url::toRoute([Yii::$app->controller->id.'/'.$action, 'id' => $xid]);
            };
        }

    }
    // -------------------------------------------------------------------------------------------------------------------
    function index_columns($param){
    // -------------------------------------------------------------------------------------------------------------------
        // echo Yii::$app->controller->id;
        // echo '<pre>';
        // print_r($columns);
        // echo '</pre>';
        //$model->getTableSchema()->columns['attr']->type
        //print_r($param['model']);

        $modelClass = $param['modelClass']; 

        //$class = '\Foo\Bar\MyClass'; 
        $model = new $modelClass();

        //echo $param['modelClass'];
        //echo $model->getTableSchema()->columns['ChqStatusDesc']->type;
        //\app\components\XLib::xprint_r($model->getTableSchema());

        $columns = $param['columns'];
        foreach($columns as $key =>$column){
            if (is_string($column)){
                // check only real field  not a function field
                if (array_search($column,$model->getTableSchema()->columns)){
                    switch ($model->getTableSchema()->columns[$column]->type) {                    
                        case "datetime":
                            $columns[$key]=[
                                'attribute'=>$column,
                                'format' => ['date'],
                            ];
                            break;
                        case "decimal":
                            $columns[$key]=[
                                'attribute'=>$column,                            
                                'format' => ['decimal',2],
                                'contentOptions' => ['align' => 'right' ],
                            ];                          
                            break;
                    }                
                }
            }
        }
        array_unshift($columns ,  [
            'class' => 'kartik\grid\SerialColumn',
            'hAlign' => 'center',
        ]);
        if (isset($param['template'])){
            array_push($columns,[
                'class' => 'kartik\grid\ActionColumn',   
                'template' => $param['template'],
                'urlCreator'=>$param['urlcreator'],
                'noWrap'=>true,
                //--------------------------- 
                'header' => (strpos($param['template'], '{create}') !== false)                 
                ? Html::a(
                    '<i class="glyphicon glyphicon-plus"></i>',
                    [Yii::$app->controller->id.'/create'],
                    ['title'=>'เพิ่ม']
                ):null,
                             
            ]);
        }
        return $columns;
    }
    
?> 