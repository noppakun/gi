<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Gilogs */

$this->title = 'Create Gilogs';
$this->params['breadcrumbs'][] = ['label' => 'Gilogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gilogs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
