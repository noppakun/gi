<?php

use app\models\WPlanDet;
use app\models\XWplandetExt;

use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use \app\components\XLib;


$TABLECAPTION = 'BATCH PACKING RECORD';
$this->title = $TABLECAPTION;

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $WPlanDet->Order_No . ' - ' . $WPlanDet->Item_Number;
if (($xWplandetExt = $WPlanDet->xWplandetExt) == null) {
  $xWplandetExt = new XWplandetExt;
};
// ----- get variable
$compoundIssue = $WPlanDet->compoundIssue;
if ($compoundIssue == null) {
  $WPlanDetCompoundUom = null;
} else {
  $WPlanDetCompoundUom = $WPlanDetCompound->bom->item->Uom;
}

// -----------------------
echo DetailView::widget([
  'model' => $WPlanDet,
  'attributes' => [
    [
      'label' => 'PRODUCT',
      'value' => $WPlanDet->bom->item->Item_Name,

    ],
    [
      'columns' => [
        [
          'label' => 'PRODUCT CODE',
          'attribute' => 'Item_Number',
          'valueColOptions' => ['style' => 'width:30%'],
        ],
        [
          'label' => 'EffectiveDate',
          'value' =>  XLib::dateConv($WPlanDet->bom->EffectiveDate, 'a'),
        ],
      ],
    ],
    [
      'columns' => [
        [
          'label' => 'BATCH NO.',
          'attribute' => 'Order_No',
          'valueColOptions' => ['style' => 'width:30%'],
        ],
        [
          'label' => 'JOB NO.',
          'attribute' => 'JobNo',
        ],
      ],
    ],
    [
      'columns' => [
        [
          'label' => 'ORDER',
          'value' =>  number_format($WPlanDet->JobQty, 0) . ' ' . $WPlanDet->bom->item->Uom,
          'valueColOptions' => ['style' => 'width:30%'],
        ],
        [
          'label' => 'Net Fill',
          'value' =>  XLib::xnumber_format($xWplandetExt->netfill, 4, '-') . ' ' . $xWplandetExt->uom,
        ],
      ],
    ],
    [
      'label' => 'MANUFACTURING DATE',

      'value' => isset($WPlanDet->itemLoc->Mfg_Date) ? \app\components\XLib::dateConv($WPlanDet->itemLoc->Mfg_Date, 'a') : 'N/A',

    ],

  ],
]);

function _number($v, $uom)
{
  return $v  == 0  ? '-' : number_format($v, trim($uom) != 'ea' ? 2 : 0);
};

