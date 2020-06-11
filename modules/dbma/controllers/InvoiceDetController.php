<?php
namespace app\modules\dbma\controllers;
use Yii;
 
 
class InvoiceDetController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\InvoiceDet';    
 

    public function init()  
    {
        parent::init();
        
     
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'Inv_Number',
            // 'Seq_Number',
            'Item_Number',
            'InvDet_Desc',
            // 'Uom',
             'Order_Qty',
             'Price',
             'Batch_No',
            // 'Disc_Percent',
            // 'Disc_Cash',
            // 'Type_Desc',
            // 'WhCode',
            // 'Location',
            // 'IssueStatus',
            // 'DescStatus',
             
        ];

        
    }


}





