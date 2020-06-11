<?php
use yii\widgets\ActiveForm;
// use yii\helpers\Url;
use yii\helpers\Html;


$this->title = 'Time attendance convert';

$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'uploadFile')->fileInput() ?>

    <button>Convert</button>

<?php ActiveForm::end() ?>
<BR>
<?php
	if ($download){

		// echo Html::a("Download", ["uploads/newtime.txt"]);
		echo Html::a('Download', ['/dbma/alarm/timedownload'], ['class'=>'btn btn-primary']) ;
	}

?>