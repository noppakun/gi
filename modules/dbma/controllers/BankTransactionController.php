<?php
namespace app\modules\dbma\controllers;
use Yii;
 
 
class BankTransactionController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\BankTransaction';    
 

    public function init()  
    {
        parent::init();
        
 

        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'BankTranType',
            'VoucherNo',
            'BankCode',
            'TranDate',
            // 'RefDoc',
            // 'Remark',
            'ChqNo',
            // 'Amount',
            // 'Charge',
            // 'VatAmt',
            // 'NetAmt',
            // 'BankCode2',
            // 'Supp_Number',
            // 'Supp_Name',
            // 'GIncome_Code',
            // 'Income_Code',
            // 'GExpend_Code',
            // 'Expend_Code',
            // 'TranDate2',
            // 'BranchCode',
            // 'PaymentWithHoldingTax',
            // 'expend_Accountcode',
            // 'Account_PaymentWithHoldingTax',
            // 'Income_AccountCode',
            // 'AccountCode_Tax',
            // 'VoucherNoRef',
            // 'Inv_Number',
            // 'Inv_date',
            // 'TransferStatus',
            // 'TaxID',
            // 'BranchNo',
             
        ];

        
    }
 
}


