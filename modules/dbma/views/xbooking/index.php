<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\widgets\ddlMonth;
use app\widgets\ddlYear;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

$this->title = 'X Bookings';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$form = ActiveForm::begin([
    'method' => 'get',
    'layout' => 'horizontal',

    'options' => [
        'class' => 'well',
    ],
]);
?>
<div class="row">
    <div class="col-md-5">
        <?= $form->field($SelectForm, 'var1')->dropDownList(
            ArrayHelper::map(\app\models\XBooking::$track_LIST, 'id', 'track_name'),
            ['onchange' => 'this.form.submit()']
        )->label('Track'); ?>
    </div>
    <div class="col-md-3">
        <?= ddlYear::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'year', 'options' => ['onchange' => 'this.form.submit()']]);
        ?>
    </div>
    <div class="col-md-3">
        <?= ddlMonth::widget(['form' => $form, 'model' => $SelectForm, 'field' => 'month', 'options' => ['onchange' => 'this.form.submit()']]);    ?>
    </div>
    <!-- <div class="col-md-2">
        <?= Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>
    </div> -->
</div>
<?php
$form::end();
?>

<div class="row">
    <div class="col-md-6">
 
        <?php
        
        echo \yii2fullcalendar\yii2fullcalendar::widget([
            'clientOptions' => [
                //'selectable'  => true,
                //'defaultView' => 'agendaWeek',

                'defaultDate'=>$SelectForm->year.substr('0'.$SelectForm->month,-2).'01',
                'weekNumbers'=>false,                
                'displayEventEnd'=>true,
                'timeFormat'=>'H(:mm)',
                'eventClick' => new JsExpression("
                    function(event, delta, revertFunc, jsEvent, ui, view) {
                        console.log(event);
                        console.log('CCCC');
                    }
                "),
            ],            
            'header' => [
                'left' => null,
                'right' => null,

            ],
            'events' => $events,            
        ]);
        ?>
    </div>
    <div class="col-md-6">
        <p>
            <?= Html::a('จอง', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'dt_end',
                    'label' => 'Date/Time',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $dt_end_format = (date("d/m/Y", strtotime($model->dt_start)) == date("d/m/Y", strtotime($model->dt_end)))
                            ? "H:i" : "d/m/Y H:i";


                        $str =  date("d/m/Y H:i", strtotime($model->dt_start)) . ' - ' .
                            date($dt_end_format, strtotime($model->dt_end));
                        return ($model->username == Yii::$app->user->identity->username)
                            ? Html::a($str, ['update', 'id' => $model->doc_no])
                            : $str;
                    }
                ],
                [

                    'attribute' => 'title',
                    'label' => 'การใช้งาน / ผู้จอง',
                    'value' => function ($model) {
                        return  $model->title . ' / ' . $model->username;
                    }
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{delete}',
                    'visibleButtons' =>  [
                        'delete' => function ($model) {
                            return ($model->username == Yii::$app->user->identity->username);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div> 