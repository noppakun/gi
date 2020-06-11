<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_prodnotecount".
 *
 * @property string $order_no
 * @property integer $notecount
 */
class XProdnotecount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        /*    is VIEW   */
        return 'x_prodnotecount';
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
            [['order_no'], 'required'],            
            [['item_number'], 'string'],
            [['order_no'], 'string'],
            [['notecount'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            
            'item_number' => 'Item Number',
            'order_no' => 'Order No',
            'notecount' => 'Notecount',
        ];
    }
}
