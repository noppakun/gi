<?php
namespace app\modules\dbma\controllers;
use Yii;


class PrController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\Pr';    
 
    public function init()  
    {
        parent::init();
        
         
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
           
            'Companycode',
            'PR_Number',
            'Supp_Number',
            'Quote',
            'Shipto_Addr1',
            // 'Shipto_Addr2',
            // 'Currency_Type',
            // 'Remarks',
            // 'Remarks2',
            // 'Remarks3',
            'Order_Date',
            'Buyers',
            // 'Terms',
            'PO_Issue',
            'Open_Close',
            // 'DeptCode',
            // 'DivisionCode',
            // 'UserName',
            // 'LastUpdate'
             
        ];
    }
  
}

