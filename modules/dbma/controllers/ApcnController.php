<?php
namespace app\modules\dbma\controllers;
use Yii;

 

class ApcnController extends \app\components\XQEdit\XQEditController

{
    

    protected $MAIN_MODEL 	=   'app\models\ApCN';      
    public function init()  
    {
        parent::init();
       
        $this->VIEWPARA['XQEDIT']['index_columns'] = [ 
            'CompanyCode',
            'ApCN_Number',
            'ApCN_Date',
            'DocType',
            'VoucherNo',
            'DocDate',
            'Buyers',
            'DivisionCode',
        
                     
             
        ];
        

    }     
    

/**
 * This is the model class for table "ApCN".
 *
 * @property string $CompanyCode
 * @property string $ApCN_Number
 * @property string $ApCN_Date
 * @property string $DocType
 * @property string $VoucherNo
 * @property string $DocDate
 * @property string $Buyers
 * @property string $DivisionCode
 * @property string $DeptCode
 * @property string $Voucher_TotalAmount
 * @property string $Voucher_Amount
 * @property string $Vat_Percent
 * @property string $Vat_Amount
 * @property string $Remark1
 * @property string $Remark2
 * @property string $Remark3
 * @property string $Adjust_Date
 * @property int $Adjust_Many
 * @property int $ApCN_Issue
 * @property int $Open_Close
 * @property string $Supp_Number
 * @property string $Disc_Cash
 * @property string $Disc_Percent
 * @property string $Disc_Special
 * @property string $Disc_Money
 * @property string $Amount
 * @property string $TotalAmount
 * @property string $PaidAmount
 * @property string $BranchCode
 * @property string $AccountCode_Tax
 */    
}

 