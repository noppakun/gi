<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use app\widgets\se2Supplier;



$this->title = 'Quotation Update Item: ' . $item_no;
$this->params['breadcrumbs'][] = ['label' => 'Quotation Price', 'url' => ['price']];
$this->params['breadcrumbs'][] = 'Update : '.$model->item_no;

?>

<?= GridView::widget([
    'dataProvider' => $quotationPrice,

    'columns' => [
        [                
            'header'=>'DOC. Date',
            'attribute'=>'doc_date',                    
            'format' => ['date'],                                  
            'hAlign'=>'center',
        ],
      
                
        [                
            'header'=>'Supplier',
            'attribute'=>'supp_name',                    
        ],
        
        [                
            'header'=>'จำนวน',
            'attribute'=>'qty',     
            'format' => ['decimal',2],                                  
            'hAlign'=>'right',
        ],        
        [                
            'header'=>'ถึง',
            'attribute'=>'qty2',     
            //'format' => ['decimal',2],                                  
            'hAlign'=>'right',
            'value'=>function ($model, $key, $index, $column) {
                return $model['qty2'] == 0 ? '':number_format($model['qty2'],2);
            },            
        ],        
        [                
            'header'=>'หน่วย',
            'attribute'=>'unit',                    
        ],
        
        [                
            'header'=>'ราคา',
            'attribute'=>'price',     
            'format' => ['decimal',2],                                  
            'hAlign'=>'right',
            
        ], 
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}',
            
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'update') {                    
                    return \yii\helpers\Url::toRoute(['priceupdate', 'id' => $model['id'],'upid'=>$model['item_no']]);                        
                }else if ($action === 'delete') {                    
                    return \yii\helpers\Url::toRoute(['pricedelete', 'id' => $model['id']]);                        
                }
            }                
        ],                   
        

    ]

    
]); ?>  
<hr>
    <div class="xquotationprice-form">

        <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_INLINE,
        ]); ?>

        <?= $form->field($model, 'item_no')->hiddenInput() ?>
        <!-- <?= $form->field($model, 'note')->textInput(['style'=>'width:100px']) ?> -->    

        
        
        <?=
            $form->field($model, 'doc_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'วันที่','style'=>'width:150px'],
                'pluginOptions' => [
                    'autoclose'=>true,                
                    'format' => 'dd/mm/yyyy' ,                
                ],
                
            ]);;
        ?>


        <?= se2Supplier::widget(['form' => $form, 'model' => $model,
            'field' => 'supp_no',
            'width'=>'300px',
            'allowClear'=>true
        ])?>
        <!-- 'style'=>'width:500px' -->


       

        <?= $form->field($model, 'supp_name')->textInput(['style'=>'width:300px']) ?>


                <br>
        <?= $form->field($model, 'qty')->textInput(['style'=>'width:100px']) ?>
        <?= $form->field($model, 'qty2')->textInput(['style'=>'width:100px']) ?>
        <?= $form->field($model, 'unit')->textInput(['style'=>'width:100px']) ?>        
        
        <?= $form->field($model, 'price')->textInput(['style'=>'width:100px']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>