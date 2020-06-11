<style>
    .container {width:1400px} 


    .clHead  {color: black; background-color:#DEE0FF} 

    .clGreen  {color: black; background-color:#DEFFED}       
    
    .clYellor  {color: black; background-color:#FFFDDE} 
    .clRed  {color: black; background-color:#FFDEF0} 
    .cllYellor  {color: black; background-color:#FFFFED} 




</style>

<?php


use yii\helpers\Html;

use kartik\grid\GridView;
 

use yii\bootstrap\ActiveForm;

$this->title = 'ข้อมูล Job การผลิต';
$this->params['breadcrumbs'][] = $this->title;


?>


<?php




    //$l_rec_amt=0;
    //$p_lcustno='x';

// GridView::widget('booster.widgets.TbExtendedGridView',[

    ?>
    <div class="container-fluid">   

    
    <?= GridView::widget([
       // 'pjax'=>true,        
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap'=>false,
        'headerRowOptions' => ['class' => 'clHead'],
        'showPageSummary' => true,

        'rowOptions' => function ($model, $index, $widget, $grid){
            if($model['JobStatus'] == 'O'){                        
                return ['class' => 'danger'];
            }else if($model['SaveJobProductCost'] == 0){                        
                    return ['class' => 'warning'];
                    
            }else{
                return [];
            }
        },
         
        'columns'=>[        
            //'JobStatus',
            [
                'label' => '.',
                'format' => 'raw',                
                'value' => function ($data) {
  
                    return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['/jobproductcost/view', 
                        'Order_Number' => $data['Order_No'],
                        'Item_Number' => $data['Item_Number'],
                        'JobNo' => $data['JobNo'],                        
                    ]);
                },
            ],                  
            [
                'attribute'=>'Order_No',
                'label'=>'Lot No.',
                'width'=>'120px',
            ],
            [
                'attribute'=>'JobNo',
                'label'=>'Job No.',
                'width'=>'120px',
            ],              
            
            [
              'attribute'=>'JobDate',
              'format' => ['date'],
              'width'=>'120px',
            ],
            [
                'label' => 'รับเข้าล่าสุด',
                'attribute'=>'lastReceiveDate',
                'format' => ['date'],
                'width'=>'120px',
            ],            
            
            [
                'attribute'=>'Item_Number',
                'label'=>'Item Number',
                'width'=>'200px',
            ],                       
            
            'Item_Name',            
            [
                'attribute'=>'JobQty',
                'label'=>'จำนวนที่สั่งผลิต',              
                'format' => ['decimal',2],
                //'contentOptions' => ['align' => 'right' ],
                'headerOptions' => ['width'=>'80px'],
                'pageSummary' => true ,
                'hAlign' => 'right',
    
              ],
            [
                'attribute'=>'Rlse_Qty',
                'label'=>'จำนวนที่ผลิตได้',              
                'format' => ['decimal',2],
                //'contentOptions' => ['align' => 'right' ],
                'headerOptions' => ['width'=>'80px'],
                'pageSummary' => true ,
                'hAlign' => 'right',
    
            ],
                 

            // [
            //     'label' => '.',
            //     'format' => 'raw',                
            //     'value' => function ($data) {
  
            //         return Html::a('<span  >*</span>', ['/jobproductcost/calvariablecost', 
            //             'Order_Number' => $data['Order_No'],
            //             'Item_Number' => $data['Item_Number'],
            //             'JobNo' => $data['JobNo'],                        
            //         ]);
            //     },
            // ],            
    /*
            [
                'label' => 'บันทึกต้นทุน',
                'attribute'=>'SaveJobProductCost',
                'format' => 'raw', 
                'value' => function ($data) {                    
                    return '<span class="glyphicon '
                        .(($data['SaveJobProductCost']==1)?'glyphicon-ok':'glyphicon-remove')
                        .'"></span>';  
                },  
            ],
            */
    
				
				
  
            
        ]           

    ]); ?>
<!--
<td style="background-color:red" ></td>
-->
 
    <table >
        <col width="30">
        <col width="10">
        <col width="100">
        <col width="30">
        <col width="10">
        <col width="300">  
        <tr>
            <td class="bg-danger" border: 1px solid black></td>    
            <td >      </td>
            <td>ยังไม่ปิด Job</td>
            <td class="bg-warning" ></td>    
            <td >      </td>
            <td>ยังไม่มีการบันทึกต้นทุนเข้าสินค้าที่ผลิต</td>
        </tr>
    
    </table>    
 
 
</div>