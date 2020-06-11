<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

//use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Araptran */

foreach ($model->tableSchema->primaryKey as $col) {
    $pkey = isset($pkey) ? $pkey . ' / ' . $model[$col] : $model[$col];
}


//\app\components\XLib::xprint_r($model->getScenario());
//echo $MODEL_SCENARIO ;
//$scenarios = isset($scenarios['xqedit'])?$scenarios['xqedit']:$scenarios['default'];
// $scenarios=$model->scenarios();
// $scenarios = $scenarios[$model->getScenario()];

$scenarios = ($model->scenarios())[$model->getScenario()];

$qedit_update_attributes  = update_attributes($XQEDIT['update_columns'], $scenarios);

$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord) ? '' : ' : ' . $pkey);
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View' : 'Update'));

$staticOnly = true;
$staticOnly = $viewmode;
// --------------------------------------------------------------------------
?>
<div class="etable-update">
    <div class="etable-form">
        <div class="panel  panel-primary">
            <div class="panel-heading"><?= $this->title ?>
                <div class="pull-right">
                    <?php
                    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);

                    if (!$viewmode) {
                        echo Form::widget([
                            'model' => $model,
                            'form' => $form,
                            'columns' => 2,
                            'staticOnly' => $staticOnly,
                            'attributes' => [
                                'actions' => ['type' => Form::INPUT_RAW, 'value' => Html::submitButton('Save', ['class' => 'btn btn-success btn-xs'])],

                            ],
                        ]);
                    }
                    ?>
                </div>
            </div>
            <div class="panel-body">
                <?php
                // ***AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA


                foreach ($qedit_update_attributes as $key => $fm) {
                    echo Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => isset($fm['columns']) ? $fm['columns'] : 3,
                        'staticOnly' => $staticOnly,
                        'attributes' => $fm['attributes'],
                    ]);
                }
                // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php



// -------------------------------------------------------------------------------------------------------------------
function update_attributes($columns, $scenarios)
{
    // ------------------------------------------------------------------------------------------------------------------- 
    $form = [];
    $at = [];
    foreach ($columns as $key =>  $column) {

        if (is_array($column)) {
            if (isset($column['attributes'])) {
                if (sizeof($at) > 0) {
                    $form[]['attributes'] = $at;
                    $at = [];
                }
                $form[] = $column;
            } else {
                $at[$key] = $column;
            }
        } else {
            $at[$column] = (array_search($column, $scenarios) === false)
                ? ['type' => Form::INPUT_STATIC]
                : ['type' => Form::INPUT_TEXT];
        }
    }

    if (sizeof($at) > 0) {
        $form[]['attributes'] = $at;
    }




    //or (array_search($key , $scenarios)==false),

    return $form;
}
?>