<?php
use app\models\WPlanDet;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;

use kartik\form\ActiveForm;
use kartik\builder\Form;
 


//\app\components\XLib::xprint_r($wca);
//\app\components\XLib::xprint_r( \app\models\Item::$ControlItemType_LIST);
/*   param
'Compound'=>$Compound,
'WPlanDet'=>$WPlanDet,
'pmu'=>$packaging_materials_usage,
*/
// $key = array_search($model->component, array_column($pmu->allModels, 'Component'));
// echo $key;
//         echo '<pre>';
//         print_r($pmu->allModels[
//           array_search($model->component, array_column($pmu->allModels, 'Component'))
//         ]['Uom']);
//         echo '</pre>';
$uom = $pmu->allModels[
    array_search($model->component, array_column($pmu->allModels, 'Component'))
  ]['Uom'];



$TABLECAPTION = 'WASTE RECORD : '.$model->component;
$this->title = $TABLECAPTION ;
$this->params['breadcrumbs'][] = ['label'=>'BATCH PACKING RECORD', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $WPlanDet->Order_No.' - '.$WPlanDet->Item_Number, 'url' => ['view','order_no' => $WPlanDet->Order_No,'item_number' => $WPlanDet->Item_Number,  ]];
$this->params['breadcrumbs'][] = $this->title;

 
// ----------------
echo DetailView::widget([
  'model' => $WPlanDet,
  'attributes' => [
   
    [
      'columns' => [          
        [
          'label' => 'PRODUCT CODE',
          'attribute'=>'Item_Number',
    //      'labelColOptions'=>['style'=>'width:auto'],   
        
        ],    
        [                      
          'label' => 'PRODUCT',      
          'value' => $WPlanDet->bom->item->Item_Name,
        
        ],             
      ],
    ],  
   
      
    
  ],
]);
 
?>


<!-- HEAD -->
<div class="panel  panel-primary" >  
  <?php
  $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
  ?> 
  <div class="panel-body">        
    <div class="row">       
    <div class="col-md-6">  
      <table class="table table-bordered table-striped detail-view">  
        <tbody>
        <tr>
            <th colspan="4" class="text-center">
              MAN HOURS RECORD
            </th> 
          </tr>    
          <tr>
          <th>
            OPERATIONS
          </th>
          <th class="text-center">
            NO. OF <br>OPERATIONS
          </th>
          <th class="text-center">
            HOURS PAID
          </th>
          <th class="text-center">
            ACTUAL
          </th>
        </tr>
          <tr>
            <th>
              CODING
            </th>
            <td>
              <?=$form->field($modelExt, 'mh_c_no')->label(false);?>
            </td>
            <td>
              <?=$form->field($modelExt, 'mh_c_hp')->label(false);?>
            </td>        
            <td>
              <?=$form->field($modelExt, 'mh_c_ac')->label(false);?>
            </td>        

          </tr>
          <tr>
            <th>
              WASHING        
            </th>
            <td>
              <?=$form->field($modelExt, 'mh_w_no')->label(false);?>
            </td>
            <td>
              <?=$form->field($modelExt, 'mh_w_hp')->label(false);?>
            </td>        
            <td>
              <?=$form->field($modelExt, 'mh_w_ac')->label(false);?>
            </td>        

          </tr>
          <tr>
            <th>
              PACKING
            </th>
            <td>
              <?=$form->field($modelExt, 'mh_p_no')->label(false);?>
            </td>
            <td>
              <?=$form->field($modelExt, 'mh_p_hp')->label(false);?>
            </td>        
            <td>
              <?=$form->field($modelExt, 'mh_p_ac')->label(false);?>
            </td>        


          </tr>
        </tbody>
      </table>    
    </div>  
    <div class="col-md-6">
    
      <?php  
      echo Form::widget([
        'model'=>$modelExt,
        'form'=>$form,
        'columns'=>2,

        'attributes'=>[            
            'netfill'=>['type'=>Form::INPUT_TEXT,  ],
                
            'uom'=>[
              'type'=>Form::INPUT_DROPDOWN_LIST,
              'items'=>(new app\widgets\se2Uom)->itemsQueryArrayMap(),                                          
              // 'options'=>[
              //     'id'=>'wh-id'
              // ],                                         
            ],          
            // 'actions'=>[
            //   'type'=>Form::INPUT_RAW,             
            //   'value'=>'<div class="text-right" >'
            //     .Html::submitButton('Save', ['class'=>'btn btn-success ' ])
            //     .'</div>',
                              
            // ],                   
            
            'order_no'=>['type'=>Form::INPUT_HIDDEN,  ],
            'item_number'=>['type'=>Form::INPUT_HIDDEN,  ],            
        ]
      ]);    
      echo Html::submitButton('Save', ['class'=>'btn btn-success ' ]);
    ?>
    </div>       
  </div>
  <?php        
                       
    ActiveForm::end();       
    ?>
  </div>
  
