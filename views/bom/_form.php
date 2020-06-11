<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bom-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Assembly')->textInput() ?>

    <?= $form->field($model, 'Formula_No')->textInput() ?>

    <?= $form->field($model, 'SpecNo')->textInput() ?>

    <?= $form->field($model, 'ProcessRemark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'TransferRecord1')->textInput() ?>

    <?= $form->field($model, 'TransferRecord2')->textInput() ?>

    <?= $form->field($model, 'TransferRecord3')->textInput() ?>

    <?= $form->field($model, 'StandardBatchSize')->textInput() ?>

    <?= $form->field($model, 'CompoundCode')->textInput() ?>

    <?= $form->field($model, 'Density')->textInput() ?>

    <?= $form->field($model, 'EffectiveDate')->textInput() ?>

    <?= $form->field($model, 'StandardYieldMin')->textInput() ?>

    <?= $form->field($model, 'StandardYieldMax')->textInput() ?>

    <?= $form->field($model, 'RegNo')->textInput() ?>

    <?= $form->field($model, 'ProductType')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
