<?php

namespace app\modules\report\controllers;

use Yii;

use yii\web\Controller;

use app\models\SelectForm;
use yii\data\ArrayDataProvider;

// -----------------------------------------------------------------
// -----------------------------------------------------------------
// -----------------------------------------------------------------
class NewitemreceiveController extends Controller
{
 

    public function actionIndex()
    {




        $base_sql = "
 
        
     
        declare @year1 int
        declare @month1 int
        set @year1 = 2019
        set @month1 = 8

        set @year1 = :year
        set @month1 = :month           
        
        select b.Item_Number,c.Item_Name
            ,a.VoucherNo,a.DocDate
            ,b.Ana_No, b.Recv_Qty
        from sthead a
        left join StCard b on a.CompanyCode=b.CompanyCode
            and a.DocType=b.DocType
            and a.VoucherNo=b.VoucherNo
        left join item c on b.Item_Number=c.Item_Number	
        where year(a.DocDate)*100+month(a.DocDate) = @year1*100+@month1	
            and a.DocType in ('R1','R8')
            and c.Type_Invent_Code in ('05')
            and b.Item_Number not in (
                select distinct b.Item_Number
                    from sthead a
                    left join StCard b on a.CompanyCode=b.CompanyCode
                        and a.DocType=b.DocType				
                        and a.VoucherNo=b.VoucherNo
                    left join item c on b.Item_Number=c.Item_Number					
                    where (year(a.DocDate)*100+month(a.DocDate)) < (@year1*100+@month1)
                        and a.DocType in ('R1','R8')
                        and c.Type_Invent_Code in ('05')	
            )
        order by b.Item_Number,b.Item_Desc
            ,a.DocDate,a.VoucherNo
        
        
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
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $command->bindParam(":year", $SelectForm->year);
        $command->bindParam(":month", $SelectForm->month);

        $rows = $command->queryAll();

 


        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            // 'pagination'=>[
            //     'pageSize'=>50,
            // ],

        ]);

       
        return $this->render('index', [

            'dataProvider'  => $dataProvider,
            'SelectForm' => $SelectForm,
        ]);
    }
}
