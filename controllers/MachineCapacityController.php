<?php

namespace app\controllers;
use yii;
use yii\data\ArrayDataProvider;
use app\models\SelectForm;
class MachineCapacityController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $SelectForm = new SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year'];
        }else{
            $SelectForm->year   = date("Y")-1;
        }

        $sql = "
            declare @year integer
            set @year=2017
            set @year=:year
            
            
            
            
            
            select b.machcode,b.machname+'  ( '+a.unit+' )' as machname
                ,(a.capacity*12) as y_capacity 
                ,c.jobqty
                ,isnull(c.rlse_qty,0) as rlse_qty
                ,isnull(c.recv_qty,0) as recv_qty
                ,isnull(round(c.rlse_qty/(a.capacity*12)*100,2),0) as capacity_percent_by_rlse
                ,isnull(round(c.recv_qty/(a.capacity*12)*100,2),0) as capacity_percent_by_recv
            from x_machine a
            left join machine b on a.machcode=b.machcode
            left join (
            
                select a.machcode
                    ,sum(jobqty) as jobqty	,cast (sum(rlse_qty) as float) as rlse_qty
                    ,sum(b.recv_qty) as recv_qty
                from wplandet a	
                left join (
                    select b.item_number,b.ana_no 
                    ,sum(b.recv_qty) as recv_qty
                    from sthead a 
                    left join stcard b on a.companycode=b.companycode and a.doctype=b.doctype and a.voucherno=b.voucherno
                    where year(a.docdate) = @year
                    and a.doctype= 'R2'
                    group by b.item_number,b.ana_no	
                )b on a.order_no = b.ana_no and a.item_number=b.item_number
                where year(a.startdatetime)=@year	
                group by a.machcode
            
            
            )c on a.machcode=c.machcode 
            
            
            
                
        ";         
      
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $command->bindParam(":year",$SelectForm->year);
        
        $rows = $command->queryAll();        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination'=>[
                'pageSize'=>50,
            ],
 
        ]);        
        return $this->render('index',[
            'dataProvider'=>$dataProvider,
            'rows'=>$rows,
            'SelectForm'    =>  $SelectForm,
        ]);
    }

}
