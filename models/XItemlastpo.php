<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_itemlastpo".
 *
 * @property string $item_number
 * @property string $order_qty
 * @property string $price
 * @property string $order_number
 * @property string $order_date
 */
class XItemlastpo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_itemlastpo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_number', 'order_number'], 'string'],
            [['order_qty', 'price'], 'number'],
            [['order_number', 'order_date'], 'required'],
            [['order_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_number' => 'Item Number',
            'order_qty' => 'Order Qty',
            'price' => 'Price',
            'order_number' => 'Order Number',
            'order_date' => 'Order Date',
        ];
    }
}
