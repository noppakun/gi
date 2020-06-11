<?php
namespace app\modules\dbma\controllers;
use Yii;


class StCardController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\StCard';    
 
    public function init()  
    {
        parent::init();
        
 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
 
            'CompanyCode',
            'DocType',
            'VoucherNo',
            'Item_Number',
            'WhCode',
            //'Location',
            'Ana_No',
            //'Item_Desc',
            'Recv_Qty',
            'Issue_Qty',
            //'UnitPrice',
            //'SumPrice',
            //'AccountCode',
            //'CsCode',
            //'Status',
            //'Batch',
            //'TimeRecord',
            //'UserName',
            'WorkStart',
            //'WorkStop',
            //'QA_StartDateTime',
            //'QA_StopDateTime',
            //'QA_MachCode',
            //'QA_ApvDate',
            //'MachCode',
            //'Item_Uom',
            //'WantQCDate',
            //'EmployeeCode',
            //'Checker_Status',
            //'Tare_Weight',
            //'KpiDte2',
            //'KpiDte1',
        ];
    }
  
}
 