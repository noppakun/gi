<?php
namespace app\modules\dbma\controllers;
use Yii;
 
use kartik\builder\Form;

class ItemqcController extends \app\components\XQEdit\XQEditController

{
    

    protected $MAIN_MODEL 	=   'app\models\Item';      
    protected $MODEL_SCENARIO   =   'qcupdate';

    public function init()  
    {
        parent::init();
        $this->VIEWPARA['TABLECAPTION'] = 'รายการสินค้า';
        $this->VIEWPARA['XQEDIT']['index_actioncolumn_template'] = '{view}{update}'; 
        
        $this->VIEWPARA['XQEDIT']['index_columns'] = [ 
            'Item_Number',
            'Item_Name',
            [
                'attribute'=>'Std_Fill_LeadTime',
                'hAlign' => 'right',  
                'contentOptions' => [ 'width' => '100px'],
            ],
             
        ];
        $this->VIEWPARA['XQEDIT']['update_columns'] = [  
            'Item_Number',
            'Item_Name',             
            'Std_Fill_LeadTime',            
        ];

    }     
    
    
}

 