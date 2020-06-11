<?php
namespace app\modules\dbma\controllers;
use Yii;
 
use yii\data\ArrayDataProvider;
use app\models\SelectForm;
use app\models\FiltersForm;
use app\models\ItemSearch;

//use app\models\ItemOnhand;
//use yii\web\Controller;
//use yii\web\NotFoundHttpException;
//use yii\filters\VerbFilter;




class ItemController extends \app\components\XETableController
{
    protected $MAIN_MODEL 	    =   'app\models\Item';    
    protected $SEARCH_MODEL     =   'app\models\ItemSearch';    
    protected $VIEWPARA      =   [
        'TABLECAPTION' =>  'สินค้า'
    ];    

    // **********************************************************************************************
    // **********************************************************************************************
    // **********************************************************************************************
    // ----------------------------------------------------------------------------------------------
 
    // ----------------------------------------------------------------------------------------------
    public function actionOnhand()
    // ----------------------------------------------------------------------------------------------
    {

        
        
        

        // echo '<br><br><br>';
        // echo '<pre>';
        // echo $params;
        // echo '</pre>';
        /*
        $searchModel = new ItemOnhand();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        */
        $SelectForm = new SelectForm();
        $searchModel = new ItemSearch();

        /* type_invent : ti_code  $SelectForm->var2
        01	Finished Goods                                    
        02	Work in Process                                   
        03	Semi Finished Goods                               
        04	Raw Materials                                     
        05	Packaging Materials                               
        06	Spare Parts                                       
        07	Store Supplies and Others                         
        08	Office Supplies                                   
        99	Others                                                    
        */        
        if (\Yii::$app->user->can('/@ITEM/ONHAND-ACCOUNT')){
            $SelectForm->var1 ='*';
            $SelectForm->var2 ='*';
            $SelectForm->var3 ='*';
        }else if (\Yii::$app->user->can('/@ITEM/ONHAND-BD')){
            $SelectForm->var1 ='|FIN|CUS|PAK|CHE|';
            $SelectForm->var2 ='|01|03|04|05|';            
            $SelectForm->var3 ='|GPM| PI->|GPC|';                                    
        }else if (\Yii::$app->user->can('/@ITEM/ONHAND-NETSHOP')){
            $SelectForm->var1 ='|FIN|';
            $SelectForm->var2 ='|01|';
            $SelectForm->var3 ='*';
        }else if (\Yii::$app->user->can('/@ITEM/ONHAND-GMC')){
            $SelectForm->var1 ='|FIN|';
            $SelectForm->var2 ='|01|';
            $SelectForm->var3 ='|GPM|';
        }else{
            $SelectForm->var1 ='||'; // wh_code
            $SelectForm->var2 ='||'; // ti_code
            $SelectForm->var3 ='||'; // co_code
        }            
   
         
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {                            
            $SelectForm->wh_code = Yii::$app->request->queryParams['SelectForm']['wh_code']; 
            $SelectForm->ti_code = Yii::$app->request->queryParams['SelectForm']['ti_code']; 
            $SelectForm->co_code = Yii::$app->request->queryParams['SelectForm']['co_code']; 
        } else {
            list($dummy,$SelectForm->wh_code) = explode("|", $SelectForm->var1.'|FIN|');            
            list($dummy,$SelectForm->ti_code) = explode("|", $SelectForm->var2.'|01|');            
            list($dummy,$SelectForm->co_code) = explode("|", $SelectForm->var3.'|GPM|');            
        } 


        $dataProvider = $searchModel->onhandSearch(Yii::$app->request->queryParams,$SelectForm);

        $dataProvider->setSort([
            'attributes' => [            
                'Item_Number',
                'Item_Name',
                'calOnhandx' => [
                    'asc' => [
                        'onhandSum.calqty' => SORT_ASC,                     
                    ],
                    'desc' => [
                        'onhandSum.calqty' => SORT_DESC,                     
                    ],
                    'label' => 'Parent Name1',
                    'default' => SORT_ASC
                ],
                'calQty',
                'calQuarantine',
                
            ]
        ]);
       
      //  \app\components\XLib::xprint_r($dataProvider->query->all());
        return $this->render('onhand', [
            'SelectForm'    => $SelectForm, 
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]);
    }


    /**
     * Lists all Item models.
     * @return mixed
     */
    // for P.Kai 25/4/2018



    // ----------------------------------------------------------------------------------------------
    public function actionList()
    // ----------------------------------------------------------------------------------------------    
    {
        $filtersForm = new FiltersForm;        
        if (isset($_GET['filtersForm'])){
            $filtersForm->filters = \Yii::$app->request->get('filtersForm');
        }else{
            
            $filtersForm->filters['Item_Number']='';
            $filtersForm->filters['Item_Name']='';
            $filtersForm->filters['order_qty']='';
            $filtersForm->filters['price']='';
            $filtersForm->filters['order_number']='';
            $filtersForm->filters['order_date']='';
            
        }
            
         

        $sql ="
            select a.Item_Number,a.Item_Name
            ,a.LeadTime,a.QtyOnhand
            ,b.order_qty,b.price,b.order_number,b.order_date 
            ,b.rlse_qty
            from item a 
            left join (
                select * from (
                    select   b.item_number,b.price,a.order_number,a.order_date 
                        ,sum(b.order_qty) as order_qty,sum(b.rlse_qty) as rlse_qty
                        ,row_number() OVER (PARTITION BY b.item_number order by b.item_number,a.order_date desc ) seq
                    from po a    
                    left join  podetail b  on  a.order_number = b.order_number
                    where isnull(b.item_number,'') <> ''
                    group by b.item_number,b.price,a.order_number,a.order_date            
                ) aa where  aa.seq = 1
            ) b on a.item_number = b.item_number 
            order by a.item_number
        ";


        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);

        //$command->bindParam(":year",$SelectForm->year);

        $rows = $command->queryAll();
        
        $filteredRow=$filtersForm->filter($rows);

        $dataProvider=new ArrayDataProvider( [
            'allModels' => $filteredRow,
            'sort' => [
                'attributes' => ['Item_Number', 'Item_Name', 'order_number'
                // ,'order_qty','price','order_date '
            ],
                
            ],            
            'pagination'=>[
                'pageSize' => 40,              
            ], 
        ]);
         
          
        return $this->render('list', [
            'filtersForm' => $filtersForm->filters,
            'dataProvider' => $dataProvider,
        ]);
    }    
    // // ----------------------------------------------------------------------------------------------
    // //public function actionList2()
    // public function actionList2()
    // // ----------------------------------------------------------------------------------------------    
    // {
    //     $searchModel = new ItemSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('list', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }
}
