<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_prodnote".
 *
 * @property integer $id
 * @property string $order_no
 * @property string $item_no
 * @property string $component
 * @property string $note
 * @property string $username
 * @property string $tr_datetime
 * @property string $status
 */
class XProdnote extends \yii\db\ActiveRecord
{
    public $allorder;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'x_prodnote';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('erpdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_no', 'item_no', 'component', 'note', 'username','status','allorder'], 'string'],
            [['tr_datetime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'Order No',
            'item_no' => 'Item No',
            'component' => 'Component',
            'note' => 'Note',
            'username' => 'Username',
            'tr_datetime' => 'Tr Datetime',
            'status' => 'Status',
            'allorder' => 'All Order'

        ];
    }
}
