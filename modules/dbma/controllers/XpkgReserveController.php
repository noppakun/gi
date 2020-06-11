<?php
namespace app\modules\dbma\controllers;
use Yii;


class XpkgReserveController extends \app\components\XQEdit\XQEditController
{ 
    protected $MAIN_MODEL 	    =   'app\models\XPkgReserve';         
 
    
    public function init()  
    {
        parent::init();
        $this->VIEWPARA['TABLECAPTION'] = 'Packaging Reserve';
        $this->VIEWPARA['XQEDIT']['index_actioncolumn_template'] = null; 
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            //'group_product',
            //  'gproduct.Group_Product_Desc',  
            [
                'label'=>'Group product',
                'attribute'=>'m_gproduct',

                'value'=>function($model){
                    return $model->gproduct->Group_Product_Desc.' ('.$model->group_product.')';
                },
                //'filter'=>ArrayHelper::map(Model::find()->asArray()->all(), 'ID', 'Name'),
                

            ],            

            //'product',            
            [
                'label'=>'Product',
                'attribute'=>'m_product',
//                'value'=>'product2.Product_Desc',  
                'value'=>function($model){
                    return $model->product2->Product_Desc.' ('.$model->product.')';
                },

            ],            

            [
                'attribute'=>'condition',
                'value'=>function($model){
                    return isset($model['condition'])?$model['condition']:'';
                }
            ],                         
            
            [
                'attribute'=>'reserve',
                //'format' => ['decimal',2],
                'hAlign' => 'right', 
                'contentOptions' => ['width'=>50],                    
                'content'=>function($model){
                    return $model['reserve']!=0?number_format($model['reserve'],2).' %':$model['reserve_remark'];
                }

            ],             
            // [
            //     'attribute'=>'reserve_remark',
            //     'value'=>function($model){
            //         return isset($model['reserve_remark'])?$model['reserve_remark']:'';
            //     }
            // ],                         
        ];
    }  
}
