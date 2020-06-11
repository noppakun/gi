<?php
//-----------------------------------
// mi menuitem
$mi = new app\models\XMenuItem;
//-----------------------------------
?>
<style>
 .divider {
    height: 1px;
    margin: 9px 0;
    overflow: hidden;
    background-color: #e5e5e5;
}
</style>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
          <!-- pum -->
        <!-- <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div> -->

        <!-- search form -->
        <!-- pum -->
        <!-- <form action="#" method="get" class="sidebar-form"  style="visibility:hidden">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree    ', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],

                    ['label' => 'BD',
                        'items' => [
                            $mi->getitem('/salesinfo/index'),
                            $mi->getitem('/salesinfo/rawdata'),
                            $mi->getitem('/salesinfo/bycustomertype'),
                            $mi->getitem('/salesinfo/byproduct'),
                            //'<li class="divider"></li>',
                            ['options' => ['class' => 'divider']],                            
                            $mi->getitem('/receiveinfo/index'),   
                            // $mi->getitem('/receiveinfo/estimatereceipt'),   
                            // move to account
                            
                        ],
                    ],  
                    ['label' => 'Manufacturing', // Manufacturing
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
                            //'<li class="dropdown-header">Planning</li>',
                            $mi->getitem('/report/stock/minimum'),
                            $mi->getitem('/dbma/xquery/v_slow_moving_items'),     
                            // '<li class="divider"></li>',
                            
                            $mi->getitem('/dbma/xpkg-reserve/index'),        
                            $mi->getitem('/report/salesinfo/salesorderqty'),        
                            $mi->getitem('/report/salesinfo/qty'),        
                            $mi->getitem('/machine-capacity'),        
                            $mi->getitem('/packaging-waste'),     
                            $mi->getitem('/rawmaterial-waste'),
                            $mi->getitem('/xapi/ui/matsalesorder'),                            
                            // ---------- Production  ---------- 
                            //'<li class="divider"></li>',
                            //'<li class="dropdown-header">Production</li>',
                            
                            $mi->getitem('/dbma/xquery/v_waste_tube'),     
                            $mi->getitem('/report/r8'),     
                            $mi->getitem('/batch-packing-record'),     
                            $mi->getitem('/xapi/ui/prodyieldmach'),

                            // ---------- Quality Control ---------- 
                            //'<li class="divider"></li>',
                            //'<li class="dropdown-header">Quality Control</li>',                            
                            $mi->getitem('/dbma/itemqc'),                             
                        ],
                    ],                                        
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            $mi->getitem('/salesinfo/rawdata'),
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
