<?php

namespace app\modules\report\controllers;
use yii;
use yii\data\ArrayDataProvider;
use yii\web\Response;
use app\models\SelectForm;
use app\models\XSalesinfoSearch;
class SalesinfoController extends \yii\web\Controller
{
    // -------------------------------------------------------------------------------        
    public function actionQty2spreadsheet($year,$year2,$cust_no)
    // -------------------------------------------------------------------------------        
    {
        $rows = $this->rawdataQty('IV',$year,$year2,$cust_no);    
        
        $filename='salesinfo_qty.xls';
        \app\components\XExport::x2xls($rows,$filename);
        (new Response())->sendFile($filename)->send();
        unlink($filename);
 						
    }  
    // -------------------------------------------------------------------------------        
    public function actionSalesorderqty2spreadsheet($year,$year2,$cust_no)
    // -------------------------------------------------------------------------------        
    {
        $rows = $this->rawdataQty('SO',$year,$year2,$cust_no);    
        
        $filename='salesorder_qty.xls';
        \app\components\XExport::x2xls($rows,$filename);
        (new Response())->sendFile($filename)->send();
        unlink($filename);
 						
    }        
    // -------------------------------------------------------------------------------        
 
    private function rawdataQty($trtype,$year,$year2,$cust_no)
    {
        
        if($trtype=='IV'){
            $sql = "
                declare @year int            
                declare @year2 int                                    
                declare @cust_no char(10)            

                set @year = :year
                set @year2 = :year2     
                set @cust_no  = :cust_no

                
                select a.*
                ,b.cust_name
                from (
                    select 'CN' as trtype
                        ,a.cn_number as doc_no,a.cn_date as doc_date,a.cust_no 
                        ,b.item_number,b.cndet_desc as item_desc,b.uom,-b.order_qty as qty
                    from cn a
                    left join cndetail b on b.companycode=a.companycode and b.cn_number=a.cn_number             
                    where year(a.cn_date) between @year and @year2
                        and a.cust_no=@cust_no                
                    union

                    select 'IV' as trtype
                        ,a.inv_number as doc_no,a.inv_date as doc_date,a.cust_no 
                        ,b.item_number,b.invdet_desc as item_desc,b.uom,b.order_qty as qty
                    from invoice a
                    left join invoicedet b on b.companycode=a.companycode and b.inv_number=a.inv_number 
                    where year(a.inv_date) between @year and @year2
                    and a.cust_no=@cust_no
                )a left join Customer b on b.cust_no=a.cust_no
                order by doc_date,doc_no,trtype
            "; 
        } else if($trtype=='SO'){
            $sql = "            
                declare @year int            
                declare @year2 int                                    
                declare @cust_no char(10)            

                set @year = :year
                set @year2 = :year2     
                set @cust_no  = :cust_no
                            
                select a.*
                ,b.cust_name
                from (
                    select 'SO' as trtype
                        ,a.sale_number as doc_no,a.sale_date as doc_date,a.cust_no 
                        ,b.item_number,c.item_name as item_desc,b.uom,b.order_qty as qty
                    from sale a
                    left join saledet b on b.companycode=a.companycode and b.sale_number=a.sale_number
                    left join item c on c.item_number=b.item_number 
                    where year(a.sale_date) between @year and @year2
                    and a.cust_no=@cust_no
                )a left join Customer b on b.cust_no=a.cust_no
                order by doc_date,doc_no,trtype     
            "; 
        }
        
        $connection = \Yii::$app->erpdb;      
        $command = $connection->createCommand($sql);     
        $command->bindParam(":year",$year);   
        $command->bindParam(":year2",$year2);           
        $command->bindParam(":cust_no",$cust_no);        
        return $command->queryAll();
        
    }

    private function _Qty($trtype)
    {
        $SelectForm = new SelectForm();
        
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {                            
            $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year']; 
            $SelectForm->year2       = Yii::$app->request->queryParams['SelectForm']['year2']; 
            
            $SelectForm->cust_no     = Yii::$app->request->queryParams['SelectForm']['cust_no'];
        }else{
            $SelectForm->year   = date("Y")-3;                
            $SelectForm->year2   = date("Y");                
            $SelectForm->cust_no     = '*';        

        }         

        $rows = $this->rawdataQty(
            $trtype,
            $SelectForm->year,
            $SelectForm->year2,
            $SelectForm->cust_no
        );
        
        $dataProvider=new ArrayDataProvider( [
            'allModels' => $rows,
            'pagination'=>[
                'pageSize'=>25,
            ],
        ]);

        return $this->render('qty', [
            'dataProvider'  =>  $dataProvider,
            'SelectForm'    =>  $SelectForm,
            'trtype'        =>  $trtype,
            ]);                
    }
 
    public function actionQty()
    {        
        return $this->_Qty('IV');                             
    }
   
    public function actionSalesorderqty()
    {
        return $this->_Qty('SO');         
    }
}
