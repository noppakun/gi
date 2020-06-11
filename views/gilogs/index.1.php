<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use kartik\nav\NavX;
use yii\bootstrap\NavBar;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GilogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\web\View;
$this->title = 'Gilogs';
$this->params['breadcrumbs'][] = $this->title;

?>
<pre id="gilogs"></pre>
<?php $this->registerJsFile('https://www.gstatic.com/firebasejs/4.6.0/firebase.js')?> 

<?php $this->registerJs('
(function(){
	// Initialize Firebase
  const config = {
    apiKey:  "AIzaSyAucvbEsZ61a0c79Q5ePfXQtPKdHB76gHI",
    authDomain: "greaterman-2017.firebaseapp.com",
    databaseURL: "https://greaterman-2017.firebaseio.com",
    storageBucket: "greaterman-2017.appspot.com",

    projectId: "greaterman-2017",
    messagingSenderId: "490361386617"
  };
  firebase.initializeApp(config);

	const preObject = document.getElementById("gilogs");
		
    const dbRefObject = firebase.database().ref().child("gilogs");
    
	dbRefObject.on("value", snap => {
		preObject.innerText = JSON.stringify(snap.val(), null, 3);
	});		

}());', View::POS_END)?>



















<div class="gilogs-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!-- <?= Html::a('Create Gilogs', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            'ipaddress',
            'logtime',
            'controller',
            'action',
            'details:ntext',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
