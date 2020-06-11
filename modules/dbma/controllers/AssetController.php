<?php
namespace app\modules\dbma\controllers;
use Yii;

use kartik\builder\Form;

class AssetController extends \app\components\XQEdit\XQEditController

{
    

    protected $MAIN_MODEL 	=   'app\models\Asset';      


    public function init()  
    {
        parent::init();
        $this->VIEWPARA['TABLECAPTION'] = 'ทรัพย์สิน';
        $this->VIEWPARA['XQEDIT']['index_actioncolumn_template'] = '{view}{update}'; 
        
        $this->VIEWPARA['XQEDIT']['index_columns'] = [ 
            [
                'attribute'=>'AssetCode',
                'contentOptions' => ['width'=>100],
            ],
            'AssetName',

            [
                'attribute'=>'AssetDate',
                'format' => ['date'],
                'contentOptions' => ['width'=>100],
            ],
            
            [
                'attribute'=>'Recv_Date',                
                'format' => ['date'],
                'contentOptions' => ['width'=>100],
            ],            
            [
                'attribute'=>'VoucherNo',
                'contentOptions' => ['width'=>100],
            ], 
            [
                'attribute'=>'CalcDepreciation',
                'format'=>'raw',
                'value'=>function($model){
                    return $model->CalcDepreciation ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';                  
                }, 
                'hAlign'=>'center',  
                'contentOptions' => ['width'=>50],            
                 
            ],             
             
        ];
        $this->VIEWPARA['XQEDIT']['update_columns'] = [ 

            'AssetCode'=>[                    
                'type'=>Form::INPUT_STATIC,
                //'type'=>Form::INPUT_TEXT,

                
            ],
            'AssetName'=>[
                'type'=>Form::INPUT_STATIC,
             //  'columnOptions'=>['colspan'=>2],                
            ],         
//            'CalcDepreciation',
            'CalcDepreciation'=>[
     
                //'format'=>'raw',                              
                // 'staticValue'=>function($model){
                //     return $model->CalcDepreciation ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';                  
                // },
              
                'type'=>Form::INPUT_CHECKBOX,  
                'items'=>[1=>'Yes', 0>'No'], 
                //'items'=>[true=>'Active', false=>'Inactive'], 
 
                'valueColOptions'=>['style'=>'width:30%']                                       
              
            ],


            'AssetDate'=> [
                 'type'=>Form::INPUT_WIDGET,                      
                'widgetClass'=>'kartik\date\DatePicker', 
                'options'=>[
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',                         
                    ],                        
                ]                     
        
            ],
            

            'Depreciate'=>['type'=>Form::INPUT_TEXT],
            'DepreciationRemain'=>['type'=>Form::INPUT_TEXT],
            'Asset_AccountNo'=>['type'=>Form::INPUT_TEXT],
            'Acc_Depreciation'=>['type'=>Form::INPUT_TEXT],
            'Acc_AccumulatedDepreciation'=>['type'=>Form::INPUT_TEXT],
            'Acc_ScrapValue'=>['type'=>Form::INPUT_TEXT],  
            'VoucherNo'=>['type'=>Form::INPUT_TEXT],  
                      
        ];

    }     
    
    // public function actionUpdate($id=null,$viewmode=false)   
    // {
    //     \app\components\XLib::xprint_r(Yii::$app->request->post());
    //     if ($id==null){ // create
    //         $model = new $this->MAIN_MODEL();
    //         // new function 28/8/2018
    //         $this->afterInsert($model);            
            
    //     }else{        
    //         $model = $this->findModel($id);
    //         // cancel 28/8/2018
    //         // $this->afterLoad($model);
    //     }
    //     if ($this->MODEL_SCENARIO != 'default'){
    //         $model->scenario = $this->MODEL_SCENARIO;
    //     }

    //     if ($model->load(Yii::$app->request->post())) {            
    //         // cancel 28/8/2018
    //         // $this->beforeSave($model);            
    //         $model->save();
    //     //    return $this->redirect(['index']);
    //     } else {
    //         $this->VIEWPARA['model'] = $model;
    //         $this->VIEWPARA['viewmode'] = $viewmode;
    //         return $this->render($this->VIEWPATH.'update', $this->VIEWPARA);

    //     }
    // }      
}


 