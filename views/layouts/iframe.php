<?php 
/*
test @ 4/6/2019  ยังไม่ได้ใช้ อาจใช้กับ รายการพัสดุ ของ hr ที่ link มาจาก in.

*/ 
use yii\helpers\Html; 
use app\assets\AppAsset; 

AppAsset::register($this);
 
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body> 

<?php $this->beginBody() ?>
    <div class="wrap">    
        <div class="container">         
            <?= $content ?>
        </div>
    </div>
<?php 
    $this->endBody(); 
?>
</body>
</html> 
<?php $this->endPage() ?>
<style>
.wrap > .container {
    padding: 0px;
}
 </style>