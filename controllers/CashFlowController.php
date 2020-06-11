<?php
namespace app\controllers;
use Yii;
use yii\data\ArrayDataProvider;
use app\models\SelectForm;
use app\components\XLib;

class CashFlowController extends \yii\web\Controller
{
    
    private function rawdataCashFlow($date1,$date2)
    {
        $sql ="
                            
            declare @date1  date
            declare @date2  date


            declare @CompanyCode VARCHAR(5)
            declare @BankCode VARCHAR(5)

            set @CompanyCode ='GPM'
            set @BankCode = '02'

            set @date1 = :date1
            set @date2 = :date2


                
            -- --------------------------------------        
            -- รายการรับจากใบวางบิล
            -- --------------------------------------
            select a.* 
            from (
                select
                    a.arduedate as tr_date
                    ,'รับชำระหนี้จากลูกค้า - '+d.cust_name as description
                    ,sum(b.amount) as amt_receive
                    --,sum(b.payamount) as amt_receive
                    ,0 as amt_pay
                    ,'#'+b.arbillno as note               
                    --,a.cust_no
                    --, b.payamount
                    --,b.due_date
                    --,b.inv_number                
                from  ArBillMast a                   
                left join ArBillTran b            
                    on a.arbillno=b.arbillno
                    and a.companycode=b.companycode
                left join customer d on d.cust_no =a.cust_no                    
                where a.arduedate between @date1 and @date2
                group by a.arduedate ,b.arbillno,d.cust_name
                --order by a.arduedate
                
                union
                -- --------------------------------------        
                -- รายการจ่ายจากเช็คจ่าย
                -- --------------------------------------            
                select a.ChqDate as tr_date
                ,'จ่ายชำระ - '+a.Supp_Name as description
                ,0 as amt_receive
                ,ChqPayAmount as amt_pay
                ,rtrim(A.ChqNo)+' / #'+A.VoucherNo as note
                from (
                    -- -------------------------------------------------            
                    -- from ERP   FPrintChequeExpendOrderByChqDate
                    -- -------------------------------------------------        
                    Select A.ChqNo,A.VoucherNo,A.ChqStatus,A.ChqDate,A.ChqPayAmount,A.ChqRecvDate,A.ChqPassDate,
                    B.BankName,B.AccNo,B.BankType,D.Supp_Name From ChequeTran A
                    Left Join Bank B On A.BankCode=B.BankCode
                    Left Join CashMast C On A.CompanyCode=C.CompanyCode And A.Type=C.Type And A.VoucherNo=C.VoucherNo
                    Left Join Supplier D On C.Supp_Number=D.Supp_Number
                    Where A.Type='BI'
                    And A.CompanyCode=@CompanyCode
                    And (A.BankCode=@BankCode)
                    And (A.ChqDate Between @Date1 And @Date2)
                    UNION
                    Select A.ChqNo,A.VoucherNo,A.ChqStatus,A.ChqDate,A.ChqPayAmount,A.ChqRecvDate,A.ChqPassDate,
                    B.BankName,B.AccNo,B.BankType,C.Supp_Name From ChequeTran A
                    Left Join Bank B On A.BankCode=B.BankCode
                    Left Join BankTransaction C On A.Type=C.BankTranType And A.VoucherNo=C.VoucherNo And A.CompanyCode=C.CompanyCode And A.ChqNo=C.ChqNo
                    Where ((A.Type='I4') or (A.Type='I5') or (A.Type='L1'))
                    And A.CompanyCode=@CompanyCode
                    And (A.BankCode=@BankCode)
                    And (A.ChqDate Between @Date1 And @Date2)
                    --	Order By A.ChqDate,A.ChqNo
                )a         
            )a order by a.tr_date,a.amt_pay
                        
        ";
        //$a= ((isnull(b.payamount,0) < a.totalamount) or (:only_arbill = 0))           
        $connection = \Yii::$app->erpdb;      
        $command = $connection->createCommand($sql);

        
        $command->bindParam(":date1",$date1);   
        $command->bindParam(":date2",$date2); 

        return $command->queryAll();

        
    }    
    public function actionIndex()
    {        
        return $this->render('index');      
        //return $this->renderPartial('index');      
                  
    }

    public function actionIndex1()
    {
        $SelectForm = new SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {                            
            $SelectForm->date       = Yii::$app->request->queryParams['SelectForm']['date']; 
            $SelectForm->date2      = Yii::$app->request->queryParams['SelectForm']['date2']; 
        }else{
            $SelectForm->date       = Yii::$app->formatter->asDate('now - 1 months');
            $SelectForm->date2      = Yii::$app->formatter->asDate('now');            

            $SelectForm->date       = '29-10-2018';
            $SelectForm->date2      = '30-11-2018';

        } 
                
        $rows = $this->rawdataCashFlow(
            XLib::dateConv($SelectForm->date,'b'),
            XLib::dateConv($SelectForm->date2,'b')
        );

        $balance = 0;       
           
        foreach($rows as $key => $row){
            
            $balance += ($row['amt_receive']-$row['amt_pay']);
            $rows[$key]['balance']=$balance;
        }
   

        $dataProvider=new ArrayDataProvider( [
            'allModels' => $rows,
            'pagination'=>[
                'pageSize'=>50,
            ],
        ]);        
        
        return $this->render('index', [            
            'SelectForm'    =>  $SelectForm,
            'dataProvider'    =>  $dataProvider,
     

        ]);        
        
    }    

}