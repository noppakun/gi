<?php
namespace app\modules\dbma\controllers;
use Yii;

 
class ItemLocController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\ItemLoc';    
 

    public function init()  
    {
        parent::init();
        
 

        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'Item_Number',
            'WhCode',
            'Location_number',
            'Ana_No',
            'Ana_Qty',
            // 'Mfg_Date',
            'Exp_Date',
            // 'Issue',
            // 'Receipt',
            'Status',
            'UnitPrice',
            // 'SumPrice',
            // 'Bin',
            // 'Quarantine',
            // 'Remark',
            // 'Remark_General',
            // 'LastTest_Date',
            // 'SaleReserved',
            // 'EffectiveDate',
            // 'Waste_Qty',
            // 'Defective_Qty',
            // 'Good_Qty',
            // 'LastUpdateBin',
            // 'NotIssueQty',
            // 'ReportNo',
            // 'loc_typ',
            // 'St_qty',
             
        ];

        
    }
 
}
