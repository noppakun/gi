<?php
namespace app\modules\dbma\controllers;
use Yii;

use kartik\builder\Form;

class ItemRdController extends \app\components\XQEdit\XQEditController

{
    

    protected $MAIN_MODEL 	=   'app\models\Item';      
    protected $MODEL_SCENARIO   =   'bdupdate';

    public function init()  
    {
        parent::init();
        $this->VIEWPARA['TABLECAPTION'] = 'รายการสินค้า';
        $this->VIEWPARA['XQEDIT']['index_actioncolumn_template'] = '{view}{update}'; 
        
        $this->VIEWPARA['XQEDIT']['index_columns'] = [ 
            [
                'attribute'=>'Item_Number',                              
            ],
            [
                'attribute'=>'Item_Name',                
            ],
            [
                'attribute'=>'Industry_Code',                
                'label'=>'รหัสโรงงาน /<br>รหัสลูกค้า',
                'encodeLabel' => false,
            ],
             
        ];
        $this->VIEWPARA['XQEDIT']['update_columns'] = [ 

            'Item_Number'=>['type'=>Form::INPUT_STATIC],
            'Item_Name'=>['type'=>Form::INPUT_STATIC],                
            'WhCode'=>['type'=>Form::INPUT_STATIC],                
            'Loc_Number'=>['type'=>Form::INPUT_STATIC],                
            'Uom'=>['type'=>Form::INPUT_STATIC], 

            'Industry_Code'=>[
                'type'=>Form::INPUT_TEXT,                    
            ],            
        ];

    }     
    
    
}
