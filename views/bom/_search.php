<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BomSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bom-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Assembly') ?>

    <?= $form->field($model, 'Formula_No') ?>

    <?= $form->field($model, 'SpecNo') ?>

    <?= $form->field($model, 'ProcessRemark') ?>

    <?= $form->field($model, 'TransferRecord1') ?>

    <?php // echo $form->field($model, 'TransferRecord2') ?>

    <?php // echo $form->field($model, 'TransferRecord3') ?>

    <?php // echo $form->field($model, 'StandardBatchSize') ?>

    <?php // echo $form->field($model, 'CompoundCode') ?>

    <?php // echo $form->field($model, 'Density') ?>

    <?php // echo $form->field($model, 'EffectiveDate') ?>

    <?php // echo $form->field($model, 'StandardYieldMin') ?>

    <?php // echo $form->field($model, 'StandardYieldMax') ?>

    <?php // echo $form->field($model, 'RegNo') ?>

    <?php // echo $form->field($model, 'ProductType') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
