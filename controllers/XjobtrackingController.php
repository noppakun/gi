<?php
namespace app\controllers;

use Yii;
use app\models\SelectForm;
//use app\controllers\EtableController;
/*
s10hx9e7TZZkfqqgtk2EhkcICiq7CeaCT4XlfIUUwSK
s10hx9e7TZZkfqqgtk2EhkcICiq7CeaCT4XlfIUUwSK
s10hx9e7TZZkfqqgtk2EhkcICiq7CeaCT4XlfIUUwSK
*/ 
define('LINE_API',"https://notify-api.line.me/api/notify");
define('LINE_TOKEN','s10hx9e7TZZkfqqgtk2EhkcICiq7CeaCT4XlfIUUwSK');

class XjobtrackingController extends \app\components\XETableController
{
    protected $MAIN_MODEL 	    =   'app\models\XJobtracking';    
    protected $SEARCH_MODEL     =   'app\models\XJobtrackingSearch';    
    protected $VIEWPARA      =   [
        'TABLECAPTION' =>  'Job Tracking'
    ];    
	// ----------------------------------------------------------------------------------
	function line_notify_message($message){
    // ----------------------------------------------------------------------------------		
        /*
            From : GI
            To : gpm.gi.jobtracking
            Token : DysqWO8nrzOMP0YjJTtlceZnCPSqKKzwAKRjQeMHZst
        */

 
        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData,'','&');
        $headerOptions = array(
            'http'=>array(
                'method'=>'POST',
                'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                        ."Authorization: Bearer ".LINE_TOKEN."\r\n"
                            ."Content-Length: ".strlen($queryData)."\r\n",
                'content' => $queryData
            )
        );
        $context = stream_context_create($headerOptions);
        $result = file_get_contents(LINE_API,FALSE,$context);
        $res = json_decode($result);
        return $res;
    }
 

    
    //function notify($action='',$order_no,$item_no,$component,$note,$username)   	    
		// $subject='*** '.$action.' issue ***'."  \n".
		// 	($order_no == '*' ? '' : 'Order no. : '.trim($order_no)."  \n").
		// 	($item_no  == '*' ? '' : 'Item no. : '.trim($item_no)."  \n").
		// 	'Component : '.trim($component)."  \n".
		// 	'User : '.$username;
		// $message = $note. "\n".'  ดูรายละเอียดได้ที่  : '.
        // 	'http://gi.greaterman.com'.Url::to(['prod/note', 'order_no'=>trim($order_no),'item_number'=>trim($item_no),'component'=>trim($component)]);
        
 
    public function actionNotify()
    {
        $sql = '
        select * from x_jobtracking 
            where finishdate is null
            and CAST(duedate AS DATE) = CAST(DATEADD(day, 1, GETDATE()) AS DATE)

          
          -- union    select top 1 * from x_jobtracking  -- *** for test

        ';
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        
        $rows = $command->queryAll();         



        // jobtype varchar(10),
        // detail varchar(50),
        // jobdate datetime(3),
        // duedate datetime(3),
        // finishdate datetime(3),
        // responsible_user varchar(10),
        // remark varchar(50),
        // owner_user varchar(10),
        // cancel tinyint,
        
        
		foreach($rows as $key => $row){
            $message=''                
                .'#'.$row['id'].'. '
                .date('d-m-Y', strtotime($row['duedate'])).' - '
                .$row['jobtype'].' - '
                .$row['detail'].' / '            
                .$row['responsible_user'];
            
            // echo '<br>';      echo $message; // for test

            $this->line_notify_message($message);				
 
		}
    }
    // ******************************************************************************************************
    public function actionIndex()
    {
        $SelectForm = new SelectForm();
        $SelectForm->labels['date']='วันที่บันทึก :';            
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {                            
            $SelectForm->date           = Yii::$app->request->queryParams['SelectForm']['date']; 
            $SelectForm->date2          = Yii::$app->request->queryParams['SelectForm']['date2'];             
            $SelectForm->status         = Yii::$app->request->queryParams['SelectForm']['status']; 
        }else{
            $SelectForm->date           = Yii::$app->formatter->asDate('now - 3 month');            
            $SelectForm->date2          = Yii::$app->formatter->asDate('now');
            $SelectForm->status         = 0;
        }         
        $searchModel = new $this->SEARCH_MODEL();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$SelectForm);
        $this->VIEWPARA['SelectForm'] = $SelectForm;
        // -----------------------------------------------------
        $this->VIEWPARA['searchModel'] = $searchModel;
        $this->VIEWPARA['dataProvider'] = $dataProvider;        
        
        return $this->render($this->VIEWPATH.'index', $this->VIEWPARA);

    }
    protected function afterInsert($model){

        $model->jobdate = date ('d-m-Y'); 
        $model->owner_user = Yii::$app->user->identity->username;
        $model->cancel = 0;
    
    }
    public function actionCancel($id)   
    {
      
            $model = $this->findModel($id);           
            $model->cancel = 1;
            $model->save();
            return $this->redirect(['index']);
    }

    public function actionUpdate($id=null,$viewmode=false)   
    {
        if ($id==null){ // create
            $model = new $this->MAIN_MODEL();
            // new function 28/8/2018
            $this->afterInsert($model);            
            
        }else{        
            $model = $this->findModel($id);

        }
        if ($this->MODEL_SCENARIO != 'default'){
            $model->scenario = $this->MODEL_SCENARIO;
        }

        if ($model->load(Yii::$app->request->post())) {            
           
            $model->save();

            // -----------------------------------------------------------------
            $message='#'.$model->id.' ['.(($id==null)?'Create':'Update').'] '         
            .$model->jobtype.' - '
            .$model->detail.' / '            
            .$model->responsible_user
            .' by ('.Yii::$app->user->identity->username.')';
            //echo '<br><br><br>'.$message;
            $this->line_notify_message($message);	
            // -----------------------------------------------------------------
            
            
            return $this->redirect(['index']);
        } else {
            $this->VIEWPARA['model'] = $model;
            $this->VIEWPARA['viewmode'] = $viewmode;
            return $this->render($this->VIEWPATH.'update', $this->VIEWPARA);

        }
    }      
}
