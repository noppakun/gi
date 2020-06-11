<?php
namespace app\modules\dbma\controllers;
use Yii;


class DockController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\Dock';    
    
    public function init()  
    {    
        parent::init(); 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [
            'Dock_Number',
            'CompanyCode',
            'VoucherNo',
            'Do_Number',
            'Order_Number',
            'Item_Number',
            // 'Vessel',
            // 'Awb',
            // 'Inv',
            // 'Inv_Date',
            // 'Recd_Qty',
            // 'Acc_Qty',
            'Mfg_date',
            'Exp_Date',
            // 'Rej_Qty',
            // 'Due_Date',
            // 'Recd_Date',
            // 'Acc_Date',
            // 'WhCode',
            // 'Loc_Number',
            'Ana_No',
            // 'Uom',
            // 'Supplier_Lot',
            // 'UnitPrice',
            // 'SumPrice',
            // 'Remark',
            // 'PackDetail',
            // 'Dock_Print',
            // 'Dock_Status',
            // 'Seq_Number',
            // 'UserName',
            // 'Remark_Approve',
            // 'QA_StartDateTime',
            // 'QA_StopDateTime',
            // 'QA_MachCode',
            // 'EffectiveDate',
            // 'RecvDocDate',
            // 'BranchCode',
            // 'SpecNo',
            // 'UserName_Approve',
            // 'Score',
            // 'Score_PH',
            // 'Kpidte1',
            // 'KpiDte2',         
        ];
    }     
}

