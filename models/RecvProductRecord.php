<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Recv_Product_Record".
 *
 * @property string $Order_Number
 * @property string $JobNo
 * @property string $Item_Number
 * @property string $VoucherNo
 * @property string $WhCode
 * @property string $Location
 * @property string $Ana_no
 * @property string $Recv_Qty
 * @property string $Acc_Qty
 * @property string $Rej_Qty
 * @property string $Acc_Date
 * @property string $Item_Type
 * @property string $Status
 * @property string $UserName
 * @property string $Fill_Date
 */
class RecvProductRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Recv_Product_Record';
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
            [['Order_Number', 'JobNo', 'Item_Number', 'VoucherNo', 'WhCode', 'Location', 'Ana_no', 'Item_Type', 'Status'], 'required'],
            [['Order_Number', 'JobNo', 'Item_Number', 'VoucherNo', 'WhCode', 'Location', 'Ana_no', 'Item_Type', 'Status', 'UserName'], 'string'],
            [['Recv_Qty', 'Acc_Qty', 'Rej_Qty'], 'number'],
            [['Acc_Date', 'Fill_Date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Order_Number' => 'Order  Number',
            'JobNo' => 'Job No',
            'Item_Number' => 'Item  Number',
            'VoucherNo' => 'Voucher No',
            'WhCode' => 'Wh Code',
            'Location' => 'Location',
            'Ana_no' => 'Ana No',
            'Recv_Qty' => 'Recv  Qty',
            'Acc_Qty' => 'Acc  Qty',
            'Rej_Qty' => 'Rej  Qty',
            'Acc_Date' => 'Acc  Date',
            'Item_Type' => 'Item  Type',
            'Status' => 'Status',
            'UserName' => 'User Name',
            'Fill_Date' => 'Fill  Date',
        ];
    }
}
