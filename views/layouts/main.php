<?php

// use in gi/modules/dbma/views/xbooking/index.php
//$this->registerJsFile("//cdn.jsdelivr.net/npm/vue/dist/vue.js", ['position' => \yii\web\View::POS_HEAD]);

//src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"
// $this->registerJsFile("//unpkg.com/axios/dist/axios.min.js", ['position' => \yii\web\View::POS_HEAD]);



use yii\helpers\Html;
use yii\bootstrap\NavBar;

use kartik\nav\NavX;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
//-----------------------------------
// mi menuitem
$mi = new app\models\XMenuItem;
//-----------------------------------
/*----------------------------------------------------------*/
?>
<?php
    //$url = 'http://api.fixer.io/latest?base=THB'; // path to your JSON file
    //$url = 'http://data.fixer.io/api/latest?access_key=c89882ba5b9be4a5c4cb6d582ca3e6b3';
    //$data = file_get_contents($url); // put the contents of the file into a variable
    //$exchange = json_decode($data);
    //print_r($base->rates->USD);
;

//echo '<br><br>';
//echo $data;
//echo '<br><br>';
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
        <?php

        NavBar::begin([
            //'brandLabel' => 'GPM',
            'brandLabel' => '<img src="images/logo.png" height="27" width="38">', // 69x96
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
                'class' => 'navbar-fixed-top',
                'class' => 'navbar navbar-fixed-top',
                'class' => 'navbar-inverse navbar-fixed-top',
                //'style' => Yii::$app->params['navbar-style'],                    
            ],
        ]);

        echo NavX::widget([
            'options' => [

                'class' => 'navbar-nav',
                // 'class' => 'navbar-nav navbar-right'

                //'class' =>'nav nav-pills',
            ],
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => 'BD',
                    'items' => [
                        $mi->getitem('/salesinfo/index'),
                        $mi->getitem('/salesinfo/rawdata'),
                        $mi->getitem('/salesinfo/bycustomertype'),
                        $mi->getitem('/salesinfo/byproduct'),
                        '<li class="divider"></li>',
                        $mi->getitem('/receiveinfo/index'),
                        // $mi->getitem('/receiveinfo/estimatereceipt'),   
                        // move to account

                    ],
                ],
                
                [
                    'label' => 'Manufacturing', // Manufacturing
                    'items' => [
                        // ['label' => 'Planning',
                        //     'items' => [                                                      
                        //         $mi->getitem('/report/salesinfo/salesorderqty'),        
                        //         $mi->getitem('/report/salesinfo/qty'),        
                        //         $mi->getitem('/machine-capacity'),        
                        //         $mi->getitem('/packaging-waste'),     
                        //         $mi->getitem('/rawmaterial-waste'),                                           
                        //     ],
                        // ],
                        // ---------- Inventory  ---------- 
                        //'<li class="dropdown-header">Inventory</li>',

                        // ---------- Planning  Inventory ---------- 
                        '<li class="dropdown-header">Planning</li>',
                        $mi->getitem('/report/stock/minimum'),
                        $mi->getitem('/dbma/xquery/v_slow_moving_items'),

                        //'<li class="divider"></li>',

                        $mi->getitem('/dbma/xpkg-reserve/index'),
                        $mi->getitem('/report/salesinfo/salesorderqty'),
                        $mi->getitem('/report/salesinfo/qty'),
                        $mi->getitem('/machine-capacity'),
                        $mi->getitem('/packaging-waste'),
                        $mi->getitem('/rawmaterial-waste'),
                        $mi->getitem('/xapi/ui/matsalesorder'),
                        // ---------- Production  ---------- 
                        '<li class="divider"></li>',
                        '<li class="dropdown-header">Production</li>',

                        $mi->getitem('/dbma/xquery/v_waste_tube'),
                        $mi->getitem('/report/r8'),
                        $mi->getitem('/batch-packing-record'),
                        $mi->getitem('/xapi/ui/prodyieldmach'),

                        // ---------- Quality Control ---------- 
                        '<li class="divider"></li>',
                        '<li class="dropdown-header">Quality Control</li>',
                        $mi->getitem('/dbma/itemqc'),
                    ],
                ],
                [
                    'label' => 'R & D',
                    'items' => [

                        $mi->getitem('/xpdr'),
                        $mi->getitem('/xpkr'),
                        '<li class="divider"></li>',
                        $mi->getitem('/xfdaregister'),
                        $mi->getitem('/prod'),
                        '<li class="divider"></li>',
                        $mi->getitem('/bom-temp'),
                        $mi->getitem('/bom'),
                        '<li class="divider"></li>',
                        $mi->getitem('/xpif'),
                        $mi->getitem('/xpif/read'),
                        '<li class="divider"></li>',
                        $mi->getitem('/dbma/xquery/v_rm_use'),
                        $mi->getitem('/dbma/xquery/v_pm_use'),

                        $mi->getitem('/dbma/xquery/v_packaging_tube'),
                        $mi->getitem('/report/newitemreceive'),
                        $mi->getitem('/dbma/xquery/v_top50packaging_use'),
                        //$mi->getitem('/dbma/item-rd'),
                        $mi->getitem('/xapi/ui/itemrd'),

                        //$mi->getitem('/xapi/ui/rd-packaging'),
                        //$mi->getitem('/dbma/xquery/v_packaging'),                             
                    ],
                ],
                [
                    'label' => 'Purchasing',
                    'items' => [
                        $mi->getitem('/xpr'),
                        $mi->getitem('/dbma/xquery/v_prnotpo'),
                        $mi->getitem('/dbma/purchase-order/top'),

                        $mi->getitem('/dbma/purchase-order/shipdateitem'),
                        $mi->getitem('/po-history/index'),
                        $mi->getitem('/quotation/price'),
                        $mi->getitem('/quotation/price-by-supp'),
                        '<li class="divider"></li>',
                        $mi->getitem('/dbma/item/list'),
                        $mi->getitem('/dbma/supplier'),
                        $mi->getitem('/dbma/sparepart'),
                    ],
                ],
                [
                    'label' => 'Accounting',
                    'items' => [

                        // ยกเลิกการใช้งาน 3/9/2019
                        $mi->getitem('/cash-flow/index'),

                        $mi->getitem('/receiveinfo/estimatereceipt'),
                        '<li class="divider"></li>',
                        $mi->getitem('/jobproductcost'),
                        $mi->getitem('/jobproductcost/costchange'),
                        '<li class="divider"></li>',
                        $mi->getitem('/stock/movement'),
                        $mi->getitem('/dbma/item/onhand'),
                        '<li class="divider"></li>',
                        $mi->getitem('/invoice-acc'),
                        $mi->getitem('/dbma/asset'),
                        $mi->getitem('/dbma/company'),

                    ],
                ],
                [
                    'label' => 'HR',
                    'items' => [


                        $mi->getitem('/timeattendance'),
                        $mi->getitem('/dbma/xbooking'),
                        $mi->getitem('/dbma/xquery/v_parcel_list'),
                        //$mi->getitem('/dbma/hr/calendar'),    

                        '<li class="divider"></li>',
                        $mi->getitem('/dbma/alarm'),
                        $mi->getitem('/dbma/alarm/timeconvert'),
                        // '<li class="divider"></li>',      
                        // '<li class="dropdown-header">TEST</li>',


                    ],
                ],
                // [
                //     'label' => 'EA',
                //     'url' => (substr($_SERVER['REMOTE_ADDR'], 0, 9) == '192.168.0')
                //         ? 'http://192.168.0.5:3001'
                //         : 'http://ea.greaterman.com',
                // ],
                // [
                //     'label' => 'EPA',
                //     'items' => [
                //         $mi->getitem('/xapi/ui/kpi'),
                //         $mi->getitem('/xapi/ui/matsalesorder'),
                //         $mi->getitem('/xapi/ui/prodyieldmach'),
                //         '<li class="divider"></li>',
                //         '<li class="dropdown-header">BETA</li>',
                //     ],
                // ],


            ],

            //'options' => ['class' =>'nav-pills'], 
        ]);
        echo NavX::widget([
            'options' => [
                'class' => 'navbar-nav',
                'class' => 'navbar-nav navbar-right'
                //'class' =>'nav nav-pills',
            ],
            'encodeLabels' => false,
            'items' => [
                //--------------------------------------------------------------------------------------
                $mi->getitem('/xjobtracking'),
                Yii::$app->user->isGuest ?
                    $mi->getitem('/user/security/login')    :
                    [
                        'label' => '<span class="glyphicon glyphicon-cog"></span>', 'url' => ['#'],
                        'items' => [ // Setup                        
                            $mi->getitem('/user/admin'),
                            $mi->getitem('/admin'),
                            [
                                'label' => 'Sign out (' . (Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->username) . ')',
                                'url' => ['/user/security/logout'],
                                'linkOptions' => ['data-method' => 'post'],
                            ],
                            '<li class="divider"></li>',
                            $mi->getitem('/dbma'),

                        ],
                    ],
                //--------------------------------------------------------------------------------------          
            ],
        ]);

        NavBar::end();



        // Usage with bootstrap navbar

        //use yii\bootstrap\NavBar;
        /*
NavBar::begin();
echo NavX::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => $items,
    'activateParents' => true,
    'encodeLabels' => false
]);
NavBar::end();
*/


        ?>

        <!-- <div class="container-fluid"> -->
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?= \Yii::$app->params['comp_name'] ?> <?= date('Y') . " 19." . Yii::getVersion() ?>

            </p>
            <p class="pull-right">
                <?php
                $erpdb  = explode('=', Yii::$app->erpdb->dsn);
                $isodb  = explode('=', Yii::$app->isodb->dsn);
                echo (Yii::$app->user->isGuest ? 'Guest' : Yii::$app->user->identity->username) . ' [ ' . $erpdb[2] . ' / ' . $isodb[2] . ' ]';


                ?>
            </p>
            <!--
            <p class="pull-right"><?= Yii::powered() ?></p>
-->

        </div>
    </footer>
    <?php
    //  [ USD:<?=number_format(1/$exchange->rates->USD,2) ] 
    //echo Yii::$app->request->baseUrl ;
    //echo Yii::getAlias('@web');

    ?>
    <?php $this->endBody(); ?>
</body>

</html>
<?php $this->endPage() ?>
<style>
    .container {
        width: 100%;
        margin: 0 auto;
    }
</style>