<?php
namespace app\modules\dbma\controllers;
use Yii;

class SaleController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\Sale';    
 
    public function init()  
    {
        parent::init();
        
 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
 
            'CompanyCode',
            'Sale_Number',
            'Cust_No',
            'Sale_Date',
            'Rlse_Date',
            //'Cust_PO_No',
            //'Cust_PO_Date',
            //'SalesmanCode',
            //'Terms',
            //'Shipto_Addr1',
            //'Shipto_Addr2',
            //'Shipto_Addr3',
            //'Shipto_Addr4',
            //'UserName',
            //'LastUpdate',
            //'Remark1',
            //'Remark2',
            //'Remark3',
            //'BranchCode',
            //'Confirm_Terms',
            //'Confirm_Remark',
            //'Disc_Cash',
            //'Disc_Percent',
            //'Disc_Special',
            //'Disc_Money',
            //'Desc_Disc_Other',
            //'Disc_Other',
            //'Vat_Percent',
            //'Vat_Amount',
            //'Amount',
            //'TotalAmount',
            //'Vat_Type',
             
        ];
    }
  
}
 