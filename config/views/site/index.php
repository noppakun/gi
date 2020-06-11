<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = '[ ' . \Yii::$app->params['comp_code'] . ' Informaton ]';

?>
<div class="site-index">



    <div class="body-content">
        <p class="text-center">
            <a href="http://www.greaterman.com">
                <img src="images/logo.png">
            </a>
        </p>
        <div class="row center-block">
            <div class="col-lg-4  col-sm-6 ">
                <h2>ผลิตภัณฑ์ดูแลช่องปาก</h2>
                <a href="http://www.greaterman.com/web/th/oral-care.html">
                    <img src="http://www.greaterman.com/web/wp-content/uploads/2017/05/v1.png">
                </a>
            </div>
            <div class="col-lg-4  col-sm-6">
                <h2>ผลิตภัณฑ์ดูแลผิว</h2>
                <a href="http://www.greaterman.com/web/th/skin-care.html">
                    <img src="http://www.greaterman.com/web/wp-content/uploads/2017/05/v6.png">
                </a>
            </div>
            <div class="col-lg-4  col-sm-6">
                <h2>ผลิตภัณฑ์สำหรับเส้นผม</h2>
                <a href="http://www.greaterman.com/web/th/hair-care.html">
                    <img src="http://www.greaterman.com/web/wp-content/uploads/2017/05/v2.png">
                </a>
            </div>
 
            <a href=<?= (substr($_SERVER['REMOTE_ADDR'], 0, 9) == '192.168.0')
                        ? 'http://192.168.0.5:3001'
                        : 'http://ea.greaterman.com' ?> class="btn btn-success btn-sm">
                EA
            </a>

        </div>



        <?php
        // ------------------------------------
        // $mi :  menu item
        $mi = new app\models\XMenuItem;

        $devlogs = [
            
            [
                'url' => '/xpr',   // k.parun
                'type' => 'new',
                'date' => '25-05-2020',
                'note' => 'ใบขอซื้อสินค้า',
            ],

            [
                'url' => '/xapi/ui/itemrd',   // k.นิต
                'type' => 'update',
                'date' => '01-04-2020',
                'note' => 'ติดตั้ง รหัสโรงงาน/รหัสลูกค้า, ราคาซื้อล่าสุด',
            ],
            // [
            //     'url' => '/dbma/xquery/v_packaging',   // k.นิต
            //     'type' => 'new',
            //     'date' => '01-04-2020',                
            // ],              
            [
                'url' => '/xpkr',   // k.นก
                'type' => 'update',
                'date' => '01-04-2020',
                'note' => 'validate field',
            ],
            [
                'url' => '/xpdr',   // k.นก
                'type' => 'update',
                'date' => '01-04-2020',
                'note' => 'validate field',
            ],
            [
                'url' => '/dbma/xquery/v_pm_use',
                'type' => 'new',
                'date' => '12-02-2020',   // boonnum
                'note' => 'ข้อมูลการใช้ P.M. ย้อนหลัง 3 ปี',
            ],
            [
                'url' => '/dbma/xquery/v_rm_use',
                'type' => 'new',
                'date' => '12-02-2020',   // siriwan
                'note' => 'ข้อมูลการใช้ R.M. ย้อนหลัง 3 ปี',
            ],

            [
                'url' => '/salesinfo/index',
                'type' => 'update',
                'date' => '21-01-2020',   // k.jeed                 
                'note' => 'เพิ่มข้อมูลเป็น 3+1 (ย้อนหลัง 3 ปี + ปีปัจจุบัน)',
            ],
            [
                'url' => '/xpkr',   // k.jeed
                'type' => 'update',
                'date' => '06-01-2020',
                'note' => 'เพิ่มสถานะเอกสารกำลังแก้ไข',
            ],
            [
                'url' => '/xpdr',   // k.jeed
                'type' => 'update',
                'date' => '06-01-2020',
                'note' => 'เพิ่มสถานะเอกสารกำลังแก้ไข',
            ],
            [
                'url' => '/batch-packing-record',
                'type' => 'update',
                'date' => '12-11-2019',
                'note' => 'refresh bom',
            ],
            [
                'url' => '/xpkr',   // k.nid
                'type' => 'update',
                'date' => '23-10-2019',
                'note' => 'export xls',
            ],
            [
                'url' => '/xpdr',   // k.nid
                'type' => 'update',
                'date' => '23-10-2019',
                'note' => 'export xls',
            ],
            [
                'url' => '/report/stock/minimum',
                'type' => 'new',
                'date' => '4-10-2019',
            ],

            [
                'url' => '/dbma/xquery/v_waste_tube',
                'type' => 'new',
                'date' => '13-09-2019',
            ],
            [
                'url' => '/dbma/xquery/v_packaging_tube',
                'type' => 'new',
                'date' => '12-09-2019',
            ],

            [
                'url' => '/report/newitemreceive',
                'type' => 'new',
                'date' => '12-09-2019',
            ],
            [
                'url' => '/invoice-acc',
                'type' => 'new',
                'date' => '09-09-2019',
            ],
            [
                'url' => '/xpdr',
                'type' => 'update',
                'date' => '06-09-2019',
                'note' => 'ยกเลิกการลบเอกสาร',
            ],
            [
                'url' => '/xpkr',
                'type' => 'update',
                'date' => '06-09-2019',
                'note' => 'ยกเลิกการลบเอกสาร',
            ],
            [
                'url' => '/timeattendance',
                'type' => 'update',
                'date' => '30-08-2019',
                'note' => 'สามารถกำหนดสิทธิระดับส่วนได้'
            ],
            [
                'url' => '/dbma/purchase-order/top',
                'type' => 'update',
                'date' => '15-08-2019',
                'note' => 'เพิ่มข้อมูลรายระเอียดแยกตามปี'
            ],

            [
                'url' => '/report/r8',
                'type' => 'new',
                'date' => '07-08-2019',
            ],
            [
                'url' => '/xpdr',
                'type' => 'update',
                'date' => '02-08-2019',
                'note' => 'เพิ่มข้อมูลข้อมูล BD.ผู้รับผิดชอบ, RD.ผู้รับผิดชอบ, สามารถยกเลิกรายการได้ ',
            ],
            [
                'url' => '/xpkr',
                'type' => 'update',
                'date' => '02-08-2019',
                'note' => 'เพิ่มข้อมูลข้อมูล BD.ผู้รับผิดชอบ, RD.ผู้รับผิดชอบ, สามารถยกเลิกรายการได้ ',
            ],
            [
                'url' => '/jobproductcost',
                'type' => 'update',
                'date' => '26-07-2019',
                'note' => 'เพิ่มข้อมูลวันที่รับเข้าล่าสุด',
            ],
            [
                'url' => '/dbma/xquery/v_slow_moving_items',
                'type' => 'update',
                'date' => '23-07-2019',
                'note' => 'ปรับรูปแบบ เพิ่มข้อมูลสินค้าสำเร็จรูป',
            ],
            [
                'url' => '/dbma/item/onhand',
                'type' => 'update',
                'date' => '12-07-2019',
                'note' => 'เพิ่มข้อมูลความเคลื่อนไหวย้อนหลัง 2 ปี',
            ],

            [
                'url' => '/receiveinfo/estimatereceipt',
                'type' => 'update',
                'date' => '12-07-2019',
                'note' => 'เพิ่มรายงานทางเครื่องพิมพ์',
            ],

            [
                'url' => '/xpdr',
                'type' => 'update',
                'date' => '10-07-2019',
                'note' => 'เพิ่มการตรวจสอบความแตกต่าง revision',
            ],
            [
                'url' => '/xpdr',
                'type' => 'update',
                'date' => '10-07-2019',
                'note' => 'เพิ่มการตรวจสอบความแตกต่าง revision',
            ],
            [
                'url' => '/timeattendance',
                'type' => 'new',
                'date' => '03-07-2019',
            ],
            [
                'url' => '/xpdr',
                'type' => 'update',
                'date' => '21-06-2019',
                'note' => 'เพิ่มตรางรายละเอียดบรรจุภัณฑ์ในหน้า view',
            ],
            [
                'url' => '/xpdr',
                'type' => 'update',
                'date' => '21-06-2019',
                'note' => 'เพิ่มการทำ Revise เอกสาร (pdr,pkr)',
            ],
            [
                'url' => '/dbma/xquery/v_parcel_list',
                'type' => 'new',
                'date' => '04-06-2019',
            ],

            [
                'url' => '/dbma/xquery/v_slow_moving_items',
                'type' => 'new',
                'date' => '23-05-2019',
            ],
            [
                'url' => '/batch-packing-record',
                'type' => 'update',
                'date' => '20-05-2019',
                'note' => 'แก้ไขให้รองรับ job repack (ไม่มี compound)',
            ],
            [
                'url' => '/dbma/xquery/v_top50packaging_use', // RD นู๋เล็ก
                'type' => 'new',
                'date' => '07-05-2019',
            ],
            [
                'url' => '/receiveinfo/index',
                'type' => 'update',
                'date' => '03-05-2019',   // k.jeed
                'note' => 'เพิ่ม column พนักงานขาย',
            ],
            [
                'url' => '/dbma/xbooking', // HR
                'type' => 'new',
                'date' => '2-05-2019',
                'note' => '่ระบบจองห้องประชุม',
            ],

            [
                'url' => '/dbma/xquery/v_prnotpo', // จิ planning , ji
                'type' => 'new',
                'date' => '26-03-2019',
            ],

            [
                'url' => '/xapi/ui/prodyieldmach', // k.tom
                'type' => 'new',
                'date' => '15-03-2019',
            ],
            [
                'url' => '/xapi/ui/matsalesorder', // k.parun , ji
                'type' => 'new',
                'date' => '13-03-2019',
            ],

            [
                'url' => '/prod',
                'type' => 'update',
                'date' => '14-02-2019',   // k.นิด
                'note' => '885x แสดงเฉพาะที่เลือกไม่ต้องแสดงทั้งหมดในใบสั่งผลิต, แสดง Compound ที่ปิดไปแล้ว',
            ],
            [
                'url' => '/dbma/xpkg-reserve/index', // k.parun
                'type' => 'new',
                'date' => '13-02-2019',
            ],
            [
                'url' => '/batch-packing-record',
                'type' => 'update',
                'date' => '11-02-2019',   // นุ่ย
                'note' => 'เพิ่มการสำเนาสูตรตามใบสั่งผลิดเพื่อแก้ปัญหาสูตรเปลี่ยนหลังจากสั่งผลิต',
            ],
            [
                'url' => '/dbma/purchase-order/top', // k.parun
                'type' => 'new',
                'date' => '3-01-2019',
            ],
            [
                'url' => '/xfdaregister',
                'type' => 'update',
                'date' => '21-01-2019',   // หวาน RD
                'note' => 'ปรับปรุงการแสดงสถานะหมดอายุ',
            ],
            [
                'url' => '/po-history/index', // k.nid
                'type' => 'new',
                'date' => '3-01-2019',
            ],
            [
                'url' => '/salesinfo/byproduct',
                'type' => 'new',
                'date' => '17-12-2018',
            ],
            [
                'url' => '/salesinfo/bycustomertype',
                'type' => 'new',
                'date' => '17-12-2018',

            ],
            [
                'url' => '/receiveinfo/index',
                'type' => 'update',
                'date' => '13-12-2018',   // k.jeed
                'note' => 'export xls : เพิ่มข้อมูล เดือน , ประเภทลูกค้า',
            ],
            [
                'url' => '/report/salesinfo/salesorderqty', // lotus
                'type' => 'new',
                'date' => '3-12-2018',   // k.off              
            ],
            [
                'url' => '/report/salesinfo/qty', // lotus
                'type' => 'new',
                'date' => '30-11-2018',   // k.off              
            ],
            [
                'url' => '/bom',
                'type' => 'update',
                'date' => '20-11-2018',   // k.nid                 
                'note' => 'เพิ่มข้อมูล Quarantine, Reserved ใน screen, xls',
            ],
            [
                'url' => '/salesinfo/index',
                'type' => 'update',
                'date' => '12-11-2018',   // k.jeed                 
                'note' => 'สามารถเลือกแสดงผลแบบไม่รวมยอดเงินมัดจำ',
            ],
            [
                'url' => '/cash-flow/index',
                'type' => 'new',
                'date' => '5-11-2018',

            ],
            [
                'url' => '/quotation/price',
                'type' => 'update',
                'date' => '2-11-2018',
                'note' => 'แสดงรายละเอียดของ Quotation/PO.', // อ้อย
            ],
            [
                'url' => '/salesinfo/index',
                'type' => 'update',
                'date' => '1-11-2018',   // k.jeed                 
                'note' => 'export xls',
            ],
            [
                'url' => '/salesinfo/index',
                'type' => 'new',
                'date' => '31-10-2018',   // k.jeed                 
            ],
            [
                'url' => '/receiveinfo/estimatereceipt',
                'type' => 'new',
                'date' => '25-10-2018',   // k.jeed                 
            ],
            [
                'url' => '/salesinfo/rawdata',
                'type' => 'update',
                'date' => '17-10-2018',
                'note' => 'เพิ่ม รหัสพนักงานขาย',  // k.jeed
            ],
            [
                'url' => '/batch-packing-record',
                'type' => 'update',
                'date' => '16-10-2018',
                'note' => 'add year fillter',
            ],
            [
                'url' => '/bom',
                'type' => 'update',
                'date' => '16-10-2018',
                'note' => 'set default order by effective date, packing calculate from master',
            ],
            [
                'url' => '/batch-packing-record',
                'type' => 'new',
                'date' => '15-10-2018',
            ],
            [
                'url' => '/xjobtracking',
                'type' => 'update',
                'date' => '24-08-2018',
                'note' => 'line notify on create/update',
            ],
            [
                'url' => '/bom',
                'type' => 'update',
                'date' => '24-08-2018',
                'note' => 'ราคา r/m จาก po คำนวณตาม exchange rate ใน po',
            ],
            [
                'url' => '/rawmaterial-waste',
                'type' => 'new',
                'date' => '17-08-2018',
            ],
            [
                'url' => '/packaging-waste',
                'type' => 'update',
                'date' => '14-08-2018',
                'note' => 'export xls:เพิ่มข้อมูลเครื่องจักร',
            ],
            [
                'url' => '/xfdaregister',
                'type' => 'update',
                'date' => '13-08-2018',
                'note' => 'เพิ่ม notify > email',
            ],
            [
                'url' => '/xjobtracking',
                'type' => 'update',
                'date' => '12-8-2018',
                'note' => 'เพิ่ม print > pdf',
            ],
            [
                'url' => '/xfdaregister',
                'type' => 'new',
                'date' => '12-8-2018',
            ],
            [
                'url' => '/xjobtracking',
                'type' => 'new',
                'date' => '7-8-2018',
            ],
            [
                'url' => '/packaging-waste',
                'type' => 'update',
                'date' => '6-8-2018',
            ],
            [
                'url' => '/machine-capacity',
                'type' => 'update',
                'date' => '3-8-2018',
            ],
            [
                'url' => '/xpif',
                'type' => 'new',
                'date' => '7-6-2018',
            ],
            [
                'url' => '/bom-temp',
                'type' => 'new',
                'date' => '18-5-2018',
            ],

        ];


        ?>

        <style>
            .content-separator {
                margin-top: 2em;
            }

            .tab1 {
                margin-left: 80px;
            }
        </style>
        <div class="container   content-separator    ">
            <div>
                <span>Latest Updates</span>
            </div>
            <div class="row center-block">
                <?php


                foreach ($devlogs as $devlog) {
                ?>
                    <div class="col-lg-4  col-sm-4 ">
                        <?php
                        $menuitem = $mi->getitem($devlog['url']);
                        $devlog['date'] = date('d-m-Y', strtotime($devlog['date']));
                        echo $devlog['date'] . ' : '
                            . Html::a(
                                (
                                    (isset($menuitem['options']['title']))
                                    ? $menuitem['options']['title']
                                    : $menuitem['label']),
                                [$devlog['url']]
                            )
                            . ' <span class="label label-'
                            . ($devlog['type'] == 'new' ? 'success' : 'warning')
                            . '">' . ucwords($devlog['type']) . '</span>'
                            . (isset($devlog['note']) ? '<br><div class="tab1">' . $devlog['note'] . '</div>' : '');

                        ?>
                    </div>
                <?php
                }

                ?>
            </div>
        </div>
    </div>

</div>