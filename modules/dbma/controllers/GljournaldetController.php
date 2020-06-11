<?php
namespace app\modules\dbma\controllers;
use Yii;
 
class GljournaldetController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\GLJournalDet';    
 

    public function init()  
    {
        parent::init();
        
 

        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'GLBookCode',
            'VoucherNo',
            'Seq_Number',
            'AccNum',
             'Description',
            // 'TranType',
             'Amount',
            // 'UserName',
            // 'UpdateTime',
            // 'DebitAmount',
            // 'CreditAmount',
            // 'CsCode'
             
        ];

        
    }

 
}
