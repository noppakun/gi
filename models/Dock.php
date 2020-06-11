<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Dock".
 *
 * @property integer $Dock_Number
 * @property string $CompanyCode
 * @property string $VoucherNo
 * @property string $Do_Number
 * @property string $Order_Number
 * @property string $Item_Number
 * @property string $Vessel
 * @property string $Awb
 * @property string $Inv
 * @property string $Inv_Date
 * @property string $Recd_Qty
 * @property string $Acc_Qty
 * @property string $Mfg_date
 * @property string $Exp_Date
 * @property string $Rej_Qty
 * @property string $Due_Date
 * @property string $Recd_Date
 * @property string $Acc_Date
 * @property string $WhCode
 * @property string $Loc_Number
 * @property string $Ana_No
 * @property string $Uom
 * @property string $Supplier_Lot
 * @property string $UnitPrice
 * @property string $SumPrice
 * @property string $Remark
 * @property string $PackDetail
 * @property string $Dock_Print
 * @property string $Dock_Status
 * @property integer $Seq_Number
 * @property string $UserName
 * @property string $Remark_Approve
 * @property string $QA_StartDateTime
 * @property string $QA_StopDateTime
 * @property string $QA_MachCode
 * @property string $EffectiveDate
 * @property string $RecvDocDate
 * @property string $BranchCode
 * @property string $SpecNo
 * @property string $UserName_Approve
 * @property string $Score
 * @property string $Score_PH
 * @property string $Kpidte1
 * @property string $KpiDte2
 */
class Dock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Dock';
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
            [['Dock_Number', 'CompanyCode', 'VoucherNo', 'Order_Number', 'Item_Number', 'Dock_Print', 'Dock_Status'], 'required'],
            [['Dock_Number', 'Seq_Number'], 'integer'],
            [['CompanyCode', 'VoucherNo', 'Do_Number', 'Order_Number', 'Item_Number', 'Vessel', 'Awb', 'Inv', 'WhCode', 'Loc_Number', 'Ana_No', 'Uom', 'Supplier_Lot', 'Remark', 'PackDetail', 'Dock_Print', 'Dock_Status', 'UserName', 'Remark_Approve', 'QA_MachCode', 'BranchCode', 'SpecNo', 'UserName_Approve', 'Score', 'Score_PH'], 'string'],
            [['Inv_Date', 'Mfg_date', 'Exp_Date', 'Due_Date', 'Recd_Date', 'Acc_Date', 'QA_StartDateTime', 'QA_StopDateTime', 'EffectiveDate', 'RecvDocDate', 'Kpidte1', 'KpiDte2'], 'safe'],
            [['Recd_Qty', 'Acc_Qty', 'Rej_Qty', 'UnitPrice', 'SumPrice'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Dock_Number' => 'Dock  Number',
            'CompanyCode' => 'Company Code',
            'VoucherNo' => 'Voucher No',
            'Do_Number' => 'Do  Number',
            'Order_Number' => 'Order  Number',
            'Item_Number' => 'Item  Number',
            'Vessel' => 'Vessel',
            'Awb' => 'Awb',
            'Inv' => 'Inv',
            'Inv_Date' => 'Inv  Date',
            'Recd_Qty' => 'Recd  Qty',
            'Acc_Qty' => 'Acc  Qty',
            'Mfg_date' => 'Mfg Date',
            'Exp_Date' => 'Exp  Date',
            'Rej_Qty' => 'Rej  Qty',
            'Due_Date' => 'Due  Date',
            'Recd_Date' => 'Recd  Date',
            'Acc_Date' => 'Acc  Date',
            'WhCode' => 'Wh Code',
            'Loc_Number' => 'Loc  Number',
            'Ana_No' => 'Ana  No',
            'Uom' => 'Uom',
            'Supplier_Lot' => 'Supplier  Lot',
            'UnitPrice' => 'Unit Price',
            'SumPrice' => 'Sum Price',
            'Remark' => 'Remark',
            'PackDetail' => 'Pack Detail',
            'Dock_Print' => 'Dock  Print',
            'Dock_Status' => 'Dock  Status',
            'Seq_Number' => 'Seq  Number',
            'UserName' => 'User Name',
            'Remark_Approve' => 'Remark  Approve',
            'QA_StartDateTime' => 'Qa  Start Date Time',
            'QA_StopDateTime' => 'Qa  Stop Date Time',
            'QA_MachCode' => 'Qa  Mach Code',
            'EffectiveDate' => 'Effective Date',
            'RecvDocDate' => 'Recv Doc Date',
            'BranchCode' => 'Branch Code',
            'SpecNo' => 'Spec No',
            'UserName_Approve' => 'User Name  Approve',
            'Score' => 'Score',
            'Score_PH' => 'Score  Ph',
            'Kpidte1' => 'Kpidte1',
            'KpiDte2' => 'Kpi Dte2',
        ];
    }
}
