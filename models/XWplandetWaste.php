<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_wplandet_waste".
 *
 * @property int $id
 * @property string $tran_date
 * @property string $order_no
 * @property string $item_number
 * @property string $component
 * @property string $reason
 * @property string $qty
 * @property string $wca_code
 */
class XWplandetWaste extends \yii\db\ActiveRecord
{
    // public function getItem()
    // {
    //     return $this->hasOne(Item::className(), ['Item_Number' => 'component']);
    // }
    public function getComponent2()
    {
        
        return $this->hasOne(Item::className(), ['Item_Number' => 'component']);
         
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_wplandet_waste';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tran_date'], 'safe'],
            [['order_no', 'item_number', 'component', 'qty'], 'required'],
            [['order_no', 'item_number', 'component', 'reason','wca_code'], 'string'],
            [['qty'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tran_date' => 'วันที่บันทึก',
            'order_no' => 'Order No',
            'item_number' => 'Item Number',
            'component' => 'Component',
            'reason' => 'สาเหตุเพิ่มติม',
            'qty' => 'จำนวน',
            'wca_code' => 'Category',
        ];
    }
}




    