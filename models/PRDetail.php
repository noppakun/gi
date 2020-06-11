<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PRDetail".
 *
 * @property string $CompanyCode
 * @property string $PR_Number
 * @property int $Seq_Number
 * @property string $Item_Number
 * @property string $Due_Date
 * @property string $Order_Qty
 * @property string $Rlse_Date
 * @property string $Price
 * @property string $PRDet_Desc
 * @property string $Uom
 * @property string $Rlse_Qty
 * @property string $Recd_Qty
 * @property int $Type_Desc
 * @property string $PO_Qty
 * @property int $PO_Issue
 * @property string $score
 * @property string $revdte1
 * @property string $revdte2
 */
class PRDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'PRDetail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'PR_Number', 'Seq_Number', 'Order_Qty', 'Price', 'Type_Desc'], 'required'],
            [['CompanyCode', 'PR_Number', 'Item_Number', 'PRDet_Desc', 'Uom', 'score'], 'string'],
            [['Seq_Number', 'Type_Desc', 'PO_Issue'], 'integer'],
            [['Due_Date', 'Rlse_Date', 'revdte1', 'revdte2'], 'safe'],
            [['Order_Qty', 'Price', 'Rlse_Qty', 'Recd_Qty', 'PO_Qty'], 'number'],
            [['CompanyCode', 'PR_Number', 'Seq_Number'], 'unique', 'targetAttribute' => ['CompanyCode', 'PR_Number', 'Seq_Number']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'PR_Number' => 'Pr  Number',
            'Seq_Number' => 'Seq  Number',
            'Item_Number' => 'รหัสสินค้า',
            'Due_Date' => 'Due Date',
            'Order_Qty' => 'จำนวน',
            'Rlse_Date' => 'Rlse  Date',
            'Price' => 'Price',
            'PRDet_Desc' => 'รายการ',
            'Uom' => 'หน่วย',
            'Rlse_Qty' => 'Rlse  Qty',
            'Recd_Qty' => 'Recd  Qty',
            'Type_Desc' => 'Type  Desc',
            'PO_Qty' => 'จำนวนที่เปิด PO. แล้ว',
            'PO_Issue' => 'Po  Issue',
            'score' => 'Score',
            'revdte1' => 'Revdte1',
            'revdte2' => 'Revdte2',
        ];
    }
}
