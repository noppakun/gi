<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\xTr */

$this->title = 'Update X Tr: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'X Trs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="x-tr-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
