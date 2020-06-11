<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sparepart */

$this->title = 'Update Sparepart: ' . ' ' . $model->Item_Number;
$this->params['breadcrumbs'][] = ['label' => 'Spareparts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Item_Number, 'url' => ['view', 'id' => $model->Item_Number]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sparepart-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
