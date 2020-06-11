<?php
namespace app\modules\dbma\controllers;
use Yii;

class CompanyController extends \app\components\XETableController

{
    protected $MAIN_MODEL 	    =   'app\models\Company';    
    protected $SEARCH_MODEL     =   'app\models\CompanySearch';    
    public function init()  
    {
        parent::init();
        $this->VIEWPARA['TABLECAPTION'] = 'บริษัท'; 
    }    
}
 