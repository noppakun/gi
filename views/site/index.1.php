<?php
/* @var $this yii\web\View */

$this->title = '[ '.\Yii::$app->params['comp_code'].' Informaton ]';

?>
<div class="site-index">

    <div class="jumbotron">
        <img   src="images/logo.png">    
        <h1></h1>
	
        <p class="lead"><?=\Yii::$app->params['comp_name'] ?></p>

        <p><a class="btn btn-lg btn-success" href="<?=\Yii::$app->params['website'] ?>"><?=\Yii::$app->params['comp_code'] ?></a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>History</h2>

                <p>From a modest grocery started in 1932, today Greater Ouiheng Group is one of the successful 
                privately owned manufacturers and distributors of pharmaceutical products, consumer 
                healthcare as well as developes and distributes own branded products.</p>

                <p><a class="btn btn-default" href="http://greaterman.com/home/en/history-en.html">History &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Services</h2>

                <p>Provide product research and development to meet customers' requirements.<br>
                    Product registration service.<br>
                    Perform laboratory and stability tests.<br>
                    Provide sourcing of raw materials and packing materials.</p>

                <p><a class="btn btn-default" href="http://greaterman.com/home/en/aboutus-en.html">Services &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Quality comes first</h2>

                <p>In addition to process validation, the plant is subject to periodic Quality Assurance auditted. 
                    Stability studies have been carried out with a view to further strengthening the product shelflife.</p>

                <p><a class="btn btn-default" href="http://greaterman.com/home/en/history-en.html">Quality comes first &raquo;</a></p>
            </div>
          
        </div>

    </div>
</div>
<?php
echo __DIR__;
echo '<br>';
echo dirname('images');
echo '<br>';


    echo 'action : ';
    if (\Yii::$app->user->can('/@ITEM/ONHAND-ACCOUNT')){
        echo 'YES';
    }else{
        echo 'NO';

    }
 
?>