<?php

namespace app\models;

use Yii;
 
/**
 * This is the model class for table "WPlanDet".
 *
 * @property string $JobNo
 * @property string $Order_No
 * @property string $Item_Number
 * @property string $JobQty
 * @property string $StartDateTime
 * @property string $StopDateTime
 * @property string $Priority
 * @property string $JobStatus
 *      I 'IDLE'
 *      P 'PLAN'
 *      O 'OPEN'
 *      C 'CLOSE'
 *      W 'WAITING'
 * @property string $Rlse_Qty
 * @property string $Rlse_Date
 * @property string $Item_Type
 * @property string $ProcessRemark
 * @property string $TransferRecord1
 * @property string $TransferRecord2
 * @property string $TransferRecord3
 * @property string $EffectiveDate
 * @property string $MachCode
 * @property string $ReleasedNo
 * @property string $RealStartDateTime
 * @property string $RealStopDateTime
 * @property integer $Operators
 * @property string $HourPaid
 * @property string $ManHour
 * @property string $UserName
 * @property string $Certificate
 * @property string $Conclusion
 * @property string $Remark
 * @property string $JobRemark
 * @property integer $PrintJob
 * @property string $QA_StartDateTime
 * @property string $QA_StopDateTime
 * @property string $QA_MachCode
 * @property string $Formula_No
 * @property string $LastUpdateSchedule
 * @property string $StopDateTimeIncludeClearDoc
 * @property string $DirectLabor
 * @property string $VariableCost
 * @property string $FixedCost
 * @property integer $ConfirmSchedule
 * @property string $Job_QtyFixedCost
 * @property integer $SaveJobProductCost
 * @property string $Job_QtyFixedCostUom
 * @property string $Remark2
 * @property integer $Operators_W
 * @property string $HourPaid_W
 * @property string $ManHour_W
 * @property integer $Operators_C
 * @property string $HourPaid_C
 * @property string $ManHour_C
 * @property string $PrintDocStatus
 */
 
class WPlanDet extends \yii\db\ActiveRecord
{
    // ----------------------------------------------------
    // รายการเบิกออกเพื่อการผลิต
    public function getCompoundIssue()
    // ----------------------------------------------------
    { 
        $sql = "
                    
            declare @cCode varchar(20)
            declare @order_no varchar(20)
            declare @compound_code    varchar(20)
            
            set @cCode = '8850279467217'
            set @order_no='467140'
    
            
            set @cCode      =   :item_number
            set @order_no   =   :order_no
            set @compound_code    = :compound_code    
            select b.item_number
            ,sum(isnull(b.issue_qty,0)-isnull(b.recv_Qty,0)) as q_issue
            from sthead a
            left join stcard b
                on a.CompanyCode = b.CompanyCode
                and a.DocType = b.DocType
                and a.VoucherNo = b.VoucherNo
            left join item c on c.item_number = b.item_number
            where a.DocType in ('I1','IA') 
            and c.type_invent_code='03'
            and a.Order_Number=@order_no    
            and a.RefDoc=@cCode 
            and b.item_number  =  @compound_code    
            group by b.item_number    

        ";

        $order_no = $this->Order_No;
        $item_number = $this->Item_Number;
        $Compound = WPlanDet::findOne(['Order_No'=>$order_no,'Item_Type'=>'B']);        
        // ***** job repack with out component *****
        if ($Compound !== null){
            $compound_code = $Compound->Item_Number;
            // $compound_code = (WPlanDet::findOne(['Order_No'=>$order_no,'Item_Type'=>'B']))->Item_Number;

            
            $connection = \Yii::$app->erpdb;
            $command = $connection->createCommand($sql);
            
            $command->bindParam(":order_no",$order_no);   
            $command->bindParam(":item_number",$item_number); 
            $command->bindParam(":compound_code",$compound_code); 
            

            $rows = $command->queryAll();
            $ret = isset($rows[0]['q_issue'])?$rows[0]['q_issue']:null;
        }else{
            $ret = null;
        } 
    
        return $ret;


    } 

