<?php
namespace app\modules\dbma\controllers;
use Yii;
 
 
class BankTransactionDetailAccController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\BankTransactionDetailAcc';    
 

    public function init()  
    {
        parent::init();
        
 

        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'BankTranType',
            'VoucherNo',
            'AccountCode',
            'Amount',
            //'seq_number',
            //'CsCode',
            //'AccountDesc',
             
        ];

        
    }
 
}

