<?php
namespace app\modules\xapi\controllers;
 
//use app\components\XExport;

class ProductionController extends  \yii\web\Controller
{
 

 // http://gi.greaterman.com/gi/web/index.php?r=xapi/production/prod-yield
    public function actionProdYield($date1='20190110',$date2='20190115')
    {
     
       
        $sql = "
            
            declare @date1 date
            declare @date2 date
            
            set @date1 = '20190201'
            set @date2 = '20190228'

            set @date1 = :date1
            set @date2 = :date2


            select
                c.MachCode
                ,e.machname
                ,cast(a.DocDate as date) as docdate
                ,b.Item_Number
                ,f.item_name
                ,b.Ana_No
                ,c.JobQty
                ,b.Recv_Qty
                --,'|' as d1
                --a.*
                --,c.*
                --,d.*
                --,b.* 
            
            from StHead a
            left join StCard b on a.CompanyCode=b.CompanyCode and a.VoucherNo=b.VoucherNo
            left join wplandet c on c.Order_No=a.Order_Number and c.Item_Number=b.Item_Number
            --left join prod d on d.Order_No=a.Order_Number --  and d.Item_Number=b.Item_Number
            left join Machine e on e.MachCode=c.MachCode
            left join Item f on f.Item_Number=b.Item_Number
            where cast(a.DocDate as date)  BETWEEN @date1 and @date2
            and a.doctype='R2' and b.doctype='R2'
            and c.Item_Type='B'
            order by c.MachCode,a.DocDate        
        
         
        ";
 

        $connection = \Yii::$app->erpdb;      
        $command = $connection->createCommand($sql);                
        $command->bindParam(":date1",$date1);   
        $command->bindParam(":date2",$date2);   
                                        
        $rows =  $command->queryAll();

        /*  ***** RETURN JSON *****


        $pages = new Pagination([
            'totalCount' => count($rows),
            'defaultPageSize'=>$rowsPerPage,
        ]); 
           
        $pages->params['offset'] = ($currentPage  - 1) * $pages->defaultPageSize;                        
        $rows = array_slice( $rows, $pages->params['offset'], $pages->defaultPageSize );        
        $pages->params['rowcount'] = count($rows);

        Yii::$app->response->format = Response::FORMAT_JSON;       
        return [         
            'pages'=>$pages,   
            'rows'=>$rows
        ];
        */        
      
                
         
        $filename ='prod_yield.xls'; 
        

        $options = [
            'columns'=>[                             
                'docdate'=>[
                    'DateFormat'=>'dd-mm-yyyy'
                ],
                'JobQty'=>[
                    'NumberFormat'=>'#,##0.00'
                ],
                'Recv_Qty'=>[
                    'NumberFormat'=>'#,##0.00'
                ],
            ]
        ];
    
        
        \app\components\XExport::x2xls($rows,$filename,$options);	

        return $this->redirect($filename);          
    }
    
}
 
 