<?php

namespace app\modules\xapi\controllers;

use Yii;
//use yii\data\ArrayDataProvider; 
use yii\web\Response;
use yii\data\Pagination;

use app\models\XCashflow;

class CashflowsController extends \yii\web\Controller
{
    public function actionIndex($date1 = null, $date2 = null, $currentPage = 1, $showPayDet = false, $rowsPerPage = 20, $xversion = 'PROD')
    {
        return $this->actionGetdata($date1, $date2, $currentPage, $showPayDet, $rowsPerPage, $xversion);
    }

    // ******************************************************************
    // ******************************************************************
    // ******************************************************************
    // ******************************************************************
    public function actionDeletedata()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = json_decode(file_get_contents("php://input"), true);
        if ($model = XCashflow::findOne($post['xid'])) {
            $model->delete();
        }
        return $post['xid'];
    }

    public function actionPostdata()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = json_decode(file_get_contents("php://input"), true);
        //\app\components\XLib::xprint_r($post);    
        if ($post['XCashflow']['xid'] == 0) {
            $model = new XCashflow();
        } else {
            $model = XCashflow::findOne($post['XCashflow']['xid']);
        }
        $model->load($post);
        $model->save();
        return  $model;
    }



    private function rawdataCashFlow($date1, $date2, $xversion = 'PROD')
    {
        // -- BF ----------------------------------------------------------------------------
        $sqlBF = "
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
        
            -- select 0 as seq,sum(a.amt) as amt
            --     from x_cashflow a
            --     where tr_date<@TrDate                
            -- union 

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
        //        $sql ="exec xeCashflowRawdata :date1,:date2" ; 

        //      if ($xversion == 'BETA'){
        $sql = "
                declare @date1  date
                declare @date2  date
                
                -- set @date1 = '2020-01-01'
                -- set @date2 = '2020-03-31'
        
                set @date1 = :date1
                set @date2 = :date2
                
                
                select 
                    'R' as rectype ,xid ,tr_date ,description   ,amt_receive
                    ,amt_pay ,note ,json_note ,'' as gexpend_code
                from xeCashflowRawdata_receive (@date1,@date2)
      
                union 
                select 
                    'P' as rectype ,0 as xid ,tr_date ,description ,0 as amt_receive
                    ,amt_pay  ,note ,'{}' as json_note  ,gexpend_code
                from xeCashflowRawdata_pay (@date1,@date2)
                       
                order by CAST(tr_date AS DATE),gexpend_code,amt_pay   
         
            
            ";


        $connection = \Yii::$app->erpdb;

        $command = $connection->createCommand($sqlBF);
        $command->bindParam(":trdate", $date1);
        $rowbf = $command->queryAll();

        $command = $connection->createCommand($sql);
        $command->bindParam(":date1", $date1);
        $command->bindParam(":date2", $date2);

        $rows =  $command->queryAll();


        array_unshift(
            $rows,
            [
                //'id'=>0,
                'rectype' => 'BF',
                'xid' => 0,
                'tr_date' => null,
                'description' => 'ยอดยกมา',
                'amt_receive' => $rowbf[0]['amt'],
                //'amt_receive' => 0,

                'amt_pay' => 0,
                'note' => '',
                'json_note' => '{}',

            ]
        );

        return $rows;
    }

    public function beforeAction($action)
    {
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionGetdatapaydetail($date1 = null, $date2 = null, $gexpend_code = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $sql = "
        declare @date1  date
        declare @date2  date
        declare @gexpend_code varchar(10)
        

        -- set @date1 = '2020-01-01'
        -- set @date2 = '2020-01-01'
       

        set @date1 = :date1
        set @date2 = :date2
        set @gexpend_code = :gexpend_code
                
        
        select * from xeCashflowRawdata_pay_detail(@date1,@date2) 
        where gexpend_code = @gexpend_code
        
    ";

        $connection = \Yii::$app->erpdb;


        $command = $connection->createCommand($sql);
        $command->bindParam(":date1", $date1);
        $command->bindParam(":date2", $date2);
        $command->bindParam(":gexpend_code", $gexpend_code);



        $rows =  $command->queryAll();



        // ----------------------------------------

        return [

            'rows' => $rows

        ];
        //return $date1;

    }

    function _process_timer(&$log, &$time_start, $note)
    {
        $time_post = microtime(true);
        $log[$note] = ($time_post - $time_start);
        $time_start = microtime(true);
    }
    public function actionGetdata($date1 = null, $date2 = null, $currentPage = 1, $showPayDet = false, $rowsPerPage = 20, $xversion = 'PROD')
    {

        $_log = [];
        $time_start = microtime(true);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rows = $this->rawdataCashFlow($date1, $date2, $xversion);
        $this->_process_timer($_log, $time_start, 'rawdataCashFlow');


        $balance = 0;
        $reccount = 0;
        // -----------------        
        $subtotal_pay_day = 3;
        $subtotal_pay_day_count = 0;
        $subtotal_pay = 0;
        $subtotal_pay_row = 0;
        $del_key = [];
        $dateCheck = '1/1/11';


        $_subtotal = ($showPayDet == 'false');
        $seq = 0;
        foreach ($rows as $key => $row) {
            $seq++;
            // $rows[$key]['id']=$seq;
            $balance += ($row['amt_receive'] - $row['amt_pay']);
            $rows[$key]['balance'] = $balance;
            $rows[$key]['json_note'] = json_decode($row['json_note']);
        }
        if ($_subtotal) {
            foreach ($del_key as $key) {
                unset($rows[$key]);
            }
        }

        $rows[0]['xid'] = '0';
        $rows[0]['amt_receive'] = '0';
        $rows[0]['amt_pay'] = '0';



        $this->_process_timer($_log, $time_start, 'loop_balance');



        $pages = new Pagination([
            'totalCount' => count($rows),
            'defaultPageSize' => $rowsPerPage,
        ]);




        $this->_process_timer($_log, $time_start, 'Pagination');


        $pages->params['offset'] = ($currentPage  - 1) * $pages->defaultPageSize;
        if ($pages->defaultPageSize != -1) { // all rows
            $rows = array_slice($rows, $pages->params['offset'], $pages->defaultPageSize);
        }
        $pages->params['rowcount'] = count($rows);


        // $_log['Rows Count  seq: ']=$seq;
        // $_log['Rows Count()  ']=count($rows);
        $_log['defaultPageSize'] = $pages->defaultPageSize;


        $this->_process_timer($_log, $time_start, 'array_slice');

        // ----------------------------------------

        return [
            'pages' => $pages,
            'rows' => $rows,
            'log' => $_log,


        ];
        //return $date1;

    }
}
