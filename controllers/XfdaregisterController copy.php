<?php
namespace app\controllers;

use Yii;
use kartik\builder\Form;
 
//class XfdaregisterController extends \app\components\XETableController

class XfdaregisterController extends \app\components\XQEdit\XQEditController

{
    protected $MAIN_MODEL 	    =   'app\models\XFdaregister';        
    public function init()  
    {
        parent::init();
        $this->VIEWPARA['TABLECAPTION'] = 'ทะเบียน อย.';
        $this->VIEWPARA['XQEDIT']['properties']=[
   
            'pjax'=>true,
            'pjaxSettings'=>[
                'neverTimeout'=>true,
               
                'afterGrid'=>'<span class="label label-warning">หมดอายุใน 30 วัน</span>'
                                .'<span class="label label-danger" >ทะเบียนยกเลิก</span>',
        
            ]
        ];

        
        $this->VIEWPARA['XQEDIT']['index_rowoptions']=function($model){            
            if($model->canceldate  != null){
                
                return ['class' => 'danger'];
                 
            } else {
                $datetime1 = date_create(Yii::$app->formatter->asDate('now'));    
                $datetime2 = date_create($model->expdate);               
                $interval = date_diff($datetime1, $datetime2);           
                if($interval->format('%a')<=30){
                    return ['style' => 'background-color:#ffe6b3'];
                }                           
            }
        };
   
        $this->VIEWPARA['XQEDIT']['index_columns'] = [
 
            [
                'attribute'=>'regno',                 
                'contentOptions' => ['width'=>150],
            ],          
            [
                'attribute'=>'regname', 
            ],            
            [
                'attribute'=>'recdate',
                'format' => ['date'],
                'contentOptions' => ['width'=>100],
            ],
            [
                'attribute'=>'expdate',
                'format' => ['date'],
                'contentOptions' => ['width'=>100],
            ],
            [
                'attribute'=>'canceldate',             
                'hAlign'=>'center',
                'value'=>function($model){
                    return $model->canceldate === null ? '-':$model->canceldate;

                },
                'contentOptions' => ['width'=>100],                
                'contentOptions' => ['style' => 'width:100px;'],
            ],          
        ];
        $this->VIEWPARA['XQEDIT']['update_columns'] = [
   
            'regno',
            'regname'=>[
                'type'=>Form::INPUT_TEXT,
                'columnOptions'=>['colspan'=>2],                
            ],            
                
            [
                'columns'=>3,
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
                    'canceldate'=> [
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
    }    

    
    //--------------------------------    
    //--------------------------------    
    //--------------------------------
    private $notifyMailList = [
        'noppakun@greaterman.com',
        'tassanai@greaterman.com',
        'siriwan@greaterman.com',
        'jutaporn@greaterman.com'
    ];

	// ----------------------------------------------------------------------------------
	function mail_notify_message($subject,$message)
	// ----------------------------------------------------------------------------------
	{
	
		Yii::$app->mailer->compose()
		->setFrom('itadmin@greaterman.com')
        ->setTo($this->notifyMailList)
		->setSubject($subject)
		->setTextBody($message)            
		->send();		
    }    
    function notify($dayreminder)   {
    /*	
        * @property int $id
        * @property string $regno
        * @property string $regname
        * @property string $recdate
        * @property string $expdate
        * @property string $canceldate
        */

        $sql = '
            declare @dayreminder int
            set @dayreminder = 30
            set @dayreminder = :dayreminder
            select  * 
            from x_fdaregister 
            where (canceldate is null)
                and (DATEDIFF ( day , getdate() , expdate ) <=  @dayreminder)
                and ((DATEDIFF ( day ,  lastnotifydate ,getdate()) >= @dayreminder) or (lastnotifydate is null))
        
        ';
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $command->bindParam(":dayreminder",$dayreminder);

        $rows = $command->queryAll();         
        \app\components\XLib::xprint_r($rows);
		foreach($rows as $key => $row){
 
            $subject='*** ใบจดแจ้งเลขที่ : '.$row['regno'].'  หมดอายุวันที่ : '
            .\app\components\XLib::dateConv($row['expdate'],'a')
            .' ***';
            $message = $subject. "\n\n".$row['regno'].'  '.$row['regname'];

            $this->mail_notify_message($subject,$message); 		 		

            $model = \app\models\XFdaregister::findOne($row['id']);
            $model->lastnotifydate=date ('d-m-Y');            

            $model->save();
 
        }	
        // ***************************
        // ***** for audit event *****
        // ***************************
		Yii::$app->mailer->compose()
		    ->setFrom('itadmin@greaterman.com')
            ->setTo(['itadmin@greaterman.com'])            
		    ->setSubject('gi exec : ['.Yii::$app->controller->id.'/'.$this->action->id.'] $dayreminder : '.$dayreminder)
            ->send();		
        // ***************************
    }
	// ----------------------------------------------------------------------------------
	function actionNotify()   
	// ----------------------------------------------------------------------------------
	{	
        $this->notify(60);
        $this->notify(30);    
	}    
}