echo GridView::widget([
  'dataProvider' => $pmu,  // 'pmu'=>$packaging_materials_usage,
  'responsiveWrap' => false,
  'columns' => [
    [
      'label' => 'MAT.CODE',
      'attribute' => 'Component',
    ],
    [
      //'label' => 'PACKAGING MATERIALS',
      'header' => 'PACKAGING MATERIALS ' .
        Html::a('', [
          'refreshbombatch',
          'order_no' => $WPlanDet->Order_No,
          'item_number' => $WPlanDet->Item_Number,
        ], [
          'class' => 'btn btn-warning btn-xs 	glyphicon glyphicon-refresh',
          'title' => "refresh bom",
          'data' => [
            'confirm' =>  'แน่ใจว่าต้องการ refresh bom ?',
            'method' => 'post',
          ],
        ]),
      'attribute' => 'Item_Name',
      'headerOptions' => ['style' => 'text-align:center'],
    ],
    [
      'label' => 'UNIT',
      'attribute' => 'Uom',
      'hAlign' => 'center',
    ],
    [
      'label' => 'REQUESTED',
      'attribute' => 'requested',
      //'format' => ['decimal',1] ,
      'hAlign' => 'right',

      'value' => function ($model) {
        // if $model['added']  < 0 add to requested // nui 23/10/2018
        // ต้องใช้ยอดเบิกจริง เนื่องจากในการทำงานจริง ต้องเขียนแก้ใน report erp 13/2/2019         
        $val = $model['added']  < 0  ? $model['requested'] + $model['added'] : $model['requested'];
        //$val = $model['requested'] ;

        return  _number($val, $model['Uom']);
      },
    ],
    [
      'label' => 'ADDED',
      'attribute' => 'added',
      'value' => function ($model) {
        // if $model['added']  < 0 add to requested // nui 23/10/2018
        $val = $model['added']  < 0 ? 0  : $model['added'];
        // v.1 
        //--return  $val  == 0  ? '-' : number_format($val,0);             
        // แสดง ทศนิยม 1 ตำแหน่ง
        return _number($val, $model['Uom']);
      },
      'hAlign' => 'right',
      'contentOptions'  => function ($model) {
        return $model['added']  < 0 ? ['class' => 'text-danger'] : [];
      }
    ],
    [
      'label' => 'RETURNED',
      'attribute' => 'returned',
      'value' => function ($model) {
        return _number($model['returned'], $model['Uom']);
      },
      'hAlign' => 'right',
    ],

    [

      'label' => 'USED',
      'attribute' => 'used',
      'value' => function ($model) {
        return _number($model['used'], $model['Uom']);
      },

      'hAlign' => 'right',
    ],
    // -------------------------------------------
    // -----  for auto cal not from database -----
    // -------------------------------------------
    // [                    
    //   'header'=> Html::a('WASTE'
    //     , ['waste', 
    //     'order_no' => $WPlanDet->Order_No,
    //     'item_number' => $WPlanDet->Item_Number ,              
    //     'component' => $Compound->item->Item_Number,              
    //     ]),
    //   'attribute' => 'waste',      
    //   'value'=> function($model) {        
    //     // 'order_no'=>$order_no,
    //     // 'item_number'=>$item_number,
    //     return ($model['waste']  == 0?'-':number_format($model['waste'],0));
    //   },            
    //   'format'=>'raw',      
    //   'hAlign' => 'right',
    // ],    
    // 'qty_waste'
    [
      'header' => Html::a(
        'WASTE' . ' <span class="glyphicon glyphicon-pencil"></span>',
        [
          'waste',
          'order_no' => $WPlanDet->Order_No,
          'item_number' => $WPlanDet->Item_Number,
          'component' => isset($WPlanDetCompound->item->Item_Number) ? $WPlanDetCompound->item->Item_Number : null,
        ]
      ),
      'attribute' => 'qty_waste',
      'value' => function ($model) {
        // 'order_no'=>$order_no,
        // 'item_number'=>$item_number,        
        return _number($model['qty_waste'], $model['Uom']);
      },
      'format' => 'raw',
      'hAlign' => 'right',
    ],


  ]
]);


