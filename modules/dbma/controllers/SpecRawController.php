<?php
namespace app\modules\dbma\controllers;
use Yii;

class SpecRawController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\SpecRaw';    
 
    public function init()  
    {
        parent::init();
        
 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
 
            'Item_Number',
            'SpecNo',
            'EffectiveDate:date',
            // 'SpecificationDesc:ntext',
            'StorageCondition',
            
            [
                'attribute'=>'RetestInterval',
                'format' => ['decimal',0],
                'hAlign' => 'right',                 
            ],              
            // 'SpecCancel',
            // 'DescForAnalysis:ntext',
            // 'DescForCertificate:ntext',
            // 'ShortStorageCondition',
            // 'ReviseNo',
            // 'UserName',
            // 'LastUpdate',
             
        ];
    }
  
}
 