<?php
namespace app\modules\dbma\controllers;
use Yii;
 
class ChequeTranController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\ChequeTran';    
 

    public function init()  
    {
        parent::init();
        
 

        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'Type',
            'VoucherNo',
            'ChqNo',
            'ChqStatus',
            'ChqStatusDesc',
            
            // 'ChqDate',
            // 'ChqCode',
            // 'BankCode',
            // 'BankBranch',
            
            [
                'attribute'=>'ChqPayAmount',
                'format' => ['decimal',2],
                'hAlign' => 'right', 
                //'pageSummary' => true,
            ],            
            // 'ChqRecvDate',
            // 'ChqPassDate',
            // 'ChqDepositDate',
            // 'Fee',
            // 'Remark',
            // 'DepositSlip_CompanyCode',
            // 'DepositSlip_Type',
            // 'DepositSlip_VoucherNo',
            // 'ChqLocationCode'
             
        ];

        
    }
 
}
