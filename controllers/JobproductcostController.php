<?php
/*
from erp
\GPM\Enterprise\ManagerialAcc\ActualProductCosting\FJobProductCost.pas
*/
namespace app\controllers;
use yii;
use yii\data\ArrayDataProvider;
use app\models\JobProductCostQList;
use app\models\XItemExtVcost;
use app\models\SelectForm;
use app\models\ItemLoc;

class JobproductcostController extends \yii\web\Controller
{

    // ------------------------------------------------------------------------------------------------------------
    function vCal($Order_Number,$Item_Number,$JobNo  ,&$itemloc,&$rWPlanDet, &$dataProvider,&$rfooterADP,&$paraItem)    
    // ------------------------------------------------------------------------------------------------------------
    {
        $StCardINO = "*";
        // echo $Item_Number;
        // echo $Order_Number;
        // echo '<br>';
        // -- get data -------------         

               
        $mJobProductCost = new JobProductCostQList();
        $rWPlanDet =  $mJobProductCost->QueryWPlanDet($Order_Number,$Item_Number,$JobNo);        

        // echo '<pre>';        
        // print_r($rWPlanDet);
        // echo '</pre>';
        
        $rows  = $mJobProductCost->QueryItems($Order_Number,$Item_Number,$JobNo,$StCardINO);		



        // other expense
        $oe  = $mJobProductCost->QueryOtherExpense($Order_Number,$Item_Number,$JobNo);

        // --------------------

        

        // คำนวณต้นทุนรวมวัตถุดิบ
        $totalSumPrice=0;
        $totalSumlFixedCost=0;
        foreach ($rows as $value) {
            $totalSumPrice+=$value['SumPrice'];
            $totalSumlFixedCost+=$value['calFixedCost'];
        };
        $totalSumPrice = round($totalSumPrice,2);

        $dataProvider=new ArrayDataProvider( [
            'allModels' => $rows,
            'pagination'=>[
                'pageSize'=>50,
            ],
        ]);
        $FooterArray = [

            [ 'id'=>1,'note'=>'ต้นทุนวัตถุดิบ','manhour'=>'','unit'=> '','rate'=> '','amt'=>$totalSumPrice],
            [ 
                'id'=>2,'note'=>'แรงงานทางตรง','manhour'=>$rWPlanDet['ManHour'],'unit'=> 'M/H','rate'=> $rWPlanDet['calDirectLabor'],
                'amt'=> round($rWPlanDet['ManHour']*$rWPlanDet['calDirectLabor'],2)
            ],
            [ 
                'id'=>3,'note'=>'ค่าโสหุ้ยผันแปร','manhour'=>$rWPlanDet['ManHour'],'unit'=> 'M/H','rate'=> $rWPlanDet['calVariableCost'],
                'amt'=> round($rWPlanDet['ManHour']*$rWPlanDet['calVariableCost'],2)
                
            ],
            [ 
                'id'=>4,'note'=>'ค่าโสหุ้ยคงที่','manhour'=>$rWPlanDet['Job_QtyFixedCost'],'unit'=> $rWPlanDet['PackUom'],'rate'=> $rWPlanDet['W_FixedCost'],
                'amt'=> $rWPlanDet['calFixedCost']
                
            ],
            [ 
                'id'=>5,'note'=>'ค่าใช้จ่ายในการผลิตอื่น','manhour'=>0,'unit'=> '','rate'=> 0,
                'amt'=> $oe['OtherExpense']
            ],                                        
            /*
            [ 
                'id'=>3,'note'=>'อัตราค่าโสหุ้ยคงที่','manhour'=>0,'rate'=> 0, 'amt'=> 0
            ],
            */
        ];
        // คำนวณต้นทุนรวม Job
        $totalSumPrice = 0;
        foreach ($FooterArray as $value) $totalSumPrice+=$value['amt'];
        $totalSumPrice = round($totalSumPrice,2);

        $rfooterADP = new ArrayDataProvider([
            'allModels' => $FooterArray,
        ]);
        
        $itemloc = Itemloc::find()->where(['Item_Number' => $Item_Number,'Ana_No'=>$Order_Number])->one();
        
        $rWPlanDet['UnitPriceDatabase'] = ($itemloc)? $itemloc->UnitPrice : 0;
        

        
        $rWPlanDet['TotPriceNoFix']     = (($totalSumPrice-$totalSumlFixedCost)- $rWPlanDet['calFixedCost']);
        $rWPlanDet['UnitPriceNoFix']    =  ($itemloc)?$rWPlanDet['TotPriceNoFix'] / $rWPlanDet['Rlse_Qty'] : 0;
        

        
        $rWPlanDet['TotPrice']          = $totalSumPrice;
        $paraItem=[
            'Order_Number'=>$Order_Number,
            'Item_Number'=>$Item_Number,
            'JobNo'=>$JobNo,
            'StCardINO'=>$StCardINO
        ];
    }
    // ------------------------------------------------------------------------------------------------------------
    public function actionIndex()
    // ------------------------------------------------------------------------------------------------------------
    {
      
        $searchModel = new JobProductCostQList();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'=>$searchModel,
            'dataProvider' => $dataProvider,
        ]);                
    }
        
 
    // -------------------------------------------------------------------------------
    public function actionCostchange()
    // -------------------------------------------------------------------------------
    {

      $SelectForm = new SelectForm();
      if (isset(Yii::$app->request->queryParams['SelectForm'])) {
          $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year'];
      }else{
          $SelectForm->year   = date("Y");
      }
  		$sql ="
            
            declare @year integer
            set @year =2016
            set @year =:year

            -- select * ,round(a.calSum/a.Rlse_Qty,2) as calPrice
            select * ,a.calSum/a.Rlse_Qty as calPrice

            from (
                select * 
                    ,a.calDirectLabor+ a.calVariableCost+ a.calFixedCost +a.SumPrice+a.other as calSum
                from (
                    Select 
                        a.JobNo,B.Item_Number,b.order_no as ana_no
                        ,c.item_name
                        ,b.ManHour*b.DirectLabor as calDirectLabor
                        ,b.ManHour*b.VariableCost as calVariableCost
                        --,B.JobQty*C.Pack*C.PackSize*B.FixedCost  as calFixedCost 
                        ,B.FixedCost *b.Job_QtyFixedCost as calFixedCost 
                        ,B.Rlse_Qty
                        ,d.SumPrice
                        ,isnull(e.other,0) as other	 
                        ,f.UnitPrice 
                    From WPlan A 
                    left join WPlanDet B on A.JobNo=B.JobNo
                    Left Join Item C On B.Item_Number=C.Item_Number
                    left join (
                        Select A.JobNo ,A.RefDoc as Item_Number,sum(B.SumPrice) as SumPrice 
                        From StHead A,StCard B
                        Left Join Item C On B.Item_Number=C.Item_Number	
                        Where A.CompanyCode=B.CompanyCode
                        And A.DocType=B.DocType
                        And A.VoucherNo=B.VoucherNo
                        And (A.DocType='R3' Or A.DocType='I1')
                        group by A.JobNo ,A.RefDoc
                    ) d on  A.JobNo = d.JobNo and b.Item_Number=d.Item_Number
                    left join (  
                        Select A.JobNo
                            ,A.RefDoc as Item_Number
                            ,SUM(B.SumPrice) as  other
                            From StHead A,StCard B
                            Where A.CompanyCode=B.CompanyCode
                            And A.DocType=B.DocType
                            And A.VoucherNo=B.VoucherNo
                            And A.DocType='RD'
                        group by A.JobNo,A.RefDoc 
                    ) e on A.JobNo = e.JobNo and b.Item_Number=e.Item_Number 
                    left join ItemLoc f on  b.Item_Number=f.Item_Number  and b.order_no=f.ana_no
                    where year(a.JobDate)=@year
                )a 
                
            )a	
            where isnull(UnitPrice-round(a.calSum/a.Rlse_Qty,2),0) <>0
            order by  a.jobno,a.Item_Number,a.ana_no
            
                
      ";
    // -- tryear
            // gidata.dbo.
        //$connection = \Yii::$app->erpdb;
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);

        $command->bindParam(":year",$SelectForm->year);

        $rows = $command->queryAll();
        $dataProvider=new ArrayDataProvider( [
            'allModels' => $rows,
        ]);
 
        return $this->render('costchange', [
            'dataProvider' => $dataProvider,
            'SelectForm'    =>  $SelectForm,
        ]);
    }
    
    // ------------------------------------------------------------------------------------------------------------
    public function actionView($Order_Number,$Item_Number,$JobNo)    
    // ------------------------------------------------------------------------------------------------------------
    {

        $this->vCal($Order_Number,$Item_Number,$JobNo,$itemloc,$rWPlanDet, $dataProvider,$rfooterADP,$paraItem );
        return $this->render('view', [
            'itemloc'=>$itemloc,              
            'rWPlanDet'=> $rWPlanDet,
            'dataProvider' => $dataProvider,
            'rfooter'=>$rfooterADP,
            'paraItem'=>$paraItem,
						
        ]);   
    }    
    // ------------------------------------------------------------------------------------------------------------

    public function actionCalvcost()
    // ------------------------------------------------------------------------------------------------------------
    {

        $mJobProductCost = new JobProductCostQList();
        $rows  = $mJobProductCost->QueryWPlan4CalVariableCost();	
        echo  '<br>' ;             
        //echo  $rows->getCount();
        echo sizeof($rows);
        echo  '<br>' ;             
        
        $i=0;
        foreach ($rows as $row) {
            $Order_Number = $row['Order_No'];
            $Item_Number = $row['Item_Number'];
            $JobNo = $row['JobNo'];

            


            $i++;

//            echo $i.' : '.$Order_Number.' : '.$Item_Number.' : ';            
            //$this->vCal($Order_Number,$Item_Number,$JobNo,$itemloc,$rWPlanDet, $dataProvider,$rfooterADP,$paraItem );

            
            $this->vCal($row['Order_No'], $row['Item_Number'],$row['JobNo'],$itemloc,$rWPlanDet, $dataProvider,$rfooterADP,$paraItem );
            
            $XItemExtVcost = new XItemExtVcost();            
            //$XItemExt->ana_no = $Order_Number;
//            $XItemExt->item_number = $Item_Number;
            $XItemExtVcost->ana_no = $row['Order_No'];
            $XItemExtVcost->item_number = $row['Item_Number'];
            
            $XItemExtVcost->variable_cost = $rWPlanDet['UnitPriceNoFix'];
            
            
            $XItemExtVcost->save();  // a new row is inserted into user table

            echo $i.' : '.$row['Order_No'].' : '. $row['Item_Number'].' : '.$rWPlanDet['UnitPriceNoFix'];
            echo  '<br>' ;             
            
        };

        
        return;
 
             
    }
}
