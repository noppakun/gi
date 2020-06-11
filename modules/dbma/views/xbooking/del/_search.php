<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\XBookingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="xbooking-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'doc_no') ?>

    <?= $form->field($model, 'doc_date') ?>

    <?= $form->field($model, 'obj_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'dt_start') ?>

    <?php // echo $form->field($model, 'dt_end') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
