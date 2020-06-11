<style>
    .container  {color: black; background-color:#DEFFED}        
</style>
 <div id="app">
  <input type="hidden" id="order_no" value=<?=$order_no?>>  
  <input type="hidden" id="item_number" value=<?=$item_number?>>  

<?php



// $time = microtime();
// $time = explode(' ', $time);
// $time = $time[1] + $time[0];
// $finish = $time;
// $total_time = round(($finish - $start), 4);
// echo 'Page generated in '.$total_time.' seconds.';

use app\models\WPlanDet;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;

use kartik\form\ActiveForm;
use kartik\builder\Form;
 
 
$uom = '???';
$TABLECAPTION = 'WASTE RECORD : '.$model->component;
$this->title = $TABLECAPTION ;
$this->params['breadcrumbs'][] = ['label'=>'BATCH PACKING RECORD', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $order_no.' - '.$item_number, 'url' => ['view','order_no' => $order_no,'item_number' => $item_number,  ]];
$this->params['breadcrumbs'][] = $this->title;

?>
<table class="table table-bordered table-striped detail-view">  
<tbody>
  <tr>
    <th>
      PRODUCT CODE
    </th>
    <td>
    {{item_number}}
    </td>
    <th>
      PRODUCT
    </th>
    <td>
    {{item_name}}
    </td>
  </tr>
  </tbody>
</table>
 


<!-- HEAD -->

<input type="text" v-model="netfill">
<button @click="postdata">Save</button>



<div class="panel  panel-primary" >  
<?php
  $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
  ?>
 
  <div class="panel-body">        
    <?php  
    echo Form::widget([
      'model'=>$modelExt,
      'form'=>$form,
      'columns'=>3,
 
      'attributes'=>[            
          'netfill'=>['type'=>Form::INPUT_TEXT,  ],
              
          'uom'=>[
            'type'=>Form::INPUT_DROPDOWN_LIST,
            'items'=>(new app\widgets\se2Uom)->itemsQueryArrayMap(),                                          
            // 'options'=>[
            //     'id'=>'wh-id'
            // ],                                         
          ],          
          'actions'=>[
            'type'=>Form::INPUT_RAW,             
            'value'=>'<div class="text-right" >'
              .Html::submitButton('Save', ['class'=>'btn btn-success ' ])
              .'</div>',
                             
          ],  
          // 'a'=>[
          //   'value'=>'<br>'.Html::submitButton('Save', ['class'=>'btn btn-success ','id'=>'xwplandetext-submit']),
          //            'columnOptions'=>['colspan'=>2,'style'=>'text-right'],            

          // ],
 
                   
          
          'order_no'=>['type'=>Form::INPUT_HIDDEN,  ],
          'item_number'=>['type'=>Form::INPUT_HIDDEN,  ],            
      ]
    ]);    

    //echo Html::submitButton('Save', ['class'=>'btn btn-success ','id'=>'xwplandetext-submit']);
                             
    ActiveForm::end();       
    ?>
  </div>
</div>  
 

<table class="table table-bordered table-striped detail-view">  
<thead>
  <tr>
    <th>MAT.CODE</th>
    <th>PACKAGING MATERIALS</th>
    <th>UNIT</th>
    <th>WASTE</th>    
  </tr>
</thead>
  <tbody>
    <tr v-for="item in datad">
      <td>
        {{item.Component}}
      </td>
      <td>
        {{item.Item_Name}}
      </td>
      <td>
        {{item.Uom}}
      </td>
      <td>
        {{item.waste}}
      </td>

    </tr>
  </tbody>
</table>


<div>
 
 
   
  <div class="panel  panel-primary">
  <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);?>
  <!-- {{textvue}} -->
    
    <div class="panel-body">        
      <?php  
      echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>6,

        'attributes'=>[            
            'component'=>['type'=>Form::INPUT_HIDDEN_STATIC],
            'reason'=>[
              'type'=>Form::INPUT_TEXT,  
              'columnOptions'=>['colspan'=>3],
            ],
            'qty'=>[
              'type'=>Form::INPUT_TEXT,  
              'label'=>'จำนวน ( '.$uom.' )',              
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


</div>  
<!--   vue app  -->
<?php $this->registerJsFile("https://cdn.jsdelivr.net/npm/vue/dist/vue.js", ['position' => \yii\web\View::POS_HEAD]);?>
<?php $this->registerJsFile("//unpkg.com/axios/dist/axios.min.js", ['position' => \yii\web\View::POS_HEAD])?>

<script>  

var app = new Vue({
  el: '#app',
  data: {
    order_no:'',
    item_number:'',
    component:'',    
    item_name:'',
    netfill:0,
    datad:[],
   
  },
  methods: {
    postdata:function(event){
      var vm = this;        
      axios.post("http://gi.greaterman.com/gi/web/index.php?r=batch-packing-record/postdata",{
        data:{
          order_no:this.order_no,
          item_number:this.item_number,
          netfill:this.netfill

        }
        
      })
      .then(function(res){          
        console.log('post ok ');
      })
      .catch(function (error) {        
        console.log('post error xx:',error);
        console.log(error);
      })

    },
    getdata:function(event){
      var vm = this;        
      axios.get("http://gi.greaterman.com/gi/web/index.php?r=batch-packing-record/getdata",{
        params: {
          order_no:this.order_no,
          item_number:this.item_number,                         
        }                
      })
      .then(function(res){          
        vm.item_name = res.data.item_name                     
        vm.netfill = res.data.netfill
        vm.datad = res.data.detail        
          
         
      })
      .catch(function (error) {        
        console.log(error);
      })
    }
  },      
  created() {
    this.order_no=document.getElementById("order_no").value;
    this.item_number=document.getElementById("item_number").value; 
    this.getdata();
    console.log('CREATE'); 
  },
})
</script>
 
 
 