<?php
namespace app\modules\dbma\controllers;
use Yii;

use app\models\TimeUpload;
use yii\web\UploadedFile;

class AlarmController extends \app\components\XQEdit\XQEditController
{
 
 
    protected $MAIN_MODEL 	    =   'app\models\Alarm';    
 

    public function actionTimedownload()
    {
        if( file_exists("uploads/newtime.txt" ) ){
           Yii::$app->response->sendFile( "uploads/newtime.txt" );
        }   

    }     
    public function actionTimeconvert()
    {
        $model = new TimeUpload();

        if (Yii::$app->request->isPost) {
            $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return $this->render('upload', ['model' => $model,'download'=>true]);
            }
        }

        return $this->render('upload', ['model' => $model,'download'=>false]);
    }
 
    public function actionAlarmtable()
    {

        $alarm = Alarm::find()->where(['active' => 1]);
/*
        $sql = 'SELECT * FROM alarm WHERE status=:status';
        $alarm = Customer::findBySql($sql, [':status' => Customer::STATUS_INACTIVE])->all();        

*/
        $alarmstr='';

       //  $alarm = Customer::findBySql($sql, [':status' => Customer::STATUS_INACTIVE])->all();   


         

        
        foreach (Alarm::find()->where(['active' => 1])->all() as $falarm) {

            $alarmstr=$alarmstr.'hm=['
            .($falarm->hour*100+$falarm->minute).']pr=['
            .$falarm->period.']'
            ."\r\n";
     
        }        

        return $alarmstr;
    }    
 
 
 
}
