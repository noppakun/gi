<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="jumbotron alert alert-info">
    <h1><span class="glyphicon glyphicon-alert  alert alert-danger" aria-hidden="true"></span> </h1>
    <h2><?= Html::encode($this->title) ?></h2>
    <p><?= nl2br(Html::encode($message)) ?></p>
    <p><a class="btn btn-default btn-lg" href="http://gi.greaterman.com" role="button">Home</a></p>
</div>
