<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SaleDet".
 *
 * @property string $CompanyCode
 * @property string $Sale_Number
 * @property int $Seq_Number
 * @property string $Item_Number
 * @property string $Due_Date
 * @property string $Order_Qty
 * @property string $Rlse_Qty
 * @property string $Price
 * @property string $SaleDet_Desc
 * @property string $Uom
 * @property int $Sale_Close
 * @property string $Promise_Delivery_Date
 * @property string $Inform_Date
 * @property string $Production_Date_Complete
 * @property string $Order_Status
 * @property string $Balance_Date
 * @property string $Inv_Qty
 * @property string $Disc_Percent
 * @property string $Disc_Cash
 * @property string $Confirm_Price
 * @property string $Remark
 */
class SaleDet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SaleDet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'Sale_Number', 'Seq_Number', 'Item_Number', 'Sale_Close'], 'required'],
            [['CompanyCode', 'Sale_Number', 'Item_Number', 'SaleDet_Desc', 'Uom', 'Order_Status', 'Remark'], 'string'],
            [['Seq_Number', 'Sale_Close'], 'integer'],
            [['Due_Date', 'Promise_Delivery_Date', 'Inform_Date', 'Production_Date_Complete', 'Balance_Date'], 'safe'],
            [['Order_Qty', 'Rlse_Qty', 'Price', 'Inv_Qty', 'Disc_Percent', 'Disc_Cash', 'Confirm_Price'], 'number'],
            [['CompanyCode', 'Item_Number', 'Sale_Number', 'Seq_Number'], 'unique', 'targetAttribute' => ['CompanyCode', 'Item_Number', 'Sale_Number', 'Seq_Number']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'Sale_Number' => 'Sale  Number',
            'Seq_Number' => 'Seq  Number',
            'Item_Number' => 'Item  Number',
            'Due_Date' => 'Due  Date',
            'Order_Qty' => 'Order  Qty',
            'Rlse_Qty' => 'Rlse  Qty',
            'Price' => 'Price',
            'SaleDet_Desc' => 'Sale Det  Desc',
            'Uom' => 'Uom',
            'Sale_Close' => 'Sale  Close',
            'Promise_Delivery_Date' => 'Promise  Delivery  Date',
            'Inform_Date' => 'Inform  Date',
            'Production_Date_Complete' => 'Production  Date  Complete',
            'Order_Status' => 'Order  Status',
            'Balance_Date' => 'Balance  Date',
            'Inv_Qty' => 'Inv  Qty',
            'Disc_Percent' => 'Disc  Percent',
            'Disc_Cash' => 'Disc  Cash',
            'Confirm_Price' => 'Confirm  Price',
            'Remark' => 'Remark',
        ];
    }
}