</div>  











<div>

  <?php
  
  echo GridView::widget([
      'dataProvider' => $pmu,  // 'pmu'=>$packaging_materials_usage,
      'responsiveWrap' => false, 
      // 'rowOptions'=>function($model) use ($WPlanDet){
      //    //$WPlanDet->XWplandetWasteSumQty($model['Component'])
                 
      //   if($model['waste']  !== $WPlanDet->XWplandetWasteSumQty($model['Component'])){
      //       return ['class' => 'danger'];
      //   }
      // },
      'columns'=>[    
        [                    
          'label' => 'MAT.CODE',
          'attribute' => 'Component', 
          'value'=> function($model) use ($WPlanDet){        
            return Html::a($model['Component'] 
              , ['waste', 
              'order_no' => $WPlanDet->Order_No,
              'item_number' => $WPlanDet->Item_Number ,              
              'component' => $model['Component'] ,              
              ]);  
 
            
          },            
          
          'format'=>'raw',        
        ],     
        [                    
          'label' => 'PACKAGING MATERIALS',
          'attribute' => 'Item_Name',       
          'headerOptions' => ['style'=>'text-align:center'],
          // 'contentOptions'=>function($model){
          //   return [
          //     'id'=>'pmu-item_name',
          //     'onclick'=>'setComponentCode("'.$model['Component'].'")',
          //     'onmouseover'=>'mouseOver(this)',
          //     'onmouseout'=>'mouseOut(this)'
          //   ];
          // }  
          
        ],         
        [                    
          'label' => 'UNIT',
          'attribute' => 'Uom', 
          'hAlign' => 'center',
 

        ],      
      

        [
          'class'=>'kartik\grid\ExpandRowColumn',
          'width'=>'50px',    
          'value'=>function ($model, $key, $index, $column) {
              return GridView::ROW_COLLAPSED;
          },    
          'detail'=>function ($model, $key, $index, $column) use ($WPlanDet) {
              return GridView::widget([
                'panel'=>[    
                  'type'=> 'success',
                  'before'=> false,
                  'heading' => ('Total to balance = '.number_format($model['waste'],0)),
                  'footer'=>false,
                ],  
                              
                'dataProvider' => new ActiveDataProvider([
                    'query' => $WPlanDet->XWplandetWaste($model['Component']),                  
                  ]), 
                'columns'=>[
                  [
                    'attribute'=>'tran_date',
                    
                    'format'=>'date',                    
                    'width' => '100px',
                  ],  
                  [
                    'attribute'=>'wca_code',
                    'label'=>'สาเหตุ',
                    'width' => '200px',
                    //'value'=>function($model) use ($wcalist) {
                    'value'=>function($model)  {        
                      $wca_list = (new app\widgets\se2Wca)->itemsQueryArrayMap();                                            
                      return (array_key_exists($model->wca_code,$wca_list)) ? $wca_list[$model->wca_code] : 'N/A';
                    }
                  ],                                    
                  'reason',
                  [
                    'attribute'=>'qty',
                    'format'=>['decimal',2],
                    'hAlign'=>'right',
                    'width' => '100px',
                  ],

                  [
                    'class' => 'kartik\grid\ActionColumn',   
                    'template' => '{update}{delete}',
                    'urlCreator'=>function ($action, $model, $key, $index) { 
                      $url = Url::toRoute([Yii::$app->controller->id.'/waste_'.$action
                          ,'order_no' => $model->order_no
                          ,'item_number' => $model->item_number
                          ,'component' => $model->component
                          ,'id' => $model->id
                          // $model->CompanyCode.'|'.
                          // $model->GLBookCode.'|'.
                          // $model->VoucherNo
                      ]);
                      return $url; 
                    },
                    'noWrap'=>true,
                    //--------------------------- 
                    // 'header' => (strpos($param['template'], '{create}') !== false)                 
                    // ? Html::a(
                    //     '<i class="glyphicon glyphicon-plus"></i>',
                    //     [Yii::$app->controller->id.'/create'],
                    //     ['title'=>'เพิ่ม']
                    // ):null,
                                 
                ]                  
                  

                ],
              ]);
          },
          'expandOneOnly'=>true,
    
      ],        
        // --------------------------------------
        // summary from XWplandetWaste
        // --------------------------------------
        [
          'label' => 'WASTE',                 
          'value'=> function($model) use ($WPlanDet){         
            $v = $WPlanDet->XWplandetWasteSumQty($model['Component']);
            return ($v  == 0?'-':number_format($v,( trim($model['Uom'])!='ea'?2:0 ) ));       

            
          },            
          'format'=>'raw',              
          'hAlign' => 'right',       
          'contentOptions'  =>function($model) use ($WPlanDet){            
           if($model['waste']  !== $WPlanDet->XWplandetWasteSumQty($model['Component'])){
               return ['class' => 'text-danger'];
           }
          },          



        ],      
      // --------------------------------------
      // from query left join from packaging_materials_usage->XWplandetWaste
      //'qty_waste',        
      // --------------------------------------

      // --------------------------------------
      // auto cal from packaging_materials_usage                   
      // --------------------------------------
      // [
      //   'label' => 'WASTE(auto)',      
      //   'attribute' => 'waste',      
      //   'value'=> function($model) {         
      //     return ($model['waste']  == 0?'-':number_format($model['waste'],0));           
      //   },            
      //   'format'=>'raw',              
      //   'hAlign' => 'right',
      // ],         


    ]    
  ]); 
  ?>


  <?php
    //$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue", ['position' => \yii\web\View::POS_HEAD]);
  ?>
   
  <div class="panel  panel-primary" id = "app">
  <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);?>
  <!-- {{textvue}} -->
    
    <div class="panel-body">        
      <?php  
      echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>12,

        'attributes'=>[            
            'component'=>[
              'type'=>Form::INPUT_HIDDEN_STATIC,
              'columnOptions'=>['colspan'=>2],
            ],     
             
            'wca_code'=>[
              'type'=>Form::INPUT_DROPDOWN_LIST,
              'items'=>(new app\widgets\se2Wca)->itemsQueryArrayMap(),              
              'columnOptions'=>['colspan'=>2],
            ],              
            'reason'=>[
              'type'=>Form::INPUT_TEXT,  
              'columnOptions'=>['colspan'=>5],
            ],
            'qty'=>[
              'type'=>Form::INPUT_TEXT,  
              'label'=>'จำนวน ( '.$uom.' )' ,              
              'columnOptions'=>['colspan'=>2],
            ],
            'actions'=>[
              'type'=>Form::INPUT_RAW, 
              'value'=>'<div class="text-right" >'
              .Html::submitButton('Save', ['class'=>'btn btn-success '])
              .'</div>'
            ],                              
                 
            
                       
            'tran_date'=>['type'=>Form::INPUT_HIDDEN ],
            'order_no'=>['type'=>Form::INPUT_HIDDEN,  ],
            'item_number'=>['type'=>Form::INPUT_HIDDEN,  ],            
            
        ]
      ]);      
      ActiveForm::end();       
      ?>
    </div>
  </div>  
 </div>

 
 <script>

    // function mouseOver(obj) {
    //     //document.getElementById("pmu-item_name").style.color = "red";
    //     obj.style.color = "red";
    // }

    // function mouseOut(obj) {
    //     //  document.getElementById("pmu-item_name").style.color = "black";
    //     obj.style.color = "black";
    // }

    // function setComponentCode(p1) {
    //   document.getElementById("xwplandetwaste-component").value = p1;
    //   document.getElementById("waste-update-title").innerHTML = 'WASTE RECORD : '+p1;      
    // }

 </script>
 
<!--  
 <script>
 new Vue({
   el:'#app',
   data:{
     textvue:'vuetest'
   }
 })
 </script> -->
 