<?php

namespace app\models;

use Yii;
 
/**
 * This is the model class for table "x_pif".
 *
 * @property int $id
 * @property string $pif_id
 * @property string $pif_name
 * @property string $description
 * @property string $approve_datetime
 * @property string $items_ref
 * 
 * @property XPifAttachedfile[] $xPifAttachedfiles
 */
class XPif extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $attachFile;

    public static function tableName()
    {
        return 'x_pif';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pif_id', 'pif_name', 'description','items_ref'], 'string'],
            [['approve_datetime'], 'safe'],
             
        ];

    
    }
 
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pif_id' => 'เลขที่ใบรับจดแจ้ง',
            'pif_name' => 'ชื่อการค้า',
            'description' => 'Description',
            'approve_datetime' => 'Approve Datetime',            
            'items_ref' => 'Items Reference',   
        ];
    }
    public function getXPifAttachedfiles()
    {
        return $this->hasMany(XPifAttachedfile::className(), ['master_id' => 'id']);
    }    
}
