<?php

namespace app\models;

use Yii;
use \app\components\XLib;
/**
 * This is the model class for table "x_jobtracking".
 *
 * @property int $id
 * @property string $jobtype
 * @property string $detail
 * @property string $jobdate
 * @property string $duedate
 * @property string $finishdate
 * @property string $responsible_user
 * @property string $remark
 * @property string $owner_user
 * @property int $cancel
 */

class XJobtracking extends \yii\db\ActiveRecord
{
   
    const STATUS_OPEN   = 1;                                          
    const STATUS_FINISH = 2;        
    const STATUS_CANCEL = 3;            
    public static $status_LIST = [                                          
        1=>'ดำเนินการ',  //  -เหลือง
        2=>'เสร็จสิ้น',    // -เขียว/แดง
        3=>'ยกเลิก',     // -ขาว
    ];
    
    const PERFORMANCE_NORMAL = 1;
    const PERFORMANCE_OVERDUE = 2;
    const PERFORMANCE_NA = 3;
    public static $performance_LIST = [                                          
        1=>'N',   
        2=>'O',     
        3=>'-',  // ยังไม่เสร็จ  not available 
 
    ];     
    public static $performance_LIST2 = [                                          
 
        1=>'ปกติ',   
        2=>'เกินกำหนด',     
        3=>'-',  // ยังไม่เสร็จ  not available 
    ];  
    public function getCalStatus() 
    {        
        return  $this->cancel ? self::STATUS_CANCEL :
            (($this->finishdate==null) ? self::STATUS_OPEN:self::STATUS_FINISH) ;                          
    } 
    public function getCalStatusText() 
    {                
        return self::$status_LIST[$this->calStatus];   
    }     
    public function getCalPerformance(){        
        return $this->finishdate==null ? self::PERFORMANCE_NA :(             (
                date('Y-m-d', strtotime(str_replace('/', '-', $this->finishdate))) 
                <= date('Y-m-d', strtotime(str_replace('/', '-', $this->duedate)))                        
            ) ?  self::PERFORMANCE_NORMAL: self::PERFORMANCE_OVERDUE );    
    }
    public function getCalPerformanceText(){
        return self::$performance_LIST[$this->calPerformance];    
    }
    public function getCalPerformanceText2(){
        return self::$performance_LIST2[$this->calPerformance];    
    }
    /**
     * {@inheritdoc}
     */
 

    public function afterFind(){

        parent::afterFind();
        $this->jobdate = XLib::dateConv($this->jobdate,'a');
        $this->duedate = XLib::dateConv($this->duedate,'a');
        $this->finishdate = XLib::dateConv($this->finishdate,'a');
 
    }
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->jobdate = XLib::dateConv($this->jobdate,'b');
        $this->duedate = XLib::dateConv($this->duedate,'b');
        $this->finishdate = XLib::dateConv($this->finishdate,'b');
        return true;
    }    

    public static function tableName()
    {
        return 'x_jobtracking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jobtype', 'detail', 'responsible_user', 'remark', 'owner_user'], 'string'],
            [['jobdate', 'duedate', 'finishdate'], 'safe'],
            [['cancel'], 'integer'],
           
        ];
        
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Job Id.',
            'jobtype' => 'ประเภท',
            'detail' => 'รายละเอียด',
            'jobdate' => 'วันที่บันทึก',
            'duedate' => 'กำหนดส่ง',
            'finishdate' => 'วันที่ส่ง',
            'responsible_user' => 'ผู้รับผิดชอบ',
            'remark' => 'หมายเหตุ',
            // 'status' => 'สถานะ',
            // 'performance' => 'ประสิทธิภาพ',
            'owner_user' => 'เจ้าของงาน',
            'cancel'=>'ยกเลิก',
            // ------------------------------
            'calStatusText'=>'Status',
            'calPerformanceText' => 'P',
            'calPerformanceText2' => 'ประสิทธิภาพ',
        ];
    }
}
