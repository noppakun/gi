<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ItemLoc".
 *
 * @property string $Item_Number
 * @property string $WhCode
 * @property string $Location_number
 * @property string $Ana_No
 * @property string $Ana_Qty
 * @property string $Mfg_Date
 * @property string $Exp_Date
 * @property string $Issue
 * @property string $Receipt
 * @property string $Status
 * @property string $UnitPrice
 * @property string $SumPrice
 * @property string $Bin
 * @property string $Quarantine
 * @property string $Remark
 * @property string $Remark_General
 * @property string $LastTest_Date
 * @property string $SaleReserved
 * @property string $EffectiveDate
 * @property string $Waste_Qty
 * @property string $Defective_Qty
 * @property string $Good_Qty
 * @property string $LastUpdateBin
 * @property string $NotIssueQty
 * @property string $ReportNo
 * @property integer $loc_typ
 * @property string $St_qty
 */
class ItemLoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ItemLoc';
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
            [['Item_Number', 'WhCode', 'Location_number', 'Ana_No', 'Status'], 'required'],
            [['Item_Number', 'WhCode', 'Location_number', 'Ana_No', 'Status', 'Bin', 'Remark', 'Remark_General', 'ReportNo'], 'string'],
            [['Ana_Qty', 'Issue', 'Receipt', 'UnitPrice', 'SumPrice', 'Quarantine', 'SaleReserved', 'Waste_Qty', 'Defective_Qty', 'Good_Qty', 'NotIssueQty', 'St_qty'], 'number'],
            [['Mfg_Date', 'Exp_Date', 'LastTest_Date', 'EffectiveDate', 'LastUpdateBin'], 'safe'],
            [['loc_typ'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Item_Number' => 'รหัสสินค้า',
            'WhCode' => 'คลัง',
            'Location_number' => 'Location Number',
            'Ana_No' => 'Ana No',
            'Ana_Qty' => 'คงเหลือ',
            'Mfg_Date' => 'วันที่ผลิต',
            'Exp_Date' => 'วันที่หมดอายุ',
            'Issue' => 'Issue',
            'Receipt' => 'Receipt',
            'Status' => 'Status',
            'UnitPrice' => 'ราคาต่อหน่วย',
            'SumPrice' => 'Sum Price',
            'Bin' => 'Bin',
            'Quarantine' => 'Quarantine',
            'Remark' => 'Remark',
            'Remark_General' => 'Remark  General',
            'LastTest_Date' => 'Last Test  Date',
            'SaleReserved' => 'SaleReserved[ยอดจอง]',
            'EffectiveDate' => 'Effective Date',
            'Waste_Qty' => 'Waste  Qty',
            'Defective_Qty' => 'Defective  Qty',
            'Good_Qty' => 'Good  Qty',
            'LastUpdateBin' => 'Last Update Bin',
            'NotIssueQty' => 'Not Issue Qty',
            'ReportNo' => 'Report No',
            'loc_typ' => 'Loc Typ',
            'St_qty' => 'St Qty',
        ];
    }
}
