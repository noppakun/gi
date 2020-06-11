<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\xTr */

$this->title = 'Create X Tr';
$this->params['breadcrumbs'][] = ['label' => 'X Trs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="x-tr-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modeldjson' => $modeldjson,
    ]) ?>

</div>
