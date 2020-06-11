<?php
namespace app\modules\dbma\controllers;
use Yii;


class PodetailController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\PODetail';    
 
    public function init()  
    {
        parent::init();
        
         
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'Order_Number',
            //'Seq_Number',
            'Item_Number',
            'Due_Date',
            'Order_Qty',
            //'Rlse_Date',
            //'Price',
            'PurDet_Desc',
            //'Uom',
            //'Rlse_Qty',
            //'Pr_Company',
            //'Pr_No',
            //'Iqc_Qty',
            //'Rej_date',
            //'Rej_Qty',
            //'Disc_Percent',
            //'Disc_Cash',
            //'Type_Desc',
            //'Delivery_Date',
            //'SpecNo',
            //'EffectiveDate',
            //'Seq_Pr',
            //'PR_Number',
             
        ];
    }
  
}
