<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_prd".
 *
 * @property int $id
 * @property string $doc_no
 * @property string|null $item_code
 * @property string|null $item_desc
 * @property float|null $qty
 * @property string|null $uom
 * @property float|null $price
 * @property string|null $remark
 */
class XPrd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_prd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_no'], 'required'],
            [['qty', 'price'], 'number'],
            [['doc_no'], 'string', 'max' => 12],
            [['item_code'], 'string', 'max' => 20],
            [['item_desc', 'remark'], 'string', 'max' => 100],
            [['uom'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doc_no' => 'Pr Doc No',
            'item_code' => 'Item Code',
            'item_desc' => 'Item Desc',
            'qty' => 'Qty',
            'uom' => 'Uom',
            'price' => 'Price',
            'remark' => 'Remark',
        ];
    }
}
