<?php
namespace app\modules\dbma\controllers;
use Yii;

class GilogsController extends \app\components\XQEdit\XQEditController
{    
    protected $MAIN_MODEL 	    =   'app\models\Gilogs';       
    public function init()  
    {
        parent::init();
        
         
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'id' ,
            'username',
            'ipaddress',
            [
                'attribute'=>'logtime',                
                //'format' => ['datetime'],
                'format' => ['datetime','php:d-m-Y H:i:s'],
                
                // 'value'=>function($model){                                         
                //     $date = new \DateTime($model['logtime']);
                //     $date->setTimezone(new \DateTimeZone('Asia/Bangkok'));                    
                //     return $date->format('d-m-Y H:i:s');
                // },
                'contentOptions' => ['width'=>100],
            ],
           
            'controller',
            'action',
            'details',
             
        ];
    }         
}



