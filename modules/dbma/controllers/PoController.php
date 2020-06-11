<?php
namespace app\modules\dbma\controllers;
use Yii;


class PoController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\PurchaseOrder';    
    protected $SEARCH_MODEL     =   'app\models\PoSearch';   
 

    public function init()  
    {
        parent::init();
 

        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'Order_Number',
            'DeptCode',
            'Supp_Number',
            'Pr_Number',
            //'Shipto_Addr1',
            //'Shipto_Addr2',
            //'Currency_Type',
            //'Remark1',
            //'Remark2',
            //'Remark3',
            //'Remarks:ntext',
            //'Order_date',
            //'Buyers',
            //'Terms',
            //'Po_Issue',
            //'Open_Close',
            //'Close_Date',
            //'Service',
            //'Insurance',
            //'Carriage',
            //'Vat_Percent',
            //'Vat_Amt',
            //'Disc_Percent',
            //'Disc_Cash',
            //'Revision_No',
            //'Revision_Date',
            //'Vat_Type',
            //'ForWork',
            //'DivisionCode',
            //'LimitOverOrderRate',
            //'currency_Rate',
            //'ShipMent',
            //'Amount',
            //'TotalAmount',
            //'UserName',
            //'LastUpdate',
            //'PO_Approve',
            //'UserName_Approve',
            //'DateTime_Approve',
             
        ];

        
    }
 
}

 