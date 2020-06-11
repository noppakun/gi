<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "QuoteDet".
 *
 * @property string $CompanyCode
 * @property string $Quote
 * @property integer $Seq_Number
 * @property string $Item_Number
 * @property string $Item_Desc
 * @property string $UnitPrice
 * @property string $Uom
 * @property string $Discount
 * @property string $Per_Qty
 */
class QuoteDet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'QuoteDet';
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
            [['CompanyCode', 'Quote', 'Seq_Number'], 'required'],
            [['CompanyCode', 'Quote', 'Item_Number', 'Item_Desc', 'Uom'], 'string'],
            [['Seq_Number'], 'integer'],
            [['UnitPrice', 'Discount', 'Per_Qty'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'Quote' => 'Quote',
            'Seq_Number' => 'Seq  Number',
            'Item_Number' => 'Item  Number',
            'Item_Desc' => 'Item  Desc',
            'UnitPrice' => 'Unit Price',
            'Uom' => 'Uom',
            'Discount' => 'Discount',
            'Per_Qty' => 'Per  Qty',
        ];
    }
}
