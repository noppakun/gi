<?php
namespace app\modules\dbma\controllers;
use Yii;

 
class CnController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\Cn';    
 

    public function init()  
    {
        parent::init();
        
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'CN_Number',
            'CN_Date',
            'Inv_Number',
            'Inv_Date',
            // 'SalesmanCode',
            // 'DivisionCode',
            // 'DeptCode',
            // 'Inv_TotalAmount',
            // 'Inv_Amount',
            // 'Vat_Percent',
            // 'Vat_Amount',
            // 'Remark1',
            // 'Remark2',
            // 'Remark3',
            // 'Adjust_Date',
            // 'Adjust_Many',
            // 'CN_Issue',
            // 'Open_Close',
            'Cust_No',
            // 'Disc_Cash',
            // 'Disc_Percent',
            // 'Disc_Special',
            // 'Disc_Money',
            // 'Amount',
            // 'TotalAmount',
            // 'PaidAmount',
            // 'BranchCode',
            // 'Vat_type',
             
        ];

        
    }
 
}
