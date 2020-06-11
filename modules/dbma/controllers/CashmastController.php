<?php
namespace app\modules\dbma\controllers;
use Yii;
 
class CashmastController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\CashMast';    
 

    public function init()  
    {
        parent::init();
        $this->VIEWPARA['XQEDIT']['index_text_before']='<div class="alert alert-info" role="alert">Type > CR:เงินสด  RO:อื่นๆ</div>';

        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'Type',
            'VoucherNo',
            'VoucherDate',
            'Supp_Number',
            'Cust_No',
            // 'Discount',
            // 'PaymentWithHoldingTax',
            // 'Remark',
            // 'TotalAmount',
            // 'ChqTotalAmount',
            // 'GIncome_Code',
            // 'GExpend_Code',
            // 'Income_Code',
            // 'Expend_Code',
            // 'CsCode',
            // 'BranchCode',
            // 'Discount_Reverse',
            // 'Inv_Number',
            // 'Inv_date',
            // 'Accnum',
            // 'Accountcode_Discount',
            // 'Accountcode_Discount_Reverse',
            // 'UserName',
            // 'LastUpdate',
            // 'AccountCode_Lostliabilities',
            // 'Discount_Lostliabilities',
            // 'Account_PaymentWithHoldingTax',
            // 'VoucherNoRef',
            // 'VatAmt',
             
        ];

        
    }
 
}
