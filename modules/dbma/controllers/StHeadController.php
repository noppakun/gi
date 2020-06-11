<?php
namespace app\modules\dbma\controllers;
use Yii;


class StHeadController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\StHead';    
 
    public function init()  
    {
        parent::init();
        
 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
 
            'CompanyCode',
            'DocType',
            [
                'attribute'=>'DocTypeDesc',                
                'value'=>'doctype_ref.DocTypeDesc',                
                'contentOptions' => ['style' => 'width:30px;    '], 
            ],             
            'VoucherNo',
            'DocDate',
            'Order_Number',
            'RefDoc',
            'JobNo',
            //'Remark',
            //'AccountCode',
            //'Manufacturer',
            //'Supplier_Lot',
            //'RefDoc2',
            //'UserName',
            //'VatRate',
            //'VatAmt',
            //'RecvDocDate',
            //'PO_NO',
            //'Inv_Number',
            //'Inv_Date',
            //'Supp_Number',
            //'Supp_Name',
            //'Discount',
            //'Deposit',
            //'Amount',
            //'TotalAmount',
            //'PaidAmount',
            //'PostGL',
            //'UserPostGL',
            //'DateTimePostGL',
            //'PrintDocStatus',
            //'BranchCode',
            //'AccountCode_Tax',
            //'TransferStatus',
            //'TaxID',
            //'BranchNo',
            //'DivisionCode',
            //'DeptCode',
            //'AccountCode_Deposit',
        ];
    }
  
}
 