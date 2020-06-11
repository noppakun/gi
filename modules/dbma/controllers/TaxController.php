<?php
namespace app\modules\dbma\controllers;
use Yii;

class TaxController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\Tax';    
 
    public function init()  
    {
        parent::init();
        
 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
 
            'TaxType',
            'TaxInv',
            'Supp_TaxInv',
            'InvDate',
            'Period',
            // 'Late',
            // 'CsCode',
            // 'Amount1',
            // 'Vat1',
            // 'Amount2',
            // 'Vat2',
            // 'Amount3',
            // 'Remark1',
            // 'Remark2',
            // 'DocType',
            // 'CompanyCode',
            'VoucherNo',
            // 'UserName',
            // 'LastUpdate',
            // 'Cust_no',
            // 'supp_number',
            // 'Supp_Name',
            // 'TaxId',
            // 'BranchCode',
            // 'Vat_Ch',
        ];
    }
  
}
 