echo DetailView::widget([
  'model' => $WPlanDet,

  'attributes' => [
    [
      'label' => 'BULK',
      'value' => isset($WPlanDetCompound) ? $WPlanDetCompound->item->Item_Name : 'N/A',
    ],

    [
      'columns' => [
        [
          'label' => 'BULK CODE',
          'value' => isset($WPlanDetCompound) ? $WPlanDetCompound->item->Item_Number : 'N/A',
          'valueColOptions' => ['style' => 'width:30%'],
        ],

        [
          'label' => 'BATCH SIZE',
          // v.2
          // 'value' => function() use ($param){                              
          //   if (isset($param['BulkByJobQty'])){
          //     $ret = number_format($param['BulkByJobQty'],($param['Density'] > 0?2:0))
          //       .' '. $param['Uom'];              
          //   }else{
          //     $ret = 'N/A';
          //   }
          //   return $ret;
          // }, 
          // v.1  กลับมาใช้ v1 11/2/2019  nui   กรณี 1 job มี 2 finish good            
          'value' => function () use ($WPlanDet, $WPlanDetCompound, $Bulk_Batch_Size) {
            if (isset($WPlanDetCompound)) {
              $Bulk_Batch_Size = round($Bulk_Batch_Size, 2);
              return number_format($Bulk_Batch_Size, 2)
                . ' ' . $WPlanDetCompound->bom->item->Uom;
            } else {
              return 'N/A';
            }
          },
        ],

      ],
    ],



  ],
]);
?>
<?= DetailView::widget([
  'model' => $WPlanDet,
  'attributes' => [
    [
      'columns' => [
        [
          'label' => 'THEORETICAL YIELD',
          'value' => '100 %',
          'valueColOptions' => ['style' => 'width:15%'],
        ],
        [
          'label' => 'THEORETICAL',
          'value' => number_format($WPlanDet->JobQty, 0) . ' ' . $WPlanDet->bom->item->Uom,
          'valueColOptions' => ['style' => 'width:10%'],
        ],
        [
          'label' => 'BULK RECEIVED',
          'format' => 'html',
          'value' => function () use ($compoundIssue, $WPlanDetCompoundUom) {
            if (isset($compoundIssue)) {
              $ret = number_format($compoundIssue, 2) . ' ' . $WPlanDetCompoundUom;

              // ไม่แสดง nui 6/2/2019
              //.'  <span title="ยอดใช้ตาม actual">( ac:'.number_format($param['BulkByRlse_Qty'],2).' ) *<span>';              
            } else {
              $ret = 'N/A';
            }
            return $ret;
          },
        ],
      ],
    ],
    [
      'columns' => [
        [
          'label' => 'STANDARD YIELD',
          'value' => $WPlanDet->bom->StandardYieldMin . ' - ' . $WPlanDet->bom->StandardYieldMax . ' %',
          'valueColOptions' => ['style' => 'width:15%'],
        ],

        [
          'label' => 'ACTUAL',
          'value' => number_format($WPlanDet->Rlse_Qty, 0) . ' ' . $WPlanDet->bom->item->Uom,
          'valueColOptions' => ['style' => 'width:10%'],
        ],
        [

          'label' => 'WASTE',
          'valueColOptions' => ['style' => 'width:15%'],
          'format' => 'html',
          'value' => function () use ($WPlanDet, $xWplandetExt, $compoundIssue, $WPlanDetCompoundUom) {
            if (isset($compoundIssue)) {
              // v.1
              //$ret = number_format($param['compoundIssue']-$param['BulkByRlse_Qty'],2).' '. $param['Uom'] ;
              // v. 2    6/2/2019  nui
              $ret =
                number_format(
                  $compoundIssue
                    - (
                      ($WPlanDet->Rlse_Qty * $xWplandetExt->netfill)
                      / (in_array(rtrim($xWplandetExt->uom), ['g', 'ml']) ? 1000 : 1) // for unit convert g / ml to kg / Litres
                    ),
                  2
                ) . ' ' . $WPlanDetCompoundUom;
            } else {
              $ret = 'N/A';
            }
            return $ret;
          },

        ],
      ],
    ],
    [
      'columns' => [

        [
          'label' => 'ACTUAL YIELD',
          'value' => '',
          'valueColOptions' => ['style' => 'width:15%'],
        ],
        [
          'label' => '',
          'value' => (number_format($WPlanDet->Rlse_Qty / $WPlanDet->JobQty * 100, 2)) . ' %',
          'valueColOptions' => ['style' => 'width:10%'],

        ],
        [
          'label' => '',
          'valueColOptions' => ['style' => 'width:15%'],
          'value' => function () use ($Bulk_Batch_Size, $compoundIssue) {
            //v.1
            //if (isset($param['compoundIssue'])){                
            //  $ret = (number_format($param['BulkByRlse_Qty']/$param['compoundIssue']*100,2)).' %';                

            //v.2 nui 6/2/2019
            // if (isset($param['BulkByJobQty'])){                                
            //   $v = $param['compoundIssue']/$param['BulkByJobQty'];
            //v.3

            if (isset($Bulk_Batch_Size)) {

              // BulkByJobQty round 0 by nui 13/2/2019
              // $v = $compoundIssue / round($Bulk_Batch_Size, 0);

              // BulkByJobQty round 2 by nui 21/1/2020  { คุยพร้อมเรื่องการแก้ form ใน erp }
              $v = $compoundIssue / round($Bulk_Batch_Size, 2);
              
              $ret = (number_format($v * 100, 2)) . ' %';
              
            } else {
              $ret = 'N/A';
            }
            
            return $ret;
          },
        ],

      ],
    ],
  ],
]);


