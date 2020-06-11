<?php
namespace app\components\XQEdit;

use Yii;
/*
    29/11/2018
        new* auto format index page  column  => datetime , decimal (only attribute param is string not array)
    22/11/2018
        new* automatic set inputtype to  INPUT_STATIC if not in $model->scenarios()
            exp.(invoiceController): set in class :  protected $MODEL_SCENARIO   =   'xqedit';                   
    28/09/2018
        new* support multi  [ Form::widget ] by set to ['update_columns']['attributes']
        new* index_rowoptions
    26/09/2018
        new* index_text_before  : text before grid
    25/09/2018
        new* support multi fields primary key AUTO
        new* param index_actioncolumn_urlcreator
            exp:in GljournalController
    21/09/2018
        add* param exportconfig_pdf_footer
*/ 
class XQEditController extends \app\components\XETableController
{
 
    protected $MAIN_MODEL 	    =   'app\models\Warehouse';        
    protected $SEARCH_MODEL     =   null;   // XQEdit init        
    protected $VIEWPATH         =   '@app/components/XQEdit/';
    protected $VIEWPARA;
    

    public function init()  
    {
        parent::init();
        // -------------------------------------------------------------------------
        $this->VIEWPARA      =   [
            'TABLECAPTION' =>  null,    // XQEdit init      
     
            'XQEDIT'        => [
                'index_columns'=>null,  // XQEdit init
                'update_columns'=>null, // XQEdit init            
                'index_actioncolumn_template'=>null, // XQEdit init               
                'index_actioncolumn_urlcreator'=>null, // XQEdit init               
                'index_text_before'=>null,
                'exportconfig_pdf_footer'=>null, // XQEdit not init   exp.  ['FM-068'],    
                'index_rowoptions'=>null,
                
            ],
        ];      
        // -------------------------------------------------------------------------
        
        // echo '<br>';
        // echo '<br>';
        // echo '<br>';
        
        // echo '<pre>';
        // print_r($this->VIEWPARA);
        // echo '</pre>';

        /* AAAAAAAAAAAAAAAAAAAAAAAAAAAA */
        /*-----------  XQEdit ------ */    

        // ===============   for auto parameter AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAa
        // -- search model             
        $this->SEARCH_MODEL = isset($this->SEARCH_MODEL) ? $this->SEARCH_MODEL : $this->MAIN_MODEL.'Search';            
        // --TABLECAPTION
        $this->VIEWPARA['TABLECAPTION'] = isset($this->VIEWPARA['TABLECAPTION']) ? $this->VIEWPARA['TABLECAPTION'] :substr($this->MAIN_MODEL,strrpos($this->MAIN_MODEL , '\\')+1);
        // ===============   for auto parameter BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBbb
 
        //-- ----------------------------------------------
        $model = (new $this->MAIN_MODEL());        
        $columns=array_keys($model->attributes);                 
        
        $this->VIEWPARA['XQEDIT']['index_columns'] = $columns; 
        $this->VIEWPARA['XQEDIT']['update_columns'] = $columns; 
        $this->VIEWPARA['XQEDIT']['index_actioncolumn_template'] = '{create}{view}{update}{delete}'; 
        
        // echo '<pre>';
        // print_r($this->VIEWPARA);
        // echo '</pre>';

        /* BBBBBBBBBBBBBBBBBBBBBBBBBBBBb */
        
        /******* D-E-M-O for use   ***************
          
         ***** ['update_columns']['attributes']  *****       ***** use in XfdaregisterController

            $this->VIEWPARA['XQEDIT']['update_columns'] = [   
                'regno',
                'regname'=>[
                    'type'=>Form::INPUT_TEXT,
                    'columnOptions'=>['colspan'=>2],                
                ],                            
                [
                    'columns'=>2,
                    'attributes'=>[
                        'recdate'=> [
                            'type'=>Form::INPUT_WIDGET,                      
                            'widgetClass'=>'kartik\date\DatePicker', 
                            'options'=>[
                                'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',                         
                                ],                        
                            ]                                 
                        ],
                        'expdate'=> [                
                            'type'=>Form::INPUT_WIDGET,                      
                            'widgetClass'=>'kartik\date\DatePicker', 
                            'options'=>[
                                'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',                         
                                ],                        
                            ]                                 
                        ],        
                    ]
                ],
    
            ];
         ***** index_rowoptions ***** use in XfdaregisterController
         
            $this->VIEWPARA['XQEDIT']['index_rowoptions']=function($model){
                if($model->canceldate  != null){
                    return ['class' => 'danger'];
                }
            };

         ***** index_actioncolumn_urlcreator *****
          
            $this->VIEWPARA['XQEDIT']['index_actioncolumn_urlcreator'] = function ($action, $model, $key, $index) { 
                $url = Url::toRoute([Yii::$app->controller->id.'/'.$action, 'id' => 
                    $model->CompanyCode.'|'.
                    $model->GLBookCode.'|'.
                    $model->VoucherNo
                ]);
                return $url; 
            };
        ************************************************************************            
        ***** index_columns *****
            set columns            
                $this->VIEWPARA['XQEDIT']['index_columns'] = [
                    'Cust_No',
                    'Cust_Name',
                    'Addr1',
                    'Addr2',
                    'Addr3',
                    // 'Addr4',
                    // 'Phone',            
                ];
        ***** update_columns *****
                // demo in Xquery
                $this->VIEWPARA['XQEDIT']['update_columns'] = [
                    'code',
                    'description',           
                    'query' => [
                        'type' => Form::INPUT_TEXTAREA,
                        'options' =>['rows' => 10],
                        'columnOptions'=>['colspan'=>3],
                    ],            
                    'modified',            
                ];                
        ***** delete some columns *****
                array_splice($this->VIEWPARA['XQEDIT']['index_columns'], array_search("Remark",$this->VIEWPARA['XQEDIT']['index_columns']),1);
        *******/

    }    
    //******************* for support multiple field in key ******************* */
    protected function findModel($id=null)  
    //************************************************************************** */
    {        
 
        $xid=[];
        $id = explode("|", $id);
        $model = new $this->MAIN_MODEL();            
        foreach($model->tableSchema->primaryKey as $key => $value ){  
            $xid[$value]=$id[$key];            
        }
       
        $fOne = new \ReflectionMethod($this->MAIN_MODEL,'findOne');
        if (($model = $fOne->invoke(NULL,$xid)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested id does not exist.:)');
        }
    } 
}