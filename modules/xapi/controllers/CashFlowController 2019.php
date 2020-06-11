<?php

namespace app\modules\xapi\controllers;

use Yii;
//use yii\data\ArrayDataProvider; 
use yii\web\Response;
use yii\data\Pagination; 

use app\models\XCashflow;

class CashFlowController extends \yii\web\Controller
{
    public function actionDeletedata()    
    {        
        Yii::$app->response->format = Response::FORMAT_JSON;       
        $post = json_decode(file_get_contents("php://input"),true);        
        if($model = XCashflow::findOne($post['xid'])){                     
            $model->delete(); 
        }
        return $post['xid'];        
    }    
 
    public function actionPostdata()    
    {        
        Yii::$app->response->format = Response::FORMAT_JSON;       
        $post = json_decode(file_get_contents("php://input"),true);
        //\app\components\XLib::xprint_r($post);    
        if($post['XCashflow']['xid'] == 0){
            $model = new XCashflow();                        
        }else{            
            $model = XCashflow::findOne($post['XCashflow']['xid']);                     
        }
        $model->load($post);        
        $model->save();       
        return  $model;        
    }    
 
 
    private function rawdataCashFlow($date1,$date2)
    {
        // -- BF ----------------------------------------------------------------------------
        $sqlBF ="
            -- ---------------------------------------------------
            -- from erp FPrintChequeMovement
            -- ---------------------------------------------------
            
            -- i1
            declare @CompanyCode varchar(10)
            declare @BankCode  varchar(10)
            declare @TrDate date
            
            set @CompanyCode = 'GPM'
            set @BankCode  ='02'
            set @TrDate ='20181101'

            set @TrDate = :trdate
      

            select sum(a.amt) as amt
            from (
                -- ---------------------------------------------------
                -- x_cashflow
                -- ---------------------------------------------------
            
        		select 0 as seq,sum(a.amt) as amt
            		from x_cashflow a
	            	where tr_date<@TrDate
	            	
            	union 

                -- ---------------------------------------------------
                -- income
                -- ---------------------------------------------------
                -- i1,i2,i3
                Select 1 as seq ,SUM(ChqPayAmount) as amt From ChequeTran
                Where Type in ('BR','L2','RO')
                And CompanyCode=@CompanyCode
                And BankCode=@BankCode
                And ChqPassDate<@TrDate
                And (ChqStatus='00' or ChqStatus='01' or ChqStatus='10')
                
                union	 
                
                --i4
                Select 2 as seq,SUM(NetAmt) as amt From BankTransaction
                Where  BankTranType LIKE 'R%'
                
                And BankCode=@BankCode
                And TranDate<@TrDate
                And Companycode=@Companycode
                union
                
                --i5
                Select 3 as seq,SUM(NetAmt) as amt From BankTransaction
                Where BankTranType='L1'
                And BankCode2=@BankCode
                And TranDate<@TrDate
                And CompanyCode=@BankCode
                And (ChqNo='' or ChqNo is null)
                
                union
                -- ---------------------------------------------------
                -- expense
                -- ---------------------------------------------------
                
                -- e1
                Select 10 as seq,-SUM(ChqPayAmount) as amt From ChequeTran as amt
                Where (Type='BI' Or Type='I4' Or Type='I5' Or Type='L1')
                And CompanyCode=@CompanyCode
                And BankCode=@BankCode
                And ChqDate<@TrDate
                And (ChqStatus='05' or ChqStatus='00' or ChqStatus='10')
                union
                
                -- e2
                Select 20 as seq,-SUM(NetAmt) as amt From BankTransaction
                Where (BankTranType LIKE 'I%' and BankTranType<>'I4' and BankTranType<>'I5')
                And BankCode=@BankCode
                And TranDate<@TrDate
                And CompanyCode=@CompanyCode
                union
                
                --e3
                Select 30 as seq,-SUM(NetAmt) as amt From BankTransaction
                Where BankTranType='L1'
                And BankCode=@BankCode
                And TranDate<@TrDate
                And CompanyCode=@CompanyCode
                And (ChqNo='' or ChqNo is null)	
            )a        
        
        ";
        // -- TR-----------------------------------------------------------------------------
        $sql ="
                                
            declare @date1  date
            declare @date2  date


            declare @CompanyCode VARCHAR(5)
            declare @BankCode VARCHAR(5)

            set @CompanyCode ='GPM'
            set @BankCode = '02'

            --set @date1 = '2018-11-01'
            --set @date2 = '2018-12-01'
            
            set @date1 = :date1
            set @date2 = :date2


                
            -- --------------------------------------        
            -- รายการรับจากใบวางบิล
            -- --------------------------------------
            select a.* 
            from (
                -- --------------------------------------        
                -- รายการ จาก x_cashflow
                -- --------------------------------------
                
                select 0 as id, id as xid,tr_date,description
                    ,case when amt >= 0 then amt else 0 end as amt_receive
                    ,case when amt <  0 then abs(amt) else 0 end as amt_pay
                    ,note                     
                from x_cashflow a
                where a.tr_date between @date1 and @date2 

                union

                select 0 as id,0 as xid
                    ,a.arduedate  as tr_date
                    ,'รับชำระหนี้จากลูกค้า - '+d.cust_name as description
                    ,sum(b.amount) as amt_receive                    
                    ,0 as amt_pay
                    ,'#'+b.arbillno as note  
                    

                    --,sum(b.payamount) as amt_receive
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
                select 0 as id,0 as xid
                ,a.ChqDate as tr_date
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
                
               
            )a order by CAST(a.tr_date AS DATE),a.amt_pay
            --)a order by a.tr_date,a.amt_pay
                        
