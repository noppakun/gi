<?php
/*   move to CashflowsController  */ 
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

    
 
    private function rawdataCashFlow($date1,$date2,$xversion='PROD')
    {        
        // $sql ="exec xeCashflowRawdata :date1,:date2" ; 

        if ($xversion == 'BETA'){
            $sql ="
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
                
            
            " ;
        }else{

            $sql ="
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
    
                order by CAST(tr_date AS DATE),gexpend_code,amt_pay              
            
            " ;                
            
        }

        $connection = \Yii::$app->erpdb;      
 

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
          //      'amt_receive' => $rowbf[0]['amt'],
                'amt_receive' => 0,
                          
                'amt_pay'=>0,                
                'note'=>'',
                'json_note'=>'{}',

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
    
    public function actionGetdatapaydetail($date1=null,$date2=null,$gexpend_code=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;    

        $sql ="
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
        
    " ;   

    $connection = \Yii::$app->erpdb;      
 

    $command = $connection->createCommand($sql);        
    $command->bindParam(":date1",$date1);  
    $command->bindParam(":date2",$date2);  
    $command->bindParam(":gexpend_code",$gexpend_code);  
     
 

    $rows =  $command->queryAll();
      
 
            
        // ----------------------------------------
        
         return [
           
            'rows'=>$rows

        ];
        //return $date1;
          
    }
    public function actionGetdata($date1=null,$date2=null,$currentPage=1,$showPayDet=false,$rowsPerPage=20,$xversion='PROD')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;    
        $rows = $this->rawdataCashFlow($date1,$date2,$xversion); 
                
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
            $rows[$key]['json_note'] = json_decode($row['json_note']);          
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