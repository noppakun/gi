<?php
namespace app\modules\dbma\controllers;
use Yii;

class SaleDetController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\SaleDet';    
 
    public function init()  
    {
        parent::init();
        
 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
 
           
            'CompanyCode',
            'Sale_Number',
            'Seq_Number',
            'Item_Number',
            'Due_Date',
            'Order_Qty',
            'Rlse_Qty',
            //'Price',
            //'SaleDet_Desc',
            //'Uom',
            'Sale_Close',
            //'Promise_Delivery_Date',
            //'Inform_Date',
            //'Production_Date_Complete',
            //'Order_Status',
            //'Balance_Date',
            'Inv_Qty',
            //'Disc_Percent',
            //'Disc_Cash',
            //'Confirm_Price',
            //'Remark',
             
        ];
    }
  
}
 