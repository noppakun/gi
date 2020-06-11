<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "GProduct".
 *
 * @property string $Type_Invent_Code
 * @property string $Group_Product
 * @property string $Group_Product_Desc
 * @property int $KeepAndDestroy_Month
 */
class GProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'GProduct';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Type_Invent_Code', 'Group_Product', 'Group_Product_Desc'], 'required'],
            [['Type_Invent_Code', 'Group_Product', 'Group_Product_Desc'], 'string'],
            [['KeepAndDestroy_Month'], 'integer'],
            [['Group_Product', 'Type_Invent_Code'], 'unique', 'targetAttribute' => ['Group_Product', 'Type_Invent_Code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Type_Invent_Code' => 'Type  Invent  Code',
            'Group_Product' => 'Group  Product',
            'Group_Product_Desc' => 'Group  Product  Desc',
            'KeepAndDestroy_Month' => 'Keep And Destroy  Month',
        ];
    }
}
