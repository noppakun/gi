<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ApCNDetail".
 *
 * @property string $CompanyCode
 * @property string $ApCN_Number
 * @property int $Seq_Number
 * @property string $Item_Number
 * @property string $ApCNDet_Desc
 * @property string $Uom
 * @property string $Order_Qty
 * @property string $Price
 * @property string $Disc_Percent
 * @property string $Disc_Cash
 * @property string $SumPrice
 * @property int $Type_Desc
 * @property string $Voucher_SumPrice
 * @property string $AccountCode
 */
class ApCNDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ApCNDetail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'ApCN_Number', 'Seq_Number', 'Type_Desc'], 'required'],
            [['CompanyCode', 'ApCN_Number', 'Item_Number', 'ApCNDet_Desc', 'Uom', 'AccountCode'], 'string'],
            [['Seq_Number', 'Type_Desc'], 'integer'],
            [['Order_Qty', 'Price', 'Disc_Percent', 'Disc_Cash', 'SumPrice', 'Voucher_SumPrice'], 'number'],
            [['ApCN_Number', 'CompanyCode', 'Seq_Number'], 'unique', 'targetAttribute' => ['ApCN_Number', 'CompanyCode', 'Seq_Number']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'ApCN_Number' => 'Ap Cn  Number',
            'Seq_Number' => 'Seq  Number',
            'Item_Number' => 'Item  Number',
            'ApCNDet_Desc' => 'Ap Cndet  Desc',
            'Uom' => 'Uom',
            'Order_Qty' => 'Order  Qty',
            'Price' => 'Price',
            'Disc_Percent' => 'Disc  Percent',
            'Disc_Cash' => 'Disc  Cash',
            'SumPrice' => 'Sum Price',
            'Type_Desc' => 'Type  Desc',
            'Voucher_SumPrice' => 'Voucher  Sum Price',
            'AccountCode' => 'Account Code',
        ];
    }
}
