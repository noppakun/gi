<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Prod".
 *
 * @property string $Order_No
 * @property string $Planner_Number
 * @property string $Remarks
 * @property string $Order_Date
 * @property string $PO_No
 * @property string $UserName
 * @property string $Sale_Number
 * @property string $RecvOrderDate
 * @property string $remarks2
 */
class Prod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Prod';
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
            [['Order_No', 'Order_Date'], 'required'],
            [['Order_No', 'Planner_Number', 'Remarks', 'PO_No', 'UserName', 'Sale_Number', 'remarks2'], 'string'],
            [['Order_Date', 'RecvOrderDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Order_No' => 'Order  No',
            'Planner_Number' => 'Planner  Number',
            'Remarks' => 'Remarks',
            'Order_Date' => 'วันที่ใบสั่งผลิต',
            'PO_No' => 'Po  No',
            'UserName' => 'User Name',
            'Sale_Number' => 'Sale  Number',
            'RecvOrderDate' => 'Recv Order Date',
            'remarks2' => 'Remarks2',
        ];
    }

    
}
