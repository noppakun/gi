<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_pif_attachedfile".
 *
 * @property int $id
 * @property int $master_id
 * @property string $filename
 * @property string $description
 * @property string $filegroup
 * 
 * @property XPif $master
 */
class XPifAttachedfile extends \yii\db\ActiveRecord
{
 
    public static $filegroup_LIST = [                                  
        'G'=>'ทั่วไป',
        'M'=>'MSDS.',
        'S'=>'SPEC.',
    ]; 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_pif_attachedfile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id'], 'integer'],
            [['filename', 'description','filegroup'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_id' => 'Master ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'filegroup' => 'Filegroup',            
        ];
    }
    public function getMaster()
    {
        return $this->hasOne(XPif::className(), ['id' => 'master_id']);
    }    
}
