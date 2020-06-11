<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */

$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord)?'': ' : '. $model->Order_Number); 
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? 'Create' : 'Update');
?>
<div class="po-update">


    <?= $this->render('_form', [
        'title'     =>$this->title,        
        'model'     => $model,
        'modeld'    => $modeld,
        'modeld1'   => $modeld1,
    ]) ?>

</div>
