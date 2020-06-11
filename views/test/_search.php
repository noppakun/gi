<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\XTrSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="x-tr-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'doc_no') ?>

    <?= $form->field($model, 'cust_no') ?>

    <?= $form->field($model, 'cust_name') ?>

    <?= $form->field($model, 'product_name') ?>

    <?php // echo $form->field($model, 'product_cat') ?>

    <?php // echo $form->field($model, 'product_cat_other') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
