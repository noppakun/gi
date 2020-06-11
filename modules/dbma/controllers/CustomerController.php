<?php
namespace app\modules\dbma\controllers;
use Yii;

class CustomerController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\Customer';    
   

    public function init()  
    {
        parent::init();      
        $this->VIEWPARA['XQEDIT']['index_columns'] = [
            'Cust_No',
            'Cust_Name',
            'Addr1',
            'Addr2',
            'Addr3',
            // 'Addr4',
            // 'Phone',
            // 'Contact',
            // 'Position',
            // 'Saleman',
            // 'Credit_Limit',
            // 'Terms',
            // 'Price_Code',
            // 'Currency_Type',
            // 'Shipto_Addr1',
            // 'Shipto_Addr2',
            // 'Shipto_Addr3',
            // 'Shipto_Addr4',
            // 'CountryCode',
            // 'Fax',
            // 'Account_Code',
            // 'ProvinceCode',
            // 'AreaCode',
            // 'DistrictCode',
            // 'SaleZoneCode',
            // 'PostalCode',
            // 'Remark:ntext',
            // 'CustomerTypeCode',
            // 'CustomerGroupCode',
            // 'NotActive',
            // 'BlackList',
            // 'RegisterNo',
            // 'RegisterExpireDate',
            // 'Account_Code_Credit',
            // 'Account_Code_Return',
            // 'Account_Code_Distcount',
            // 'Account_Code_Material',
            // 'Taxid',
            // 'BranchCode',
            // 'Vat_ch',
        ];
    
    } 
}


