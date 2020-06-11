<?php
namespace app\modules\dbma\controllers;
use Yii;

 

class ApcnDetailController extends \app\components\XQEdit\XQEditController
 
{
    

    protected $MAIN_MODEL 	=   'app\models\ApCNDetail';      
    public function init()  
    {
        parent::init();
       
        $this->VIEWPARA['XQEDIT']['index_columns'] = [ 

            'CompanyCode',
            'ApCN_Number',
            'Seq_Number',
            'Item_Number',
            'ApCNDet_Desc',
            //'Uom',
            //'Order_Qty',
            //'Price',
            //'Disc_Percent',
            //'Disc_Cash',
            //'SumPrice',
            //'Type_Desc',
            //'Voucher_SumPrice',
            //'AccountCode',
        
                     
             
        ];
        

    }     
    
 
}

  