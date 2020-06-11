<?php
namespace app\modules\xapi\controllers;

use Yii;
 
use app\models\SelectForm;
use yii\helpers\Html;
use yii\web\Response;
use yii\data\Pagination; 

use app\components\gihelper;
//use app\components\XExport;

class PlanningController extends  \yii\web\Controller
{ 
    // http://gi.greaterman.com/gi/web/index.php?r=xapi/planning/mat-sales-order-getdata
    public function actionMatSalesOrderGetdata($date1=null,$date2=null,$currentPage=1,$rowsPerPage=20)
    {
        
        
  
        $sql='select * from x_matsalesorder';
        $connection = \Yii::$app->erpdb;      
        $command = $connection->createCommand($sql);                
        //$command->bindParam(":date1",$date1);   
        //$command->bindParam(":date2",$date2);   
                                        
        $rows =  $command->queryAll();
        $totalrows=count($rows);
              
 
 
        $pages = new Pagination([
            'totalCount' => count($rows),
            'defaultPageSize'=>$rowsPerPage,
        ]); 
           
 
        $offset = ($currentPage  - 1) * $pages->defaultPageSize;                                
        //$rows = array_slice( $rows, $offset, $pages->defaultPageSize );                
  
            
        // ----------------------------------------
        Yii::$app->response->format = Response::FORMAT_JSON;                    
         return [
            'pages'=>$pages,          
            'rows'=>$rows,
        ];
        //return $date1;
          
    }
 // http://gi.greaterman.com/gi/web/index.php?r=xapi/planning/mat-sales-order
    public function actionMatSalesOrder($date1='20190110',$date2='20190115')
    {
     
       
        $sql = "


        /*
        - skip Due_Date เนื่องจากในใบส่งของไม่มีการระบุ Due_Date
    */
    declare @date1 date
    declare @date2 date
    
    set @date1 = '20190301'
    set @date2 = '20190310'
    
    set @date1 = '20181001'
    set @date2 = '20181024'
    
    
    --                        set @date1 = :date1
    --                        set @date2 = :date2
    -- ------------------------------------------------------
    -- @_salesorder TEMP ***********************************
    -- ------------------------------------------------------
        declare @_salesorder TABLE (
            Sale_Number char(10) COLLATE Thai_CI_AS NOT NULL,
            Sale_Date datetime NOT NULL,
            due_date datetime NULL,
            Item_Number char(20) COLLATE Thai_CI_AS NULL,
            CompoundCode char(20) COLLATE Thai_CI_AS NULL,
            Order_Qty decimal(38,4) NULL
        ) 
        insert into @_salesorder 
        select a.Sale_Number,a.Sale_Date                               	    
            ,min(b.Due_Date) as due_date	                                    
            ,b.Item_Number
            ,c.CompoundCode
            ,sum(b.Order_Qty) as Order_Qty
        -- into #_salesorder
        from sale a
        left join SaleDet b on a.CompanyCode=b.CompanyCode and a.Sale_Number=b.Sale_Number 
        left join Bom c on c.Assembly=b.Item_Number	 
        where b.Sale_Close <>  1
        -- and a.sale_date BETWEEN @date1 and @date2
        group by a.Sale_Number, a.Sale_Date, b.Item_Number, c.CompoundCode
        
    --	drop table tr
        --select * into tr from #_salesorder
    --	
        -- ------- skip Due_Date ----------
        -- ,b.Due_Date   
        -- --------------------------------                            
    -- ------------------------------------------------------
    -- ***************************************************
    -- ------------------------------------------------------
    -- S - T - A - R - T  ---
    drop table x_matsalesorder
    select 
    --	top 100 
        a.sale_number, a.sale_date, a.due_date, a.item_number             
        ,a.item_name				 
        ,a.order_qty
        ,a.qty_send
        ,a.backorder_qty	
        ,a.qtyonhand
        ,a.production_qty	
        ,a.onhand_after_send
        ,a.compoundcode        
        ,a.rtype
        ,a.component           
        ,a.component_name                                 
        ,a.q_bom    
                 
        ,iif(isnull(a.reserve_pcs,0)<>0 
            ,a.q_use+a.reserve_pcs
            ,iif(isnull(a.reserve,0)<>0
                ,a.q_use*(1+(a.reserve/100))
                ,a.q_use
            )
        ) as q_use
        ,a.component_onhand
        ,a.component_quarantine 
        -- --------------
        ,a.reserve,a.reserve_pcs
        ,a.q_use as q_usebeforereserce
        into x_matsalesorder
    from ( 
        select  
            a.sale_number, a.sale_date, a.due_date, a.item_number
            ,b.item_name, b.qtyonhand
            ,a.order_qty
            
            ,isnull(d.qty_send,0) as qty_send
            ,iif(a.order_qty < isnull(d.qty_send,0),0, a.order_qty - isnull(d.qty_send,0)) as backorder_qty	
            ,iif(b.qtyonhand -(a.order_qty-isnull(d.qty_send,0) ) > 0,0,(a.order_qty-isnull(d.qty_send,0) -b.qtyonhand)) as production_qty
            ,iif(b.qtyonhand -(a.order_qty-isnull(d.qty_send,0) ) < 0,0,b.qtyonhand -(a.order_qty-isnull(d.qty_send,0))) as onhand_after_send
                
            ,a.compoundcode, a.rtype, a.component            
            ,c.item_name as component_name                
            ,a.q_bom
            -- --------------------------
             -- ---  q_use
             -- --------------------------	 		
            ,case when  a.rtype = 'P' then                
                iif(b.qtyonhand -(a.order_qty-isnull(d.qty_send,0) ) > 0,0,(a.order_qty-isnull(d.qty_send,0) -b.qtyonhand)) -- as production_qty   		
                    * a.q_bom
                    -- * 1.015 -- PM เผื่อ 1.5%  ( user )
              else  -- a.rtype = 'C'
                iif(b.qtyonhand -(a.order_qty-isnull(d.qty_send,0) ) > 0,0,(a.order_qty-isnull(d.qty_send,0) -b.qtyonhand)) -- as production_qty                        
                    * a.q_bom 
                    * a.Pack * a.PackSize / 1000
                    * iif(a.Density = 0,1,a.Density )
                    -- * 1.02 -- RM เผื่อ 2%  ( user )
            end as q_use	                	
            ,c.qtyonhand as  component_onhand					
            ,e.component_quarantine		
            -- -----------------------
            ,f.reserve,f.reserve_pcs
        from (
            -- ------------------------------------------------------
            -- 	PACKING BOM ( Item_Number )
            -- ------------------------------------------------------
            select a.Sale_Number, a.Sale_Date, a.Due_Date, a.Item_Number, a.CompoundCode, a.Order_Qty
                ,'P' as rtype
                ,d.Component
                ,d.Qty as q_bom
                -- zzz ,a.Order_Qty*d.Qty  as q_use      
                ,0 as Pack,0 as PackSize, 0 as Density                
            from @_salesorder a 
            left join Bom c on c.Assembly=a.Item_Number
            left join BomDet d on d.Assembly=c.Assembly
            
            union  -- ----------------------------------------------------------------------- union
            -- ------------------------------------------------------
            -- 	Bulk BOM ( CompoundCode )                    
            -- ------------------------------------------------------
            select a.Sale_Number, a.Sale_Date, a.Due_Date, a.Item_Number, a.CompoundCode, a.Order_Qty						
                ,'C' as rtype
                ,d.Component
                ,d.Qty as q_bom
                ,e.Pack,e.PackSize, c.Density 
            from @_salesorder a
            left join Bom c on c.Assembly=a.CompoundCode
            left join BomDet d on d.Assembly=c.Assembly
            left join Item e on e.Item_Number=a.Item_Number
        )a
        left join item b on a.item_number=b.Item_Number		-- item
        left join item c on a.component=c.Item_Number   	-- component
         
        -- -------------------------------
        --   ยอดที่ส่งสินค้าแล้ว จาก invoice
        -- -------------------------------
        left join ( 
            select a.Sale_Number
            ,b.Item_Number,sum(b.Order_Qty) as qty_send 
            from invoice a 
            left join InvoiceDet b 
            on a.CompanyCode=b.CompanyCode and a.Inv_Number=b.Inv_Number
            group  by a.Sale_Number ,b.Item_Number                
        ) d on a.Sale_Number=d.sale_number and a.item_number=d.Item_Number
        -- -------------------------------
        --   ยอด component คงเหลือ
        -- -------------------------------    
        left join (
            select item_number
            ,sum(ana_qty) as component_onhand
            ,sum(quarantine) as component_quarantine
            from itemloc
            group by item_number                
        )e on a.component=e.Item_Number
        -- -------------------------------
        --   ยอด reserve
        -- -------------------------------      
        left join (
            select group_product,product,max(reserve) as reserve,reserve_pcs 
            from x_pkg_reserve
            group by group_product,product,reserve_pcs    
        ) f on c.group_product=f.group_product and c.product=f.product
    )a       
        --left join Prod e on a.sale_number=e.Sale_Number
        
    order by a.Due_Date, a.sale_number, a.item_number, a.rtype desc     
                    
     --       order by a.component
     -- drop table #_salesorder
    
    select * from x_matsalesorder           
            ";
 
        $sql='select * from x_matsalesorder';
        $connection = \Yii::$app->erpdb;      
        $command = $connection->createCommand($sql);                
        //$command->bindParam(":date1",$date1);   
        //$command->bindParam(":date2",$date2);   
                                        
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
      
                
         
        $filename ='MatSalesOrder_'
            .\app\components\XLib::dateConv($date1,'a').'-'
            .\app\components\XLib::dateConv($date2,'a').'.xls'; 
        
        $options = [
            'columns'=>[                             
                'sale_date'=>[
                    'DateFormat'=>'dd-mm-yyyy'
                ],
                'due_date'=>[
                    'DateFormat'=>'dd-mm-yyyy'
                ],

                'order_qty'=>[
                    'NumberFormat'=>'#,##0'
                ],
                'qty_send'	        =>  ['NumberFormat'=>'#,##0.00'],
                'backorder_qty'	    =>  ['NumberFormat'=>'#,##0.00'],
                'qtyonhand'	        =>  ['NumberFormat'=>'#,##0.00'],
                'production_qty'	=>  ['NumberFormat'=>'#,##0.00'],
                'onhand_after_send' =>  ['NumberFormat'=>'#,##0.00'],
                'q_bom' =>  ['NumberFormat'=>'#,##0.000'],
                'q_use' =>  ['NumberFormat'=>'#,##0.000'],
                'component_qnhand'      =>  ['NumberFormat'=>'#,##0.000'],	
                'component_quarantine'  =>  ['NumberFormat'=>'#,##0.000'],

            ]
        ];
        //$options = [];
    
        
        \app\components\XExport::x2xls($rows,$filename,$options);	

        return $this->redirect($filename);          
    }
     
   
}
 
 