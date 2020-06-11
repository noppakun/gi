<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\detail\DetailView;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
//use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Araptran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-form">

<?=

    DetailView::widget([
        'model'=>$model,
        'condensed'=>true,
        'hover'=>true,           
        'mode'=>'edit',                        
        'buttons2'=>' {save}',
        'panel'=>[
            'heading'=>$title,
            'type'=>DetailView::TYPE_INFO,
        ],
        
        'attributes'=>[
            

            [
                'group'=>true,
                'label'=>'SECTION 1: Identification Information',
                'rowOptions'=>['class'=>'info']
            ],            
            'CompanyCode',
            [
                'columns' => [           
                    'Order_Number',
                    'Order_date',
                    'Pr_Number',                    
                ],

            ],            

            [
                'group'=>true,
                'label'=>'SECTION 1: Identification Information',
                'rowOptions'=>['class'=>'info']
            ],            
            [
                'columns' => [           
                    'DivisionCode',
                    'DeptCode',
                    'Supp_Number',
                ],
            ],            
            
            [
                'columns' => [           
                    'Terms' ,
                    'Currency_Type',
                    'Buyers',
                ],
            ],            
            [
                'group'=>true,
                'label'=>'SECTION 1: Identification Information',
                'rowOptions'=>['class'=>'info']
            ],                      


            'Shipto_Addr1',
            'Shipto_Addr2',
            'ShipMent',
            [
                'group'=>true,
                'label'=>'SECTION 1: Identification Information',
                'rowOptions'=>['class'=>'info']
            ],                      

            
            'ForWork',
            'Remark1',
            'Remark2',
            'Remark3', 
            [
                'group'=>true,
                'label'=>'pending',
                'rowOptions'=>['class'=>'info']
            ],               

            'Po_Issue', 'Open_Close', 'Vat_Type',
        ],
 
    ]); 
    

/**
 * This is the model class for table "PO".
 *
 * @property string $CompanyCode
 * @property string $Order_Number
 
 * @property string $Pr_Number
 * 
* 

 * @property string $Remarks
 
 
 * @property integer $Po_Issue
 * @property integer $Open_Close
 * @property string $Close_Date
 * @property string $Service
 * @property string $Insurance
 * @property string $Carriage
 * @property string $Vat_Percent
 * @property string $Vat_Amt
 * @property string $Disc_Percent
 * @property string $Disc_Cash
 * @property integer $Revision_No
 * @property string $Revision_Date
 * @property string $Vat_Type
    
* @property string $Supp_Number    
 * @property string $LimitOverOrderRate
 * @property string $currency_Rate
 * 
 * @property string $Amount
 * @property string $TotalAmount
 * @property string $UserName
 * @property string $LastUpdateuse app\models\
 * @property integer $PO_Approve
 * @property string $UserName_Approve
 * @property string $DateTime_Approve
 */    
?>

  <div style = "<?= ($model->isNewRecord)? 'display: none;':''?>" >
    <?=  GridView::widget([
        'dataProvider' => $modeld,  
        'responsiveWrap' => false,     
        'columns'=>[
            'Seq_Number',
            'PR_Number',
            'Item_Number',
            //pdname
            'Uom',
            'Order_Qty',
            'Price',
            'Disc_Percent',
            'Disc_Cash',
            // sumprice
            'Due_Date:date',
            'Delivery_Date:date',
            'Type_Desc',
            'SpecNo',
            'EffectiveDate:date',
            


           

            [                
                'class' => 'kartik\grid\ActionColumn',
                'template' =>'{update}{delete}',
                'urlCreator' => function ($action, $model, $key, $index)  {

                    $url = Yii::$app->urlManager->createUrl(                                            
                        [Yii::$app->controller->id.'/'.$action, //$action = 'update' or 'delete'
                        'CompanyCode'=>$model->CompanyCode,
                        'id' => $model->Order_Number,
                        'id2' => $model->Seq_Number,

                        ]
                    );
                    return $url;                
                },       
               
            ],  
        ]
    ]); ?>






    <?php $form = ActiveForm::begin([        
        'action' => Url::to([Yii::$app->controller->id.'/update2','id'=>$modeld1->Order_Number]),
        'type' => ActiveForm::TYPE_INLINE,
 //       'layout' => 'horizontal',
        


    ]); ?>
    <?= $form->field($modeld1, 'Order_Number')->hiddenInput(['value' => $modeld1->Order_Number])->label(false);?>

    <?= $form->field($modeld1, 'Item_Number')->textInput(['style'=>'width:250px']) ?>
    <?= $form->field($modeld1, 'Order_Qty')->textInput(['style'=>'width:100px']) ?>
    <?= $form->field($modeld1, 'Price')->textInput(['style'=>'width:100px']) ?>
    

    <div class="form-group">
        <?= Html::submitButton($modeld1->isNewRecord ? 'Create' : 'Update', ['class' => $modeld1->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

 





  </div>
</div>
