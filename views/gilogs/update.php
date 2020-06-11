<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Gilogs */

$this->title = 'Update Gilogs: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gilogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gilogs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
