<?php

namespace app\modules\report\controllers;

use Yii;

use yii\web\Controller;

use app\models\SelectForm;
use yii\data\ArrayDataProvider;

use app\models\ItemSearch;
// -----------------------------------------------------------------
// -----------------------------------------------------------------
// -----------------------------------------------------------------
class StockController extends Controller
{
 
    private function minimumDetail($item_number)
    {
        $sql = "
            declare @item_number varchar(20)
        
            set @item_number =  '8850279427167'
        
            set @item_number =  :item_number
        

            Select c.* from 
            (
                select 'PO' as doctype, A.Order_Number as doc_no,B.Item_Number,B.Due_Date
                --,B.Order_Qty,B.Rlse_Qty,B.Rej_Qty        
                ,b.Order_Qty-b.Rlse_Qty-b.Rej_Qty as qty          
        
                From PO A,PODetail B
                where 1=1
                --Where B.Item_Number=:cItem_Number        
                And A.CompanyCode=B.CompanyCode
                And A.Order_Number=B.Order_Number
                And A.Open_Close=0 And ((B.Order_Qty>(B.Rlse_Qty-B.Rej_Qty)) or B.Rlse_Qty is null)
                And B.Type_Desc=0
                -- Order By B.Item_Number,B.Due_Date,A.Order_Number
                union        
                

                Select 'PR' as doctype,A.PR_Number  as doc_no,B.Item_Number,B.Due_Date
                --,B.Order_Qty,B.Rlse_Qty
                ,b.Order_Qty-b.Rlse_Qty as qty
                From PR A,PRDetail B
                Where 1=1 
                -- B.Item_Number=:cItem_Number
                And A.CompanyCode=B.CompanyCode
                And A.PR_Number=B.PR_Number
                And A.Open_Close=0 And (B.Order_Qty>B.Rlse_Qty or B.Rlse_Qty is null)
                And A.PO_Issue=0
                And B.Type_Desc=0
                --Order By B.Item_Number,B.Due_Date,A.PR_Number
                    
            )c where c.item_number=@item_number        
            ORDER by c.Due_Date,c.doctype   
        ";
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $command->bindParam(":item_number", $item_number);        

        $rows = $command->queryAll();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            // 'pagination'=>[
            //     'pageSize'=>50,
            // ],
        ]); 
        return $dataProvider;       
    }
    public function actionMinimum()
    { 
       
        $sql = "
            
            /*
                query from FPrintListItem_ReOrderPoint  
            */
            declare @item_number varchar(20)
            declare @item_number2 varchar(20)

            set @item_number =  '8850279427167'
            set @item_number2 = '8850279694552'

            set @item_number =  :item_number
            set @item_number2 = :item_number2


            Select A.Item_Number,A.Item_Name,A.Uom,A.Group_Product
                ,A.Item_type
                ,a.Type_Invent_Code
                ,A.Lot_Size,A.LeadTime,A.Minimum,A.Maximum,A.QtyOnhand,
                A.LastBuyPrice,A.LastBuyDate,A.Supp_Number,B.Supp_Name
            From Item A
            Left Join Supplier B On A.Supp_Number=B.Supp_Number
            
            Where 1=1 
            --and A.Order_Policy='RP' 
            And A.QtyOnhand<=A.Minimum And A.Minimum<>0
            and a.item_number BETWEEN @item_number and @item_number2
            ORDER by a.item_number
                
        
        ";        

        $SelectForm = new SelectForm();
        
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->item_number    = Yii::$app->request->queryParams['SelectForm']['item_number'];
            $SelectForm->item_number2   = Yii::$app->request->queryParams['SelectForm']['item_number2'];
        } else {
            if(isset($_COOKIE['stock_minimum_item_number'])) {                
                $SelectForm->item_number   = $_COOKIE['stock_minimum_item_number'];
                $SelectForm->item_number2  = $_COOKIE['stock_minimum_item_number2'];    
            }else{
                $SelectForm->item_number   = '';
                $SelectForm->item_number2  = '';    
            }    
            //$SelectForm->item_number   = '8850279427167';
            //$SelectForm->item_number2  = '8850279694552';            
        }
        setcookie('stock_minimum_item_number', $SelectForm->item_number);
        setcookie('stock_minimum_item_number2', $SelectForm->item_number2);
      
        
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $command->bindParam(":item_number", $SelectForm->item_number);
        $command->bindParam(":item_number2", $SelectForm->item_number2);

        $rows = $command->queryAll();

        


        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            // 'pagination'=>[
            //     'pageSize'=>50,
            // ],

        ]);
     //\app\components\XLib::xprint_r($dataProvider);
        return $this->render('minimum', [

            'dataProvider'  => $dataProvider,
            'SelectForm' => $SelectForm,
        ]);
    }
}
