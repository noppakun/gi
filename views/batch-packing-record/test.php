<?php
use app\models\WPlanDet;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use kartik\detail\DetailView;
 
// $order_no='467140';
// $item_number = '8850279467217'; 

// $order_no='427168';
// $item_number = '8850279427518'; 

// $order_no='427168';
// $item_number = '8850279427723';




 
// // -----------------------------------------------------------------------
// $Compound = WPlanDet::findOne(['Order_No'=>$order_no,'Item_Type'=>'B']); 
// $WPlanDet = WPlanDet::findOne(['Order_No'=>$order_no,'Item_Number'=>$item_number]);
 
// $BomDetBatch = new ActiveDataProvider([
//   'query' => $WPlanDet->getBomDetBatch(),
// ]);  

 
echo GridView::widget([
  'dataProvider' => $dataProvider, 
  
 
]); 
 