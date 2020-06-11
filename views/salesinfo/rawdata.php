<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Appvar;
use yii\bootstrap\ActiveForm;


$this->title = 'Salesinfo RAWDATA';
$this->params['breadcrumbs'][] = $this->title;
//$hidden_detail = true;
$hidden_detail = ($SelectForm->var1==0);

$appvar = Appvar::find()
    ->where(['app_key' => 'salesinfo',
            'app_value' => 'run'])->one();

?>
    <p>
        
        <div class="row">

            <div class="col-md-6 text-left">
                <?php
                    $form = ActiveForm::begin([
                        'method' => 'get',                        
                        // 'options' => [
                        //     'class' => 'well',
                        // ],                                    
                    ]);        
                    echo $form->field($SelectForm, 'var1')->checkbox(['onchange'=>'this.form.submit()']   )->label('Show detail'); // checked ckeckbox 
                    ActiveForm::end();
                ?>
            </div>        
            <div class="col-md-6 text-right">
                <?= Html::a('<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export ( XLS )', 
                [
                    'tospreadsheet',                     
                    'searchModel'=>$searchModel->toArray(),                    
                ], 
                ['class' => 'btn btn-success']) ?>
            </div>             
         
        </div>

 

    </p>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,        
        'filterModel' => $searchModel,        
        'responsiveWrap' => false,
            // 'panel'=>[
            //     'type'=>GridView::TYPE_DEFAULT ,
            //     'heading'=>'Salesinfo',

            // ],

            // 'export'=>[
            //     'target'=>GridView::TARGET_BLANK
            // ],
            // 'exportConfig' => [
            //     // GridView::EXCEL => ['filename' => 'salesinfo_raw'],  ข้อมูลไม่ครบ
            //     GridView::CSV => ['filename' => 'salesinfo_raw'],

            // ],
        //'showPageSummary' => true,
        'columns' => [

            
            [
                'attribute'=>'tryear',
                'label'=>'Year',               
                'hAlign' => 'center',                 
                'contentOptions' => ['style' => 'min-width:85px;  '],                
                
            ],
            [
                'attribute'=>'trquarter',
                'label'=>'Quarter',
                'hAlign' => 'center',                 
                'hidden'=>$hidden_detail,
            ],
            [
                'attribute'=>'trmonth',
                'label'=>'Month',
                'hAlign' => 'center',                 
            ],
            // [
            //     'attribute'=>'cust_no',
            //     'label'=>'Cust.No.'                ,
            //     // 'value' => function ($data) {
            //     //     return "'".$data['cust_no'];
            //     // },
                
            // ],            
            [
                'attribute'=>'cust_name',
                'label'=>'Cust.Name',                
                'contentOptions' => ['style' => '<width:22></width:22>0px;  min-width:220px;  '],
            ],
            
            [
                'attribute'=>'customertypedesc',
                'hidden'=>$hidden_detail,
            ],
            
            [
                'attribute'=>'item_name',
                'label'=>'Item Name',                
                'contentOptions' => ['style' => 'width:300px;  min-width:300px;  '],                     
                
            ],
            [
                'attribute'=>'group_product_desc',
                'hidden'=>$hidden_detail,
            ],
            [
                'attribute'=>'product_desc',
                'hidden'=>$hidden_detail,
            ],
            
            [
                'attribute'=>'branddesc',
                'hidden'=>$hidden_detail,
            ],
            
                           
 
            
            [
                'attribute'=>'qty',
                'format' => ['decimal',2],
                'hAlign' => 'right', 
            ],
            [
                'attribute'=>'amt',
                'format' => ['decimal',2],
                'hAlign' => 'right', 
                //'pageSummary' => true,
            ],
            [
                'attribute'=>'markup',
                'label'=>'Markup',
                'format' => ['decimal',2],
                'hAlign' => 'right', 
            ],

            [
                'attribute'=>'unit_markup',                
                'format' => ['decimal',2],
                'hAlign' => 'right', 
            ],
            [
                'attribute'=>'percent_markup',
                'label'=>'% Markup',
                'format' => ['decimal',2],
                'hAlign' => 'right', 
            ],           

            [
                'attribute'=>'std_price',
                'label'=>'Std. Price',
                'format' => ['decimal',2],
                'hAlign' => 'right', 
            ],
            [
                'attribute'=>'actual_cost',
                'label'=>'Act.Cost',
                'format' => ['decimal',2],
                'hAlign' => 'right', 
            ],
            [
                'attribute'=>'variable_cost',
                'label'=>'Var.Cost',
                'format' => ['decimal',2],
                'hAlign' => 'right', 
            ],
            
                       
            [
                'attribute'=>'sku',
                'hidden'=>$hidden_detail,
            ],
            
            [
                'attribute'=>'item_number',
                'hidden'=>$hidden_detail,
            ],
            
            [
                'attribute'=>'ana_no',
                'hidden'=>$hidden_detail,
            ],
            [
                'attribute'=>'salesman',
                'hidden'=>$hidden_detail,
            ],            

        ],

    ]); ?>
<div class="col-md-6">    
 <br>
<?php
    $notes = [
        'Markup : มูลค่าขาย - variable amount',
        'Unit Markup : Markup / ( มูลค่าขาย/จำนวนขาย )',
        '% Markup : Markup / variable amount * 100',
        'Std. Price : Table Items ( Price_A )',
        'Act. Cost : ItemLoc ( การปิด Job ของ Acc )',
        'Var. Cost : Job การผลิต',
    ];
    echo Html::ul($notes, ['item' => function($item, $index) {
        return Html::tag(
            'li',$item        
        );}]);
?>
</div>
<div class="col-md-6">
                <?= Html::a('Update Data', ['update'], ['class' => 'btn btn-success']) ?>
                <span class="label label-primary">last update :  <?=date("d-m-Y  /  H:i:s",strtotime($appvar->lastupdate)); ?>
                </span>
</div>