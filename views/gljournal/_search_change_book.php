<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GLJournalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-warning">
    <div class="panel-heading">
        Change BookCode & Prefix   *** ONLY FOR ADMIN ***
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'action' => ['index'],
            'method' => 'get',
        
        ]); ?>
        <div class="row">
            <div class="col-md-6">

                <?= $form->field($model, 'tryear') ?>

                <?= $form->field($model, 'GLBookCode') ?>
                <?= $form->field($model, 'prefix') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, '_new_glbookcode') ?>
                <?= $form->field($model, '_new_prefix') ?>
                <?php
                    
                    $paratest = 'Change : '.$model['tryear'].' : '.$model['GLBookCode'].'-'.$model['prefix'].' => '.$model['_new_glbookcode'].'-'.$model['_new_prefix']; 
                    $allpara = (
                        ($model['tryear'] != null) 
                        && ($model['GLBookCode'] != null) 
                        && ($model['prefix'] != null)
                        && ($model['_new_glbookcode'] != null)
                        && ($model['_new_prefix']!= null)
                    );                    
                ?>            
                <?= Html::a($paratest, ['changebookcode', 
                    'tryear' => $model['tryear'],
                    'gb1' => $model['GLBookCode'],
                    'pf1' => $model['prefix'],
                    'gb2' => $model['_new_glbookcode'],
                    'pf2' => $model['_new_prefix'],
                    ], ['class' => 'btn btn-warning',
                        'style'=>(!$allpara?'visibility:hidden':'')]) ?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="for1m-group">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>     
                </div>
            </div>
        </div>
        
        

        <?php ActiveForm::end(); ?>
    </div>

</div>    

 
