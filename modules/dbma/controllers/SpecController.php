<?php
namespace app\modules\dbma\controllers;
use Yii;

class SpecController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\Spec';    
 
    public function init()  
    {
        parent::init();
        
 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
 
            'Item_Number',
            'SpecNo',
            'EffectiveDate',
            'SamplingMethod',
            //'Description',
            // [
                
            //     'attribute'=>'Description',
            //     'value'=>function ($model, $key, $index, $column) {                                      
            //         $rtf = $model->Description;
                     
            //         return $rtf;
                  
 
            //     },
            //     'width'=>'100px',
            //     //'hAlign'=>'center',                
                
            // ],

            //'Material',
            //'Dimension:ntext',
            //'Package:ntext',
            //'Remark:ntext',
            //'SpecPicture',
            //'SpecCancel',
            //'RetestInterval',
            //'StorageCondition',
            //'ShortStorageCondition',
            //'ReviseNo',
            //'SpecFile',
            //'DescForAnalysis:ntext',
            //'UserName',
            //'LastUpdate',
             
        ];
    }
  
}
 