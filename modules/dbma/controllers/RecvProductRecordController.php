<?php
namespace app\modules\dbma\controllers;
use Yii;

class RecvProductRecordController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\RecvProductRecord';    
 
    public function init()  
    {
        parent::init();
        
 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'Order_Number',
            'JobNo',
            'Item_Number',
            'VoucherNo',
            'WhCode',
            'Ana_no',
            'Recv_Qty',
            
            // 'Location',
            // 'Acc_Qty',
            // 'Rej_Qty',
            // 'Acc_Date',
            // 'Item_Type',
            // 'Status',
            // 'UserName',
            // 'Fill_Date',
            // 'LastUpdate'
             
        ];
    }
  
}


 