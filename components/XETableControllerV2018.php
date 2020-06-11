<?php
/***************************************
 
 
    6/6/2018
        bug fix        
    10/5/2018  
        add function actionView
    28/8/2018
        cancel to use (delete function) 2 functions
            protected function afterLoad($model){}
            protected function beforeSave($model){}                        
        add new function 
            protected function afterInsert($model){}
****************************************/
namespace app\components;

use Yii; 
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

 
class XETableController extends \yii\web\Controller /* base class */
{
    
    
    /*
        protected $MAIN_MODEL 	=   'common\models\Stocktran';
        protected $SEARCH_MODEL =   'common\models\StocktranSearch';    
        protected $VIEWPATH     =   '@backend/views/refdata/';
        protected $VIEWPARA     =   ['RECTYPE' => 'XX'];
    */       
    protected $MAIN_MODEL;
    protected $SEARCH_MODEL;    
    protected $VIEWPATH ='';
    protected $VIEWPARA =[];  
    protected $MODEL_SCENARIO = 'default';

    //private $VIEWPATH ='@backend/views/contact/';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Contact models.
     * @return mixed
     */


    
    public function actionIndex()
    {
        //echo '<br><br><br>$this->VIEWPATH:[' .$this->VIEWPATH.']';
        //$searchModel = new ContactSearch();
        $searchModel = new $this->SEARCH_MODEL();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->VIEWPARA['searchModel'] = $searchModel;
        $this->VIEWPARA['dataProvider'] = $dataProvider;        
        return $this->render($this->VIEWPATH.'index', $this->VIEWPARA);

    }

 

    /**
     * Creates a new Contact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->actionUpdate(null);
    }

    /**
     * Updates an existing Contact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    /*
        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
        remark for 
        PurchaseOrderController
        unremark for supplier
        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    */
    // cancel 28/8/2018
    // protected function afterLoad($model){}
    // protected function beforeSave($model){}

    // add new 28/8/2018        
    protected function afterInsert($model){}
    

    public function actionUpdate($id=null,$viewmode=false)   
    {
        if ($id==null){ // create
            $model = new $this->MAIN_MODEL();
            // new function 28/8/2018
            $this->afterInsert($model);            
            
        }else{        
            $model = $this->findModel($id);
            // cancel 28/8/2018
            // $this->afterLoad($model);
        }
        if ($this->MODEL_SCENARIO != 'default'){
            $model->scenario = $this->MODEL_SCENARIO;
        }

        if ($model->load(Yii::$app->request->post())) {            

        //echo '<br><br><br>';
 
            //sleep(5) ;
        //\app\components\XLib::xprint_r(Yii::$app->request->post());


            
            // cancel 28/8/2018
            // $this->beforeSave($model);            
            $model->save();
            return $this->redirect(['index']);
        } else {
            $this->VIEWPARA['model'] = $model;
            $this->VIEWPARA['viewmode'] = $viewmode;
            return $this->render($this->VIEWPATH.'update', $this->VIEWPARA);

        }
    }    
    // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function actionView($id)
    {
        return $this->actionUpdate($id,true);
    
    }    
    // for Overriding
    

    /**
     * Deletes an existing Contact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id=null)   
    {
        $this->findModel($id)->delete();        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    

    /*
        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
        remark for 
        PurchaseOrderController
        unremark for supplier
        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 */
    //protected function findModel($id=null,$_id2=null,$_id3=null)   
    protected function findModel($id=null)  
    {

        //if (($model = Contact::findOne($id)) !== null) {       
        $fOne = new \ReflectionMethod($this->MAIN_MODEL,'findOne');
        if (($model = $fOne->invoke(NULL,$id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested id does not exist.:)');
        }
    }
    
    
}
