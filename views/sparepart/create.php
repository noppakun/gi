<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sparepart */

$this->title = 'Create Sparepart';
$this->params['breadcrumbs'][] = ['label' => 'Spareparts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sparepart-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