        ";
         
        $connection = \Yii::$app->erpdb;      

        $command = $connection->createCommand($sqlBF);        
        $command->bindParam(":trdate",$date1);   
        $rowbf= $command->queryAll();
       // return $rowbf;


        $command = $connection->createCommand($sql);        
        $command->bindParam(":date1",$date1);   
        $command->bindParam(":date2",$date2); 

        $rows =  $command->queryAll();

        
        array_unshift($rows , 
            [                
                'id'=>0,
                'xid'=>0,
                'tr_date'=>null,
                'description' =>'ยอดยกมา',                
                'amt_receive' => $rowbf[0]['amt'],
                'amt_pay'=>0,                
                'note'=>'',

            ]
        );

        return $rows;
        
        
    }    
    public function beforeAction($action) {
            Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }    
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;     
        return '<br><br><br>xxxxxxxxx I N D E X xxxxxxxxxxxxxxxx';
    }
    
    public function actionGetdata($date1=null,$date2=null,$currentPage=1,$showPayDet=false,$rowsPerPage=20)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;       
       
        $rows = $this->rawdataCashFlow($date1,$date2);
  
                
        $balance = 0;       
        $reccount = 0;
        // -----------------        
        $subtotal_pay_day = 3;
        $subtotal_pay_day_count = 0;
        $subtotal_pay = 0;
        $subtotal_pay_row = 0;
        $del_key=[];
        $dateCheck = '1/1/11';

        
        $_subtotal = ($showPayDet=='false');
        $seq = 0;
        foreach($rows as $key => $row){            
            $seq++;
            
            $rows[$key]['id']=$seq;

            $balance += ($row['amt_receive']-$row['amt_pay']);            
            $rows[$key]['balance']=$balance;
            
            

            if($_subtotal){ //----------------------------------------------
                if (($row['amt_pay'] <> 0) and ($row['id']==0) and ($key<>0) ){
                    if ($dateCheck!=$row['tr_date']){
                        $subtotal_pay_day_count += 1;
                        $dateCheck=$row['tr_date'];
                    }
                    if ($subtotal_pay_day_count > $subtotal_pay_day){
                        $subtotal_pay_day_count = 1;
                        $subtotal_pay_row = $key;                    
                        $dateA = $dateCheck;
                    }else{
                        $rows[$subtotal_pay_row]['xid'] = 0;
                        $rows[$subtotal_pay_row]['amt_pay']     += $row['amt_pay'];
                        $rows[$subtotal_pay_row]['tr_date']     = $row['tr_date'];
                        $rows[$subtotal_pay_row]['description'] = 'รวมจ่ายชำระ : '                           
                            .\app\components\XLib::dateConv($dateA,'a').'  -  '                                    
                            .\app\components\XLib::dateConv($row['tr_date'],'a');                                         
                        $rows[$subtotal_pay_row]['balance'] = $balance;                                         
                        $rows[$subtotal_pay_row]['note'] = '';
                        
                        
                        $del_key[]=$key;                                
                    }                       
                            
                    // $rows[$key]['description']='p '.$subtotal_pay_day_count.' '.
                    // $rows[$key]['note']=$row['amt_pay'];
                } else {
                    $subtotal_pay_day_count = $subtotal_pay_day; // for reset subtotal_pay_day_count
                }
             } //----------------------------------------------
             //$rows[$subtotal_pay_row]['description'] = gettype($showPayDet);
  
          
        }        
        if ($_subtotal){
            foreach($del_key as $key){            
                unset($rows[$key]);                     
            }
        }
        $rows[0]['amt_receive']=0; 
 
        $pages = new Pagination([
            'totalCount' => count($rows),
            'defaultPageSize'=>$rowsPerPage,
        ]); 
           
        $pages->params['offset'] = ($currentPage  - 1) * $pages->defaultPageSize;                        
        $rows = array_slice( $rows, $pages->params['offset'], $pages->defaultPageSize );        
        $pages->params['rowcount'] = count($rows);
  
            
        // ----------------------------------------
        
         return [
            'pages'=>$pages,
            'rows'=>$rows

        ];
        //return $date1;
          
    }

}