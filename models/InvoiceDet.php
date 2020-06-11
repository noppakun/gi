<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "InvoiceDet".
 *
 * @property string $CompanyCode
 * @property string $Inv_Number
 * @property integer $Seq_Number
 * @property string $Item_Number
 * @property string $InvDet_Desc
 * @property string $Uom
 * @property string $Order_Qty
 * @property string $Price
 * @property string $Batch_No
 * @property string $Disc_Percent
 * @property string $Disc_Cash
 * @property integer $Type_Desc
 * @property string $WhCode
 * @property string $Location
 * @property integer $IssueStatus
 * @property integer $DescStatus
 */
class InvoiceDet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'InvoiceDet';
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
            [['CompanyCode', 'Inv_Number', 'Seq_Number', 'Order_Qty', 'Price', 'Type_Desc'], 'required'],
            [['CompanyCode', 'Inv_Number', 'Item_Number', 'InvDet_Desc', 'Uom', 'Batch_No', 'WhCode', 'Location'], 'string'],
            [['Seq_Number', 'Type_Desc', 'IssueStatus', 'DescStatus'], 'integer'],
            [['Order_Qty', 'Price', 'Disc_Percent', 'Disc_Cash'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'Inv_Number' => 'Inv  Number',
            'Seq_Number' => 'Seq  Number',
            'Item_Number' => 'Item  Number',
            'InvDet_Desc' => 'Inv Det  Desc',
            'Uom' => 'Uom',
            'Order_Qty' => 'Order  Qty',
            'Price' => 'Price',
            'Batch_No' => 'Batch  No',
            'Disc_Percent' => 'Disc  Percent',
            'Disc_Cash' => 'Disc  Cash',
            'Type_Desc' => 'Type  Desc',
            'WhCode' => 'Wh Code',
            'Location' => 'Location',
            'IssueStatus' => 'Issue Status',
            'DescStatus' => 'Desc Status',
        ];
    }
}
