<?php
namespace app\modules\dbma\controllers;
use Yii;

class WplandetController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\WPlanDet';    
 
    public function init()  
    {
        parent::init();
        
 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
 
            'JobNo',
            [
                'attribute'=>'Order_No',
                'label'=>'Order_No / Ana_No'
            ],
            'Item_Number',
            'JobQty',
            'Rlse_Qty',
            'StartDateTime',
            // 'StopDateTime',
            // 'Priority',
            // 'JobStatus',
            
            // 'Rlse_Date',
            // 'Item_Type',
            // 'ProcessRemark:ntext',
            // 'TransferRecord1',
            // 'TransferRecord2',
            // 'TransferRecord3',
            // 'EffectiveDate',
            'MachCode',
            // 'ReleasedNo',
            // 'RealStartDateTime',
            // 'RealStopDateTime',
            // 'Operators',
            // 'HourPaid',
            // 'ManHour',
            // 'UserName',
            // 'Certificate:ntext',
            // 'Conclusion',
            // 'Remark',
            // 'JobRemark',
            // 'PrintJob',
            // 'QA_StartDateTime',
            // 'QA_StopDateTime',
            // 'QA_MachCode',
            // 'Formula_No',
            // 'LastUpdateSchedule',
            // 'StopDateTimeIncludeClearDoc',
            // 'DirectLabor',
            // 'VariableCost',
            // 'FixedCost',
            // 'ConfirmSchedule',
            // 'Job_QtyFixedCost',
            // 'SaveJobProductCost',
            // 'Job_QtyFixedCostUom',
            // 'Remark2',
            // 'Operators_W',
            // 'HourPaid_W',
            // 'ManHour_W',
            // 'Operators_C',
            // 'HourPaid_C',
            // 'ManHour_C',
            // 'PrintDocStatus',
        ];
    }
  
}
 