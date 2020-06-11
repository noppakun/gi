<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_wplandet_ext".
 *
 * @property int $id
 * @property string $order_no
 * @property string $item_number
 * @property string $netfill
 * @property string $uom
 * @property string $mh_c_no
 * @property string $mh_c_hp
 * @property string $mh_c_ac
 * @property string $mh_w_no
 * @property string $mh_w_hp
 * @property string $mh_w_ac
 * @property string $mh_p_no
 * @property string $mh_p_hp
 * @property string $mh_p_ac
 */
class XWplandetExt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_wplandet_ext';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_no', 'item_number', 'uom'], 'required'],
            [['order_no', 'item_number', 'uom'], 'string'],
            [['netfill', 'mh_c_no', 'mh_c_hp', 'mh_c_ac', 'mh_w_no', 'mh_w_hp', 'mh_w_ac', 'mh_p_no', 'mh_p_hp', 'mh_p_ac'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'Order No',
            'item_number' => 'Item Number',
            'netfill' => 'Netfill',
            'uom' => 'Uom',
            'mh_c_no' => 'Man Hour Coding No Of Operators',
            'mh_c_hp' => 'Man Hour Coding Hours Paid',
            'mh_c_ac' => 'Man Hour Coding Actual',
            'mh_w_no' => 'Man Hour Washing No Of Operators',
            'mh_w_hp' => 'Man Hour Washing Hours Paid',
            'mh_w_ac' => 'Man Hour Washing Actual',
            'mh_p_no' => 'Man Hour Packing No Of Operators',
            'mh_p_hp' => 'Man Hour Packing Hours Paid',
            'mh_p_ac' => 'Man Hour Packing Actual',
        ];
    }
} 