?>

<div class="row">
  <div class="col-md-5">


    <table class="table table-bordered table-striped detail-view">
      <tbody>
        <tr>
          <th colspan="4" class="text-center">
            MAN HOURS RECORD
          </th>
        </tr>
        <tr>
          <th>
            เริ่มผลิตจริง
          </th>
          <td>
            <?= \app\components\XLib::dateConv($WPlanDet->RealStartDateTime, 'a') ?>
          </td>
          <th>
            ผลิตเสร็จจริง
          </th>
          <td>
            <?= \app\components\XLib::dateConv($WPlanDet->RealStopDateTime, 'a') ?>
          </td>
        </tr>

        <tr>
          <th>
            OPERATIONS
          </th>
          <th class="text-center">
            NO. OF <br>OPERATIONS
          </th>
          <th class="text-center">
            HOURS PAID
          </th>
          <th class="text-center">
            ACTUAL
          </th>
        </tr>
        <tr>
          <th>
            CODING
          </th>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_c_no, 0, '-') ?>
          </td>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_c_hp, 2, '-') ?>
          </td>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_c_ac, 2, '-') ?>
          </td>
        </tr>
        <tr>
          <th>
            WASHING
          </th>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_w_no, 0, '-') ?>
          </td>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_w_hp, 2, '-') ?>
          </td>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_w_ac, 2, '-') ?>
          </td>
        </tr>
        <tr>
          <th>
            PACKING
          </th>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_p_no, 0, '-') ?>
          </td>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_p_hp, 2, '-') ?>
          </td>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_p_ac, 2, '-') ?>
          </td>
        </tr>
        <tr>
          <th>
            TOTAL
          </th>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_c_no + $xWplandetExt->mh_w_no + $xWplandetExt->mh_p_no, 0, '-') ?>
          </td>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_c_hp + $xWplandetExt->mh_w_hp + $xWplandetExt->mh_p_hp, 2, '-') ?>
          </td>
          <td class="text-right">
            <?= XLib::xnumber_format($xWplandetExt->mh_c_ac + $xWplandetExt->mh_w_ac + $xWplandetExt->mh_p_ac, 2, '-') ?>
          </td>
        </tr>
      </tbody>
    </table>

  </div>
  <style>
    .clDarkGreen {
      color: Red;
      background-color: #669900
    }
  </style>
  <div class="col-md-7">
    <?php

    // echo '<pre>';
    // print_r($WPlanDet->XWplandetWaste());
    // echo '</pre>';  

    // $resons=$WPlanDet->XWplandetWaste();
    echo GridView::widget([
      //'dataProvider' => $resons, 
      'dataProvider' => new ActiveDataProvider([
        'query' => $WPlanDet->XWplandetWaste(),
      ]),
      'responsiveWrap' => false,
      'columns' => [
        [
          'attribute' => 'component',
          'group' => true,
          'groupedRow' => true,
          'content' => function ($model) {
            return $model->component . ' : ' . $model->component2->Item_Name;
          },
        ],
        [
          'attribute' => 'reason',
          'label' => 'สาเหตุ',
          'content' => function ($model) {
            $wca_list = (new app\widgets\se2Wca)->itemsQueryArrayMap();
            return ((array_key_exists($model->wca_code, $wca_list)) ? $wca_list[$model->wca_code] : '') . ($model->reason == '' ? '' : ' ( ' . $model->reason . ' )');


            //return $model->reason.' ('.$model->wca_code.')';
          },
        ],

        [
          'attribute' => 'qty',
          'format' => ['decimal', 2],
          'hAlign' => 'right',
          // 'value'=>function($model){
          //   $v = $model['qty'];
          //   return ($v  === 0?'-':number_format($v,( trim($model['Uom'])!='ea'?2:0 ) ));      
          // }
        ],

      ]
    ]);


    ?>

  </div>
</div>
<?php


?>