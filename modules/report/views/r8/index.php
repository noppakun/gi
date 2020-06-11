<?php
 
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use app\widgets\ddlMonth;
use app\widgets\ddlYear;
use yii\helpers\Html;

$this->title = 'ข้อมูลการผลิต ร.ง. 8';

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => [$this->context->action->id]];

$appvar = app\models\Appvar::find()
    ->where(['app_key' => 'salesinfo',
            'app_value' => 'run'])->one();

$form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'type'=>'horizontal',
 

    'options' => [
        'class' => 'well',
    ],
]);
?>

<div class="row">
    <div class="col-md-6">
        <?= ddlYear::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'year']);   ?>
    </div>
    <div class="col-md-6">
        <?= ddlMonth::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'month' ]);    ?>
    </div>
    <div class="col-md-12">
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
        'columns' => [

            [
                'attribute' => 'rname',
            ],
            [
                'attribute' => 'onhand_est_kg',
                'format' => ['decimal', 2], 'hAlign' => 'right',
            ],
            [                
                'attribute' => 'onhand_amt',
                'hAlign' => 'right',
                'content'=>function($model){
                    return substr($model['rname'],0,7) =='ETHANOL' ? number_format($model['onhand_amt'],2) :'-';
                }
            ],
            [
                'attribute' => 'prod_est_kg',
                'format' => ['decimal', 2], 'hAlign' => 'right',
            ],
            [
                'attribute' => 'prod_repack_est_kg',
                'format' => ['decimal', 2], 'hAlign' => 'right',
            ],
            [                
                'attribute' => 'sales_est_kg',
                'format' => ['decimal', 2], 'hAlign' => 'right',
            ],
            [
                'attribute' => 'sales_amt',
                'format' => ['decimal', 2], 'hAlign' => 'right',
            ]
        ]

    ]);
    ?>

</div>
<div class="col-md-6">    
* ข้อมูล ณ. ต้นเดือน
</div>
<div class="col-md-6">
                <?= Html::a('Update Data', ['update'], ['class' => 'btn btn-success']) ?>
                <span class="label label-primary">last update :  <?=date("d-m-Y  /  H:i:s",strtotime($appvar->lastupdate)); ?>
                </span>
</div>