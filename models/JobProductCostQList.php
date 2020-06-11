<?php

namespace app\models;;

use yii\data\SqlDataProvider;
use yii\base\Model;



class JobProductCostQList extends Model
{
    /* your calculated attribute */
    public $Order_No;
    public $JobNo;
    public $JobDate;
    public $Item_Number;
    public $Item_Name;
    public $JobQty;
    public $lastReceiveDate;




    /* setup rules */
    public function rules()
    {
        return [
            /* your other rules */
            [['Order_No', 'JobNo', 'JobDate', 'Item_Number', 'Item_Name', 'JobQty', 'lastReceiveDate'], 'safe'],
        ];
    }


    //.....................................................
    //************************************************************************************
    function sqlWPlan()
    {
        //************************************************************************************
        return  "
            select * from (
                select a.* ,b.lastReceiveDate from (
                    Select A.JobNo,A.JobDate,B.Order_No,B.Item_Number,B.JobQty,C.Item_Name,B.SaveJobProductCost
                        ,B.JobStatus,b.Rlse_Qty
                        From WPlan A,WPlanDet B
                        Left Join Item C On B.Item_Number=C.Item_Number
                    Where A.JobNo=B.JobNo
                        And (B.JobStatus='O' or B.JobStatus='C')
                
                    Union
                
                    Select A.JobNo,A.JobDate,C.Order_No,C.Component,C.JobQty,D.Item_Name,C.SaveJobProductCost
                        ,B.JobStatus,b.Rlse_Qty
                        From WPlan A,WPlanDet B,WplanSubDet C
                        Left Join Item D On C.Component=D.Item_Number
                    Where A.JobNo=B.JobNo
                        and B.JobNo=C.Jobno and B.Order_No=C.Order_No and B.Item_Number=C.Item_Number
                        And (B.JobStatus='O' or B.JobStatus='C')
                )a   left join (
                    select a.Order_Number,b.Item_Number ,max(cast(a.DocDate as date)) as lastReceiveDate 
                    from StHead a 
                        left join StCard b 
                    on a.CompanyCode=b.CompanyCode and a.DocType=b.DocType and a.VoucherNo=b.VoucherNo
                    where a.DocType = 'R2'
                    group by  a.Order_Number,b.Item_Number
                )b on a.Order_No=b.Order_Number and a.Item_Number=b.Item_Number            
            )a
            where 1=1 

        ";
    }
    //************************************************************************************
    public function QueryWPlan4CalVariableCost()
    //************************************************************************************
    {


        $sql = "select  a.JobNo,a.Order_No,a.Item_Number from ("
            . $this->sqlWPlan()
            . " 
            AND  SaveJobProductCost = 1            
            )A left join x_item_ext_vcost b on a.Order_No = b.ana_no
            and a.Item_Number = b.Item_Number
            where b.item_number  is null            
            ";


        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);


        return $command->queryAll();
    }
    /**
     * setup search function for filtering and sorting 
     * based on fullName field
     */
    //.....................................................
    function genLike($searchField, &$likeStr)
    {
        //.....................................................
        $likeStr = '';
        $likeParams = [];
        foreach ($searchField as $key => $value) {
            /* $likeStr
                .' and country like :country'
                .' and city like :city'
                .' and longitude like :longitude'; */
                
            if (strpos($value, ':d') == false) { 
                $_v = $value;                
                $_fun = $value;
                $_this_v = $this[$_v];
            } else {                                
                $_v = str_replace(':d','',$value);                                       
                $_fun = 'CONVERT(varchar(10), '.str_replace(':d','',$value).', 105)';                                
                $_this_v = str_replace('/','-',$this[$_v]);                
            }
            if (!empty($this[$_v])) {                    
                $likeStr .= ' and ' . $_fun . ' like :' . $_v;                
                $likeParams[':' . $_v] = '%' . $_this_v . '%';
            }


            //$likeStr .= ' and ' . $_fun . ' like :' . $_v;
            //            ->andFilterWhere(['like', 'CONVERT(varchar(10), doc_date, 105)', $this->doc_date]);

            /* $likeParams
                ':country'      => '%'.$this->country.'%',
                ':city'         => '%'.$this->city.'%',
                ':longitude'    => '%'.$this->longitude.'%'
            */
            
        }
        return $likeParams;
    }
    //************************************************************************************
    public function search($params)
    {
        //************************************************************************************
        /*
            if $forCalVariableCost = true
                set pagination = false
        */
        // set params -----
        $this->load($params);


        $likeParams = self::genLike(
            ['Order_No', 'JobNo', 'JobDate:d', 'Item_Number', 'Item_Name', 'JobQty', 'lastReceiveDate:d'],
            $likeStr
        );
        //$likeParams[':JobStatus'] = 'C';       
        // \app\components\XLib::xprint_r($likeStr);
        // \app\components\XLib::xprint_r($likeStr);
        // \app\components\XLib::xprint_r('='.$this['JobDate'].'=');
        // \app\components\XLib::xprint_r(gettype($this['JobDate']));
        
        $sql = $this->sqlWPlan() . $likeStr;


        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => $likeParams,
            'db' => 'erpdb',
            'totalCount' => \Yii::$app->erpdb->createCommand(
                'select count(*) from (' . $sql . ') a',
                $likeParams
            )->queryScalar(),
            'sort' => [
                'attributes' => [
                    'Order_No',
                    'JobNo',
                    'JobDate',
                    'Item_Number',
                    'Item_Name',
                    'JobQty',
                    'Rlse_Qty',
                    'lastReceiveDate'
                ],
                'defaultOrder' => [
                    'Order_No' => SORT_ASC,
                ],
            ],

            'pagination' => [
                'pageSize' => 40,
            ],
        ]);

        return $dataProvider;
    }




    //************************************************************************************
    public function QueryOtherExpense($Order_Number, $Item_Number, $JobNo)
    //************************************************************************************
    {
        /*
            29/1/2018 by pum
                not check companycode for use in GPM and NBO
            1/2/2018 by pum
                check companycode from param

        */
        $sql = "        

            declare @cOrder_No varchar(20)
            declare @cItem_Number varchar(20)
            declare @cJobNo varchar(20)
            declare @cCompanyCode varchar(5)
            
            -- -----------------


            set @cOrder_No ='4280851'
            set @cItem_Number='8850279428416'
            set @cJobNo ='15089'
            -- set @cCompanyCode ='NBO'
                        
            
            set @cOrder_No  = :Order_Number
            set @cItem_Number   = :Item_Number
            set @cJobNo         = :JobNo     
            set @cCompanyCode   = :CompanyCode            
                        

            

            select  isnull( (
                Select SUM(B.SumPrice) From StHead A,StCard B
                Where A.CompanyCode=B.CompanyCode
                And A.DocType=B.DocType
                And A.VoucherNo=B.VoucherNo
                And A.DocType='RD'
                And A.Order_Number=@cOrder_No
                And A.RefDoc=@cItem_Number
                And A.JobNo=@cJobNo
                And A.CompanyCode=@cCompanyCode
            ) - isnull(
                (
                    Select SUM(B.Amount) From StHead A,APCN B
                    Where A.CompanyCode=B.CompanyCode
                    And A.DocType=B.DocType
                    And A.VoucherNo=B.VoucherNo
                    And A.DocType='RD'
                    And A.Order_Number=@cOrder_No
                    And A.RefDoc=@cItem_Number
                    And A.JobNo=@cJobNo
                    And A.CompanyCode=@cCompanyCode
                ),0
            ),0)  as OtherExpense           
        ";


        $CompanyCode = \Yii::$app->params['comp_code'];

        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);

        $command->bindParam(":Order_Number", $Order_Number);
        $command->bindParam(":Item_Number", $Item_Number);
        $command->bindParam(":JobNo", $JobNo);
        $command->bindParam(":CompanyCode", $CompanyCode);

        return $command->queryOne();
    }

    //************************************************************************************
    public function QueryWPlanDet($Order_Number, $Item_Number, $JobNo)
    //************************************************************************************
    {
        $connection = \Yii::$app->erpdb;
        $CompanyCode = \Yii::$app->params['comp_code'];
        // ---------------------------------------------------------------------       
        $sqlWPlanDet = "select * from xeJobCost (:Order_Number ,:Item_Number,:JobNo,:CompanyCode)";


        $command = $connection->createCommand($sqlWPlanDet);

        $command->bindParam(":Order_Number", $Order_Number);
        $command->bindParam(":Item_Number", $Item_Number);
        $command->bindParam(":JobNo", $JobNo);
        $command->bindParam(":CompanyCode", $CompanyCode);
        return $command->queryOne();
    }



    //************************************************************************************
    public function QueryItems($Order_Number, $Item_Number, $JobNo, $StCardINO)
    //************************************************************************************
    {


        $sql = "
            select a.* ,isnull(b.calFixedCost,0) as calFixedCost
            from xeJobCostItems (:Order_Number, :Item_Number,  :JobNo,  :StCardINO) a
            left join xeJobCost (:Order_Number2 ,'*',:JobNo2,'GPM') b
            on a.Item_Number=b.Item_Number
        ";
        $sql = "
            

            declare @Order_Number varchar(20)
            declare @Item_Number varchar(20)
            declare @JobNo varchar(20)						
            declare @StCardINO varchar(20)	
            
            set @Order_Number = :Order_Number
            set @Item_Number= :Item_Number
            set @JobNo = :JobNo
            set @StCardINO =  :StCardINO                       
                          
/*
					
						

            set @Order_Number ='681001.'
            set @Item_Number='8850279681200'
            set @JobNo ='J16026'
            set @StCardINO = '*'

            set @Order_Number ='411090'
            set @Item_Number='8850279411487'
            set @JobNo ='15267'
            set @StCardINO = '*'                       
            -- set @StCardINO = 'C41101'


*/            
            
            select 	a.*         
                ,(isnull(b.calFixedCostPerLot,0)/b.Rlse_Qty)*a.Issue_Qty as calFixedCost   
            --   ,b.*     
            from 
                xeJobCostItems (@Order_Number, @Item_Number,  @JobNo,  @StCardINO) a
            left join (
                            select a.*

                            from (
                                    select a.*
                                            ,case when a.SaveJobProductCost=1 then
                                                            a.Job_QtyFixedCost*a.W_FixedCost                             
                                                    else
                                                            a.JobQty*a.Pack*a.PackSize*a.FixedCost                             
                                                    end as calFixedCostPerLot
                                    from (                    
                                            --------------------------- 
                                            -- original sql start here
                                            -- ERP\GPM\Enterprise\ManagerialAcc\ActualProductCosting\FrmShowJobProductCost\QRWPlanDet
                                            ---------------------------
                                            Select A.JobNo,B.Order_No,B.Item_Number,B.JobQty,B.Rlse_Qty
                                                    , isnull(b.ManHour_W,0) +isnull(b.ManHour_C,0) +isnull(b.ManHour,0) as ManHour,
                                                    B.DirectLabor W_DirectLabor,B.VariableCost W_VariableCost,B.FixedCost W_FixedCost,B.Job_QtyFixedCost,B.SaveJobProductCost,B.Job_QtyFixedCostUom,
                                                    C.Item_Name,C.Pack,C.PackSize,C.PackUom,C.VariableCost,C.FixedCost,C.Source,D.DirectLabor,C.UOM
                                            From WPlan A,Company D,WPlanDet B
                                            Left Join Item C On B.Item_Number=C.Item_Number
                                            Where A.JobNo=B.JobNo
                                                    And D.CompanyCode='GPM'

                                            Union

                                            Select A.JobNo,B.Order_No,B.Component,B.JobQty,B.Rlse_Qty,B.ManHour,
                                                    B.DirectLabor,C.VariableCost,B.FixedCost,B.Job_QtyFixedCost,B.SaveJobProductCost,B.Job_QtyFixedCostUom,
                                                    C.Item_Name,C.Pack,C.PackSize,C.PackUom,C.VariableCost,C.FixedCost,C.Source,D.DirectLabor,C.UOM
                                            From WPlan A,Company D,WPlanSubDet B
                                            Left Join Item C On B.Component=C.Item_Number
                                            Where A.JobNo=B.JobNo
                                                    And D.CompanyCode='GPM'
                                    )a
                            )a
            ) b
            on a.Item_Number=b.Item_Number            
--           and a.StCard_Ana_No=b.Order_No
            and a.Order_Number=b.Order_No
            order by a.Type_Invent_Code
                        
        ";



        $connection = \Yii::$app->erpdb;

        $command = $connection->createCommand($sql);
        $command->bindParam(":Order_Number", $Order_Number);
        $command->bindParam(":Item_Number", $Item_Number);
        $command->bindParam(":JobNo", $JobNo);
        $command->bindParam(":StCardINO", $StCardINO);


        return $command->queryAll();
    }
}
