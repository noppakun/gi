<?php

namespace app\models;


class XMenuItem //extends \yii\db\ActiveRecord
{

    public static $items = [
        //'label' => 'Sales & Marketing',                        
        ['label' => 'Sales Info.', 'url' => ['/salesinfo/index']],
        ['label' => 'Sales Info. (RAWDATA)', 'url' => ['/salesinfo/rawdata']],
        ['label' => 'Sales Info. By Customer Type', 'url' => ['/salesinfo/bycustomertype']],
        ['label' => 'Sales Info. By Product', 'url' => ['/salesinfo/byproduct']],
        ['label' => 'Received Info.', 'url' => ['/receiveinfo/index']],
        ['label' => 'ประมาณการรับชำระ', 'url' => ['/receiveinfo/estimatereceipt']],
        //'label' => 'R&D',                

        ['label' => 'ใบแจ้งเพื่อขอให้พัฒนาผลิตภัณฑ์', 'url' => ['/xpdr']],
        ['label' => 'ใบแจ้งความต้องการบรรจุภัณฑ์', 'url' => ['/xpkr']],
        ['label' => 'ทะเบียน อย.', 'url' => ['/xfdaregister']],
        ['label' => 'Product Launching Planning', 'url' => ['/prod']],
        ['label' => 'ข้อมูลการจัดเตรียมโครงสร้างสินค้า', 'url' => ['/bom-temp']],
        ['label' => 'ข้อมูลโครงสร้างสินค้า', 'url' => ['/bom']],
        ['label' => 'Product Infomation File (new)', 'url' => ['/xpif']],
        ['label' => 'Product Infomation File (approved)', 'url' => ['/xpif/read']],

        
        ['label' => 'ข้อมูลการใช้ R.M. ย้อนหลัง 3+1 ปี', 'url' => ['/dbma/xquery/v_rm_use']],
        ['label' => 'ข้อมูลการใช้ P.M. ย้อนหลัง 3+1 ปี', 'url' => ['/dbma/xquery/v_pm_use']],
        
        ['label' => 'ปีที่รับเข้า Packaging->Tube', 'url' => ['/dbma/xquery/v_packaging_tube']],
        ['label' => 'Packaging รับเข้าใหม่', 'url' => ['/report/newitemreceive']],
        ['label' => 'Top 50 การใช้ packaging ในการผลิต ย้อนหลัง 12 เดือน', 'url' => ['/dbma/xquery/v_top50packaging_use']],
        // ['label' => 'ติดตั้ง รหัสโรงงาน / รหัสลูกค้า', 'url' => ['/dbma/item-rd']],
        ['label' => 'รายละเอียดสินค้า (RD)', 'url' => ['/xapi/ui/itemrd']],
        //['label' => 'Packaging แยกกลุ่ม แยกประเภท', 'url' => ['/dbma/xquery/v_packaging']],
        //['label' => 'Packaging แยกกลุ่ม แยกประเภท', 'url' => ['/xapi/ui/rd-packaging']],

        
        //'label' => 'Planning',
        ['label' => 'สินค้าที่ถึงจุดสั่งซื้อ', 'url' => ['/report/stock/minimum']],
        ['label' => 'Slow moving items', 'url' => ['/dbma/xquery/v_slow_moving_items']],
        ['label' => 'Packaging Reserve', 'url' => ['/dbma/xpkg-reserve/index']],
        ['label' => 'จำนวนขายจาก Sales Order แยกตามลูกค้า', 'url' => ['/report/salesinfo/salesorderqty']],
        ['label' => 'จำนวนขายแยกตามลูกค้า', 'url' => ['/report/salesinfo/qty']],
        ['label' => 'Machine Capacity', 'url' => ['/machine-capacity']],
        ['label' => 'Packaging Waste', 'url' => ['/packaging-waste']],
        ['label' => 'Raw Material Waste', 'url' => ['/rawmaterial-waste']],


        

        //'label' => 'Production',            
        ['label' => 'ของเสียจากการผลิต ย้อนหลัง 2+1 ปี (Tube)', 'url' => ['/dbma/xquery/v_waste_tube']],
        ['label' => 'ข้อมูลการผลิต ร.ง. 8', 'url' => ['/report/r8']],
        ['label' => 'Batch Packing Record', 'url' => ['/batch-packing-record']],

        //'label' => 'QC',        
        ['label' => 'ติดตั้งระยะเวลาในการบรรจุมาตฐาน', 'url' => ['/dbma/itemqc']],
        //'label' => 'Purchasing',          
        ['label' => 'XPR', 'url' => ['/xpr']],
        ['label' => 'รายงาน PR. ที่ยังไม่ได้เปิด PO.', 'url' => ['/dbma/xquery/v_prnotpo']],
        ['label' => 'Top 10 purchase', 'url' => ['/dbma/purchase-order/top']],
        ['label' => 'PO. Ship Date', 'url' => ['/dbma/purchase-order/shipdateitem']],
        ['label' => 'PO. History', 'url' => ['/po-history/index']],
        ['label' => 'Quotation Price by Items[B]', 'url' => ['/quotation/price']],
        ['label' => 'Quotation Price by Supplier[B]', 'url' => ['/quotation/price-by-supp']],


        ['label' => 'Item List', 'url' => ['/dbma/item/list']],
        ['label' => 'Supplier', 'url' => ['/dbma/supplier']],
        ['label' => 'Spare Part', 'url' => ['/dbma/sparepart']],
        //'label' => 'Accounting',

        ['label' => 'รายงานกระแสเงินสด', 'url' => ['/cash-flow/index']],
        ['label' => 'รายงานการเคลื่อนไหวสินค้า', 'url' => ['/stock/movement']],
        ['label' => 'ข้อมูล Job การผลิต', 'url' => ['/jobproductcost']],
        ['label' => 'Job ที่ต้นทุนมีการเปลี่ยนแปลง', 'url' => ['/jobproductcost/costchange']],
        ['label' => 'ทรัพย์สิน', 'url' => ['/dbma/asset']],
        ['label' => 'บันทึกวันที่นัดชำระ (ยังไม่วางบิล)', 'url' => ['/invoice-acc']],

        ['label' => 'บริษัท', 'url' => ['/dbma/company']],
        ['label' => 'สินค้าคงเหลือ', 'url' => ['/dbma/item/onhand']],
        //'label' => 'HR',

        ['label' => 'Time Attendance', 'url' => ['/timeattendance']],
        ['label' => 'Bookings', 'url' => ['/dbma/xbooking']],
        ['label' => 'รายการพัสดุกลาง', 'url' => ['/dbma/xquery/v_parcel_list']],
        ['label' => 'Calendar', 'url' => ['/dbma/hr/calendar']],
        ['label' => 'Alarm', 'url' => ['/dbma/alarm']],
        ['label' => 'Time attendance convert', 'url' => ['/dbma/alarm/timeconvert']],
        //'label' => 'EPA',
        ['label' => 'รายงานประเมินคุณภาพของผู้ขายตามวันที่รับของ', 'url' => ['/xapi/ui/kpi']],
        ['label' => 'Material for Sales Order',          'url' => ['/xapi/ui/matsalesorder']],
        [
            'label' => 'Production yield by machine',   'url' => ['/xapi/ui/prodyieldmach']
        ],
        // icon        
        [
            'label' => '<span class="glyphicon glyphicon-tasks "></span>',
            'url' => ['/xjobtracking'],
            'options' => [
                'title' => 'Job Tracking',
            ],
        ],
        // Setup
        ['label' => 'Sign in', 'url' => ['/user/security/login']],
        ['label' => 'User', 'url' => ['/user/admin']],
        ['label' => 'Admin', 'url' => ['/admin']],
        //['label' => 'App.Admin.', 'url' => ['/appa']],
        ['label' => 'dbma', 'url' => ['/dbma']],
    ];




    public function getitem($url)
    {
        $index = array_search($url, array_column((array_column(self::$items, 'url')), 0));
        if ($index !== false) {
            $_items = self::$items[$index];
            //$_items['label'] = $_items['label'] . ((\Yii::$app->user->can($url)) ? '' : '_');                        
        } else {
            $_items = ['label' => '*** get item error ("' . $url . '")', 'url' => ['#']];
        }
        return $_items;
    }
}
