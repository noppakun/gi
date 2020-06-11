<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ItemBatch".
 *
 * @property string $Item_number
 * @property string $Batch_Date
 * @property int $Batch
 * @property string $DocType_Recv
 * @property string $VoucherNo_Recv
 * @property string $WhCode
 * @property string $Loc_number
 * @property string $Ana_No
 * @property string $Ana_Qty
 * @property string $Ori_Qty
 * @property string $QOh
 * @property string $Cost
 * @property string $DocType_Issue
 * @property string $Voucherno_Issue
 */
class ItemBatch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ItemBatch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Item_number', 'Batch_Date', 'Batch', 'DocType_Recv', 'VoucherNo_Recv', 'WhCode', 'Loc_number'], 'required'],
            [['Item_number', 'DocType_Recv', 'VoucherNo_Recv', 'WhCode', 'Loc_number', 'Ana_No', 'DocType_Issue', 'Voucherno_Issue'], 'string'],
            [['Batch_Date'], 'safe'],
            [['Batch'], 'integer'],
            [['Ana_Qty', 'Ori_Qty', 'QOh', 'Cost'], 'number'],
            [['Batch', 'Batch_Date', 'DocType_Recv', 'Item_number', 'VoucherNo_Recv'], 'unique', 'targetAttribute' => ['Batch', 'Batch_Date', 'DocType_Recv', 'Item_number', 'VoucherNo_Recv']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Item_number' => 'Item Number',
            'Batch_Date' => 'Batch  Date',
            'Batch' => 'Batch',
            'DocType_Recv' => 'Doc Type  Recv',
            'VoucherNo_Recv' => 'Voucher No  Recv',
            'WhCode' => 'Wh Code',
            'Loc_number' => 'Loc Number',
            'Ana_No' => 'Ana  No',
            'Ana_Qty' => 'Ana  Qty',
            'Ori_Qty' => 'Ori  Qty',
            'QOh' => 'Qoh',
            'Cost' => 'Cost',
            'DocType_Issue' => 'Doc Type  Issue',
            'Voucherno_Issue' => 'Voucherno  Issue',
        ];
    }
}
