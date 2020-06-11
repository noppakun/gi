<?php
namespace app\modules\dbma\controllers;
use Yii;
 
class CashTranController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\CashTran';    
 

    public function init()  
    {
        parent::init();
        
 

        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'Type',
            'VoucherNo',
            'DocNo',
            'BillNo',
            // 'DocType',
            // 'Amount',
            // 'PayAmount',
            // 'BalanceAmount',
            // 'DocDate',
            // 'Accnum',
             
        ];

        
    }
 
}


