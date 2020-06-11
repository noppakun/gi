<?php
namespace app\modules\dbma\controllers;
use Yii;


class XemployeeextController extends \app\components\XQEdit\XQEditController
{
 
    protected $MAIN_MODEL 	    =   'app\models\XEmployeeExt';    
    
    public function init()  
    {    
        parent::init(); 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [
            'employee_code',
            'gi_username',
            'iptoken',
            'deptcode_ext',
            'deptcode_pr_review',                     
        ];
    }     
}

