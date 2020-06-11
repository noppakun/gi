<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\XBooking */

$this->title = 'Create X Booking';
$this->params['breadcrumbs'][] = ['label' => 'X Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xbooking-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
