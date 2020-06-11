<?php
namespace app\modules\dbma\controllers;
use Yii;

 
 
class SupplierController extends \app\components\XQEdit\XQEditController

{
    

    protected $MAIN_MODEL 	=   'app\models\Supplier';      

    public function init()  
    {
        parent::init();
        $this->VIEWPARA['TABLECAPTION'] = 'ผู้จำหน่าย';
        $this->VIEWPARA['XQEDIT']['exportconfig_pdf_orientation'] = 'L';
        $this->VIEWPARA['XQEDIT']['index_columns'] = [
            [
                'attribute'=>'Supp_Number',
                'label'=>'รหัส',
                'contentOptions' => ['style' => 'width:70px;'], 
            ],            
            'Supp_Name',
            
            'Addr1',
            'Addr2',
            'Addr3',            
            'Contact',
            'Phone',
            //'Fax',        
            //'TaxID',

            // 'Addr4',                    
            // 'Position',
            'Remarks',
            // 'Credit_Limit',
            // 'Terms',
            // 'Currency_Type',
            // 'Account_Code',
            // 'Supp_Cancel',
            // 'SupplierTypeCode',
            // 'BranchCode',
            // 'Vat_Ch',           
        ];
    }     
    
    
}
