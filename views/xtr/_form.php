<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\xTr */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="x-tr-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'doc_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cust_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cust_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_cat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_cat_other')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
