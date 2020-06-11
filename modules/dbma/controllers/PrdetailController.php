<?php
namespace app\modules\dbma\controllers;
use Yii;


class PrdetailController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\PRDetail';    
 
    public function init()  
    {
        parent::init();
        
         
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
           

            'CompanyCode',
            'PR_Number',
            'Seq_Number',
            'Item_Number',
            'Due_Date',
            'Order_Qty',
            //'Rlse_Date',
            //'Price',
            //'PRDet_Desc',
            //'Uom',
            'Rlse_Qty',
            //'Recd_Qty',
            //'Type_Desc',
            'PO_Qty',
            //'PO_Issue',
            //'score',
            //'revdte1',
            //'revdte2',
             
        ];
    }
  
}


