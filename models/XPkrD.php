<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_pkr_d".
 *
 * @property int $id
 * @property int $pkr_id
 * @property int $no
 * @property string $item 
 * @property string $material
 * @property string $owner
 * @property string $remark
 */
class XPkrD extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_pkr_d';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'pkr_id',
                'item','owner'
            ], 'required'],
              // 'material',  'remark',  k.jeed แจ้ง ไม่ต้องใส่ก็ได้  2/4/2020
            [['pkr_id', 'no'], 'integer'],
            [['item','material', 'owner', 'remark'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pkr_id' => 'Pkr ID',
            'no' => 'No',
            'item' => 'ITEM',    
            'material' => 'Material',        
            'owner' => 'Owner',
            'remark' => 'หมายเหตุ',
        ];
    }
}
