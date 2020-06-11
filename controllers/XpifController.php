<?php
namespace app\controllers;

// use Yii;
// use app\models\Alarm;
// use app\models\AlarmSearch;
// use yii\web\Controller;
// use yii\web\NotFoundHttpException;
// use yii\filters\VerbFilter;
// use yii\filters\AccessControl;
// //use app\models\TimeUpload;
// use yii\web\UploadedFile;
// use app\models\FileUpload;
use Yii;
use app\models\XPif;
use app\models\XPifAttachedfile;
use yii\data\ActiveDataProvider;

// use app\models\FileUpload;
// use yii\web\UploadedFile;
 

class XpifController extends \app\components\XETableController
{
    protected $MAIN_MODEL 	    =   'app\models\XPif';    
    protected $SEARCH_MODEL     =   'app\models\XPifSearch';    
    protected $VIEWPARA      =   [
        'TABLECAPTION' =>  'PRODUCT INFORMATION FILE'
    ];  


    public function actionRead()
    {
        $searchModel = new $this->SEARCH_MODEL();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,true);

        $this->VIEWPARA['searchModel'] = $searchModel;
        $this->VIEWPARA['dataProvider'] = $dataProvider;        
        return $this->render($this->VIEWPATH.'read', $this->VIEWPARA);
    }

    public function actionApprove($id)
    {
        //$model = XPif::findOne($id);
        $model = $this->findModel($id);                    
        $model->approve_datetime = date('Y-m-d H:i:s');
        $model->save();        
        return $this->redirect(['index']); 
    }

    public function actionDeleteattached($id,$idh)
    {
        $model = XPifAttachedfile::findOne($id);                   
        $model->delete();        
        return $this->redirect(['createattached','idh'=>$idh]); 
    }

    public function actionUpdateattached($id=null,$idh,$viewmode=false)   
    {
        if ($id==null){ // create
            $model = new XPifAttachedfile();
            $model->master_id = $idh;
            $model->filegroup = 'G';
        }else{        
            $model = XPifAttachedfile::findOne($id);            
        }
 
        if ($model->load(Yii::$app->request->post())) {            
  
            $model->save();
            return $this->redirect(['createattached','idh'=>$idh]);
        } else {

 /*
            $query = XPifAttachedfile::find()->andFilterWhere(['master_id' => $idh]);
            $modellist = new ActiveDataProvider([
                'query' => $query,
            ]);
*/
 
            $modellist = new ActiveDataProvider([
                'query' => ($this->findModel($idh))->getXPifAttachedfiles(),
            ]);

            $this->VIEWPARA['modelh'] = $this->findModel($idh);
            $this->VIEWPARA['model'] = $model;
            $this->VIEWPARA['modellist'] = $modellist;
            $this->VIEWPARA['viewmode'] = $viewmode;
            return $this->render($this->VIEWPATH.'update_attached', $this->VIEWPARA);

        }
    }   
    public function actionCreateattached ($idh) { //actionCreate
        return $this->actionUpdateattached(null,$idh);
        
    }

    public function actionViewattached ($id,$idh) {
        $model = XPifAttachedfile::findOne($id); 
        //$modelh = XPif::findOne($idh); 
        $modelh = $this->findModel($idh);        
        
        $path = [
            'G'=>$modelh->pif_id,
            'M'=>'msds',
            'S'=>'spec',
        ];
        
        
        $fileName=$model->filename;
        // for Thai file name
        //$fileName=iconv('UTF-8','TIS-620', $model->filename) ;
        
        // ***** windows web application server
        //$filePath = '\\\\fileserver\\iso_gpm\\pif\\'.$path[$model->filegroup].'\\'; 
        

        // ***** linux web application server
        $filePath = '/media/pif/'.$path[$model->filegroup].'/';         


        $completePath = Yii::getAlias($filePath.$fileName);       
    
        return Yii::$app->response->sendFile($completePath, $fileName,[
           // 'mimeType' => 'image/png',
            'inline' => true,
        ]);


    }    

   
    public function actionUpdate($id=null,$viewmode=false)   
    {
        if ($id==null){ // create
            $model = new $this->MAIN_MODEL();
        }else{        
            $model = $this->findModel($id);            
        }
        $model->scenario = $this->MODEL_SCENARIO;        
        if ($model->load(Yii::$app->request->post())) {                        
            $isNew = ($model->id == null);
            $model->save();
            if($isNew){
                return $this->redirect(['createattached','idh'=>$model->id]);
            }else{
                return $this->redirect(['index']);
            }
        } else {
            $this->VIEWPARA['model'] = $model;
            $this->VIEWPARA['viewmode'] = $viewmode;
            return $this->render($this->VIEWPATH.'update', $this->VIEWPARA);

        }
    }      
    


}
