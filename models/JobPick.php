<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Job_Pick".
 *
 * @property string $JobNo
 * @property string $Order_No
 * @property string $Item_Number
 * @property string $Component
 * @property string $Req_Qty
 * @property string $Pick_Qty
 * @property string $Pick_Qty_Bak
 */
class JobPick extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Job_Pick';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['JobNo', 'Order_No', 'Item_Number', 'Component'], 'required'],
            [['JobNo', 'Order_No', 'Item_Number', 'Component'], 'string'],
            [['Req_Qty', 'Pick_Qty', 'Pick_Qty_Bak'], 'number'],
            [['Component', 'Item_Number', 'JobNo', 'Order_No'], 'unique', 'targetAttribute' => ['Component', 'Item_Number', 'JobNo', 'Order_No']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'JobNo' => 'Job No',
            'Order_No' => 'Order  No',
            'Item_Number' => 'Item  Number',
            'Component' => 'Component',
            'Req_Qty' => 'Req  Qty',
            'Pick_Qty' => 'Pick  Qty',
            'Pick_Qty_Bak' => 'Pick  Qty  Bak',
        ];
    }
}
