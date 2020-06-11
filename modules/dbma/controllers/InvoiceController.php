<?php
namespace app\modules\dbma\controllers;
use Yii;

 
class InvoiceController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\Invoice';    
    protected $MODEL_SCENARIO   =   'xqedit';


    public function init()  
    {
        parent::init();
        
 

        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'Inv_Number',
            'Type_Inv_Code',
            'Sale_Number',
            'DivisionCode',
            // 'DeptCode',
            'Cust_No',
            'Inv_Date',
            'SalesmanCode',
            // 'DeliveryCode',
            // 'Terms',
            // 'ShipTo_Addr1',
            // 'ShipTo_Addr2',
            // 'ShipTo_Addr3',
            // 'ShipTo_Addr4',
            // 'Remark1',
            // 'Remark2',
            // 'Remark3',
            // 'Due_Date',
            // 'Cust_PO_No',
            // 'Cust_PO_Date',
            // 'Disc_Cash',
            // 'Disc_Percent',
            // 'Disc_Special',
            // 'Disc_Money',
            // 'Desc_Disc_Other',
            // 'Disc_Other',
            // 'Inv_Issue',
            // 'Open_Close',
            // 'Vat_Percent',
            // 'Vat_Amount',
            // 'Adjust_Date',
            // 'Adjust_Many',
            // 'Currency_Type',
            // 'Currency_Rate',
            // 'Amount',
            // 'TotalAmount',
            // 'PaidAmount',
            // 'Inv_Picture',
            // 'UserName',
            // 'LastUpdate',
            // 'Vat_Type',
            // 'BranchCode',
            // 'delivery_date',
             
        ];

        
    }
 
}
