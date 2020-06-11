<?php

namespace app\models;

use Yii;
use \app\components\XLib;
/**
 * This is the model class for table "x_fdaregister".
 *
 * @property int $id
 * @property string $regno
 * @property string $regname
 * @property string $recdate
 * @property string $expdate
 * @property string $canceldate
 * @property string $lastnotifydate
 */



class XFdaregister extends \yii\db\ActiveRecord
{

 

    public function afterFind(){
        parent::afterFind();
        $this->recdate = XLib::dateConv($this->recdate,'a');
        $this->expdate = XLib::dateConv($this->expdate,'a');
        $this->canceldate = XLib::dateConv($this->canceldate,'a'); 
        $this->lastnotifydate = XLib::dateConv($this->lastnotifydate,'a'); 
        
    }



    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->recdate = XLib::dateConv($this->recdate,'b');
        $this->expdate = XLib::dateConv($this->expdate,'b');
        $this->canceldate = XLib::dateConv($this->canceldate,'b');
        $this->lastnotifydate = XLib::dateConv($this->lastnotifydate,'b');
        return true;
    } 
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_fdaregister';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['regno', 'regname'], 'string'],
            [['recdate', 'expdate', 'canceldate','lastnotifydate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regno' => 'เลขที่จดแจ้ง',
            'regname' => 'ซื่อสินค้า',
            'recdate' => 'วันที่รับใบจดแจ้ง',
            'expdate' => 'วันที่หมดอายุ',
            'canceldate' => 'วันที่ยกเลิก',
            'lastnotifydate'=>'วันที่เตือนล่าสุด',
        ];
    }
}