    // ----------------------------------------------------
    public function getXWplandetExt()
    // ----------------------------------------------------
    { 
        return $this->hasOne(XWplandetExt::className(), [
            'item_Number' => 'Item_Number',
            'order_no'=>'Order_No'
            ]);
    } 
        
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['Item_Number' => 'Item_Number']);
    }
    
    // ----------------------------------------------------
    public function XWplandetWasteSumQty($component=null){
    // ----------------------------------------------------
        return XWplandetWaste::find()
        ->andFilterWhere([
            'order_no' => $this->Order_No,
            'item_number' => $this->Item_Number,            
            'component'=>$component,
        ])->sum('qty');
 
    }
    // ----------------------------------------------------
    public function XWplandetWaste($component=null){
        // ----------------------------------------------------
        $where = [
            'order_no' => $this->Order_No,
            'item_number' => $this->Item_Number,                                    
        ];
        if ($component!==null){
            $where['component'] = $component; 
        }        
        return XWplandetWaste::find()
            ->andFilterWhere($where);
     
    }
    
    // // ----------------------------------------------------
    // public function getBomBatchFormNo()
    // // ----------------------------------------------------
    // { 
    //     return $this->hasOne(BomBatchFormNo::className(), [
    //         'Assembly' => 'Item_Number',
    //         'StandardBatchSize'=>'JobQty'
    //         ]);
    // }
    // ----------------------------------------------------
    public function getBom()
    // ----------------------------------------------------
    { 
        return $this->hasOne(Bom::className(), ['Assembly' => 'Item_Number']);
    }
    // ----------------------------------------------------
    public function getItemLoc()
    // ----------------------------------------------------
    { 
        return $this->hasOne(ItemLoc::className(), [
            'Item_Number' => 'Item_Number',
            'Ana_No'=>'Order_No'
            ]);
    }    
    // // ----------------------------------------------------
    // public function getBomDetBatch()
    // // ----------------------------------------------------
    // { 
    //     return $this->hasMany(BomDetBatch::className(), [
    //         'Assembly' => 'Item_Number',
    //         'StandardBatchSize'=>'JobQty'
    //         ]);
    // }
    // ----------------------------------------------------
    public function packaging_materials_usage()
    // ----------------------------------------------------
    { 
        $sql = "
                    
        declare @cCode varchar(20)
        declare @order_no varchar(20)
        set @cCode = '8850279467217'
        set @order_no='467140'
        
        set @cCode = '8850279427723'
        set @order_no='427168'
        
        set @cCode = '8850279478251'
        set @order_no='478039'
        
        set @cCode      =   :item_number
        set @order_no   =   :order_no
        
        
        Select A.Component
            ,Item.Item_Name,Item.Uom            
            -- ต้องใช้ยอดเบิกจริง เนื่องจากในการทำงานจริง ต้องเขียนแก้ใน report erp 13/2/2019                     
            -- เช็คใน view  'label' => 'REQUESTED',
             ,A.Qty as requested

            ,b.q_issue-a.qty as added
            ,b.q_returned as returned
            --,b.q_issue

            -- ---- used ---------------AAAAAAAAAAAAAAAAAAAAAAa
            /*
            ,case when (b.q_issue - b.q_returned) - round((a.qty/w.jobqty*w.Rlse_Qty),0) < 0 then
                    -- v.1
                    -- b.q_issue- b.q_returned 
                    -- v.2 by nui 6/2/2019
                    b.q_issue- b.q_returned  - isnull(c.qty_waste,0)                    
                else                    
                    round((a.qty/w.jobqty*w.Rlse_Qty),2) 
                end as used	
            */
            -- v3             
            /*
                ***  fix สูตรคำนวน USED จาก นุ้ย     
                USED = REQUESTED + ADDED - WASTE - RETURNED
            */
            --,b.q_issue - isnull(b.q_returned,0)  - isnull(c.qty_waste,0) as used	            
            -- USED = REQUESTED(a.qty) + ADDED (b.q_issue-a.qty) - WASTE(isnull(c.qty_waste,0)) - RETURNED(isnull(b.q_returned,0))            
            ,         a.qty            + (b.q_issue-a.qty)       - isnull(b.q_returned,0)  - isnull(c.qty_waste,0) as used	            
            
            
                    
            -- ---- used ---------------BBBBBBBBBBBBBBBBBBBBBBBBB

            ,case when (b.q_issue - b.q_returned) - round((a.qty/w.jobqty*w.Rlse_Qty),0) < 0 then
                    0
                else
                    (b.q_issue - b.q_returned) - round((a.qty/w.jobqty*w.Rlse_Qty),0)
                end as waste		
            ,isnull(c.qty_waste,0) as qty_waste
             
        From wplandet w  
        /*
            v.1
                left join BomDetBatch  A
            v.2 8/2/2019
                use bom from x_wplan_bomdetbatch 
                (x_wplan_bomdetbatch create on gi action batch-packing-record/view)
        */
        left join x_wplan_bomdetbatch  A
            on  (w.item_number=a.Assembly)	and (w.jobqty=A.StandardBatchSize) and (w.jobno=a.jobno)
        left join Item on  A.Component=Item.Item_Number
        -- ------- stock movement -------- AAAAAAAAAAAAA
        left join (   
            select b.item_number
            ,sum(case when a.DocType in ('I1','IA') then isnull(b.issue_qty,0)-isnull(b.recv_Qty,0) else 0 end) as q_issue
            ,- sum(case when a.DocType in ('R3','RA') then isnull(b.issue_qty,0)-isnull(b.recv_Qty,0) else 0 end) as q_returned
            from sthead a
            left join stcard b
                on a.CompanyCode = b.CompanyCode
                and a.DocType = b.DocType
                and a.VoucherNo = b.VoucherNo
            where a.Order_Number=@order_no
            and a.RefDoc=@cCode	    
            group by b.item_number
        )b on a.Component=b.Item_Number
        -- ----- BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
        left join (  
            select a.component,sum(a.qty) as qty_waste
            from x_wplandet_waste a
            where a.order_no=@order_no
            and a.item_number=@cCode	                
            group by a.component
        ) c on a.Component=c.component
        Where w.Order_No=@order_no
            and w.item_number=@cCode        

        ";

        $order_no = $this->Order_No;
        $item_number = $this->Item_Number;

            
        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);
        
        $command->bindParam(":order_no",$order_no);   
        $command->bindParam(":item_number",$item_number); 

        $rows = $command->queryAll();
        //\app\components\XLib::xprint_r($rows); 

        
        return $rows;
        
        
    }    
    // ---------------------------------------------------------------
    public function getPriority_ref()
    {
        return $this->hasOne(XRefdata::className(), ['refcode' => 'Priority'])
        ->onCondition(['reftype' => 'PRI']);                 
    } 
    public function getPriority_TEXT()    {        
        return isset($this->priority_ref->refname)?$this->priority_ref->refname:'N/A'; 
    } 
    // ---------------------------------------------------------------
    public function getJobStatus_ref()
    {
        return $this->hasOne(XRefdata::className(), ['refcode' => 'JobStatus'])
        ->onCondition(['reftype' => 'JST']);                 
    } 
    public function getJobStatus_TEXT()    {        
        return $this->jobStatus_ref->refname; 
    } 

    // ---------------------------------------------------------------
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------
    // ----------------------------------------------------
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'WPlanDet';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('erpdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JobNo', 'Order_No', 'Item_Number', 'JobQty', 'Item_Type'], 'required'],
            [['JobNo', 'Order_No', 'Item_Number', 'Priority', 'JobStatus', 'Item_Type', 'ProcessRemark', 'TransferRecord1', 'TransferRecord2', 'TransferRecord3', 'MachCode', 'ReleasedNo', 'UserName', 'Certificate', 'Conclusion', 'Remark', 'JobRemark', 'QA_MachCode', 'Formula_No', 'Job_QtyFixedCostUom', 'Remark2', 'PrintDocStatus'], 'string'],
            [['JobQty', 'Rlse_Qty', 'HourPaid', 'ManHour', 'DirectLabor', 'VariableCost', 'FixedCost', 'Job_QtyFixedCost', 'HourPaid_W', 'ManHour_W', 'HourPaid_C', 'ManHour_C'], 'number'],
            [['StartDateTime', 'StopDateTime', 'Rlse_Date', 'EffectiveDate', 'RealStartDateTime', 'RealStopDateTime', 'QA_StartDateTime', 'QA_StopDateTime', 'LastUpdateSchedule', 'StopDateTimeIncludeClearDoc'], 'safe'],
            [['Operators', 'PrintJob', 'ConfirmSchedule', 'SaveJobProductCost', 'Operators_W', 'Operators_C'], 'integer'],
          //  [['Item_Name'], 'string'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'JobNo' => 'Job No',
            'Order_No' => 'Order  No',
            'Item_Number' => 'Item  Number',
            'JobQty' => 'จำนวนสั่งผลิต',
            'StartDateTime' => 'Start Date Time',
            'StopDateTime' => 'Stop Date Time',
            'Priority' => 'Priority',
            'JobStatus' => 'Job Status',
            'Rlse_Qty' => 'จำนวนที่ผลิตได้',
            'Rlse_Date' => 'Rlse  Date',
            'Item_Type' => 'Item  Type',
            'ProcessRemark' => 'Process Remark',
            'TransferRecord1' => 'Transfer Record1',
            'TransferRecord2' => 'Transfer Record2',
            'TransferRecord3' => 'Transfer Record3',
            'EffectiveDate' => 'Effective Date',
            'MachCode' => 'Mach Code',
            'ReleasedNo' => 'Released No',
            'RealStartDateTime' => 'เริ่มผลิตจริง',
            'RealStopDateTime' => 'ผลิตเสร็จจริง',
            'Operators' => 'Operators',
            'HourPaid' => 'Hour Paid',
            'ManHour' => 'Man Hour',
            'UserName' => 'User Name',
            'Certificate' => 'Certificate',
            'Conclusion' => 'Conclusion',
            'Remark' => 'Remark',
            'JobRemark' => 'Job Remark',
            'PrintJob' => 'Print Job',
            'QA_StartDateTime' => 'Qa  Start Date Time',
            'QA_StopDateTime' => 'Qa  Stop Date Time',
            'QA_MachCode' => 'Qa  Mach Code',
            'Formula_No' => 'Formula  No',
            'LastUpdateSchedule' => 'Last Update Schedule',
            'StopDateTimeIncludeClearDoc' => 'Stop Date Time Include Clear Doc',
            'DirectLabor' => 'Direct Labor',
            'VariableCost' => 'Variable Cost',
            'FixedCost' => 'Fixed Cost',
            'ConfirmSchedule' => 'Confirm Schedule',
            'Job_QtyFixedCost' => 'Job  Qty Fixed Cost',
            'SaveJobProductCost' => 'Save Job Product Cost',
            'Job_QtyFixedCostUom' => 'Job  Qty Fixed Cost Uom',
            'Remark2' => 'Remark2',
            'Operators_W' => 'Operators  W',
            'HourPaid_W' => 'Hour Paid  W',
            'ManHour_W' => 'Man Hour  W',
            'Operators_C' => 'Operators  C',
            'HourPaid_C' => 'Hour Paid  C',
            'ManHour_C' => 'Man Hour  C',
            'PrintDocStatus' => 'Print Doc Status',
            // ----------------------------------------------
            'jobStatus_TEXT'=>'Status',
            'priority_TEXT'=>'Priority',
        ];
    }
}
