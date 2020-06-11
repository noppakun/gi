<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\XBooking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="xbooking-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'doc_no')->textInput() ?>

    <?= $form->field($model, 'doc_date')->textInput() ?>

    <?= $form->field($model, 'obj_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'dt_start')->textInput() ?>

    <?= $form->field($model, 'dt_end')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput() ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
