<?php

namespace app\modules\report\controllers;

use Yii;

use yii\web\Controller;

use app\models\SelectForm;
use yii\data\ArrayDataProvider;

// -----------------------------------------------------------------
// -----------------------------------------------------------------
// -----------------------------------------------------------------
class R8Controller extends Controller
{
     // -------------------------------------------------------------------------------
     public function actionUpdate()
     // -------------------------------------------------------------------------------
     {
        \Yii::$app->runAction('salesinfo/update'); 
     }

    public function actionIndex()
    {




        $base_sql = "
        declare @year1 int 
        declare @month1 int
        declare @date1 date
        declare @CompanyCode varchar(10)
        
        set @CompanyCode='GPM'
        
        set @year1 = 2019
        set @month1 = 7
        
        set @year1 = :year
        set @month1 = :month        
        
        set @date1 = cast (cast((@year1*10000)+(@month1*100)+1 as varchar) as date)
        
        -----------------------------------------------------------------------
        --  item group 
        -----------------------------------------------------------------------
        select a.rgroup, a.rname  -- AAA
            ,sum(a.onhand_est_kg) as onhand_est_kg            
            ,sum(a.onhand_est_kg) as onhand_est_kg
            ,sum(a.onhand_amt) as onhand_amt
            ,sum(a.prod_est_kg) as prod_est_kg
            ,sum(a.prod_repack_est_kg) as prod_repack_est_kg
            ,sum(a.sales_est_kg) as sales_est_kg
            ,sum(a.sales_amt) as sales_amt
        -- select * --BBB
        
        
        from (	 
            
            select 
                isnull(b.rgroup,'R9') as rgroup	,isnull(b.rname,'ETHANOL ('+CONVERT( VARCHAR, @date1, 105 )+')') as rname
                --b.rgroup,b.rname	
                ,a.item_number
                ,a.Item_Name		 		
                
                ,c.qty_onhand * a.pack *a.packsize*  case when d.Factor<1 then d.Factor else 1 end  as onhand_est_kg
                -- ,c.qty_onhand_amt as onhand_amt
                 ,case when a.Item_Number in ('R0100') then c.qty_onhand_amt else null end as onhand_amt
                 
                ,pd.qty_prod * a.pack *a.packsize*  case when d.Factor<1 then d.Factor else 1 end  as prod_est_kg
                ,pd.qty_prod_repack * a.pack *a.packsize*  case when d.Factor<1 then d.Factor else 1 end  as prod_repack_est_kg
                ,sa.qty_sales * a.pack *a.packsize*  case when d.Factor<1 then d.Factor else 1 end  as sales_est_kg
                ,sa.amt_sales as sales_amt
             
                
                -- for ref.....AAAAAAAAAAAAAA
                -- ,c.amt as onhand_amt
                -- ,c.qty_onhand,sa.qty_sales,pd.qty_prod
                -- ,a.pack,a.packsize,a.packuom,d.Factor
                --,d.*
                -- for ref.....BBBBBBBBBBBBBBB		 
            from item a
            left join (
                values
                ('R1','01','13','01', 'สบู่และเครื่องบำรุงผิว'),
                ('R2','01','11','01', 'ยาสีฟัน'),
                ('R3','01','12','*' , 'ยาสระผม'),
                ('R4','01','11','02', 'น้ำยาบ้วนปาก')
            ) b (rgroup, Type_Invent_Code, Group_Product, Product,rname) on a.Type_Invent_Code=b.Type_Invent_Code
                and a.Group_Product=b.Group_Product
                and (a.Product=b.Product or (b.Product='*'))
            left join (
                -----------------------------------------------------------------------
                --  qty on hand AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                -----------------------------------------------------------------------	
                select a.Item_Number,sum(a.qty) as qty_onhand ,sum(a.qty*a.UnitPrice) as qty_onhand_amt
                from (
                    -- AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                    -- detail view here -------------------------------------------------
                    select 
                        a.Item_Number
                        ,a.Ana_No
                        ,a.qty
                        ,b.UnitPrice
                    from (
                        select 
                            a.Item_Number
                            ,a.Ana_No
                            ,sum(isnull(recv_qty,0)-isnull(issue_qty,0)) as qty
                        from (
                            ---------------------------------------------------
                            ------------ query from erp->ABC
                            --------------------------------------------------- 				
                            Select Item.Item_Number
                            -- ,Item.Item_Name,Item.Uom,
                            -- StHead.DocType,StHead.DocDate,
                            ,StCard.Ana_No,StCard.Recv_Qty,StCard.Issue_Qty
                            -- ,StCard.UnitPrice,StCard.SumPrice
                            From Item
                            Left Join StCard On Item.Item_Number=StCard.Item_Number
                            Left Join StHead On StHead.CompanyCode=StCard.CompanyCode
                            And StHead.DocType=StCard.DocType
                            And StHead.VoucherNo=StCard.VoucherNo
                            Where Item.Item_Type='1'
                            And StHead.CompanyCode=@CompanyCode
                            And cast (StHead.DocDate as date ) <= @date1
        
                        )a 	group by a.Item_Number,a.Ana_No
                    )a left JOIN ItemLoc b on a.item_number=b.Item_Number and a.ana_no=b.ana_no
                    where a.qty <> 0
                    -- detail view here -------------------------------------------------
                    -- BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBb	
                    
                )a 	
                group by a.Item_Number
                -----------------------------------------------------------------------
                --  qty on hand BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
                -----------------------------------------------------------------------	
                
            ) c on a.Item_Number = c.item_number
            left join uom d on a.packuom = d.Uom_From
         
            left join ( 	-- -------------Production ------------------ 
                Select StCard.Item_Number 
                ,SUM(case when left(StHead.JobNo,1)<>'J' then  StCard.Recv_Qty else 0 end )  as qty_prod
                ,SUM(case when left(StHead.JobNo,1)= 'J' then  StCard.Recv_Qty else 0 end )  as qty_prod_repack		
                From StCard 
                left join StHead
                    on StCard.CompanyCode=StHead.CompanyCode
                    And StCard.DocType=StHead.DocType
                    And StCard.VoucherNo=StHead.VoucherNo
                where  StHead.CompanyCode=@CompanyCode
                    And StCard.DocType='R2'			
                    and (year(StHead.DocDate) = @year1 and month(StHead.DocDate)=@month1)
                GROUP BY StCard.Item_Number	
            ) pd on a.Item_Number = pd.item_number
            left join (  -- ----------------- SALES -------------------------------
                
                select a.Item_Number,sum(a.qty) as qty_sales,sum(a.amt) as amt_sales from ( --AAA
                    select a.doc_type ,a.doc_no,a.Item_Number,a.qty,a.amt
                    ,c.Item_Name
                    ,c.Type_Invent_Code
                    ,c.Group_Product
                    ,c.Product
                    ,b.rgroup
                    ,c.pack ,c.packsize  
                    from x_salesinfo a 
                    left join item c on a.Item_Number=c.item_number
                        left join (
                            select  'R1'as rgroup,'01' as Type_Invent_Code, '13' as Group_Product,'01' as Product,'สบู่และเครื่องบำรุงผิว' as rname
                            union select 'R2','01','11','01', 'ยาสีฟัน'
                            union select 'R3','01','12','*', 'ยาสระผม'
                            union select 'R4','01','11','02','น้ำยาบ้วนบาก'
                        ) b on c.Type_Invent_Code=b.Type_Invent_Code
                            and c.Group_Product=b.Group_Product
                            and (c.Product=b.Product or (b.Product='*'))
                    where (a.tryear= @year1 and a.trmonth=@month1)	 
                    and b.rgroup is not null
                )a group by a.item_number -- AAA
                --order by a.doc_type,a.doc_no,a.item_number -- BBB
            
            ) sa on  a.Item_Number = sa.item_number
            
            
            where ( (b.rgroup is not null) or a.Item_Number in ('R0100'))
            and not ((c.qty_onhand = 0 and pd.qty_prod = 0 and pd.qty_prod_repack = 0 and sa.qty_sales = 0))
        
        )a  
        
        
        group by a.rname,a.rgroup order by a.rgroup -- AAA
        -- order by a.rgroup -- BBB
         
        
        ";


        $SelectForm = new SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year'];
            $SelectForm->month  = Yii::$app->request->queryParams['SelectForm']['month'];
        } else {
            $SelectForm->year   = date("Y");
            $SelectForm->month  = date("n");
        }

        $sql = $base_sql;
        //$sql="select * from tr ";
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $command->bindParam(":year", $SelectForm->year);
        $command->bindParam(":month", $SelectForm->month);

        $rows = $command->queryAll();





        // onhand_est_kg
        // onhand_amt
        // prod_est_kg
        // prod_repack_est_kg
        // sales_est_kg
        // sales_amt


        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            // 'pagination'=>[
            //     'pageSize'=>50,
            // ],

        ]);

        // $query = Tr::find();
        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        // ]);
        // $query->select('rname,sum(onhand_est_kg) as sum_onhand_est_kg');
        // $query->groupby('rname');        
        return $this->render('index', [

            'dataProvider'  => $dataProvider,
            'SelectForm' => $SelectForm,
        ]);
    }
}
