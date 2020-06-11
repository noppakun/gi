<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Product".
 *
 * @property string $Type_Invent_Code
 * @property string $Group_Product
 * @property string $Product
 * @property string $Product_Desc
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Type_Invent_Code', 'Group_Product', 'Product', 'Product_Desc'], 'required'],
            [['Type_Invent_Code', 'Group_Product', 'Product', 'Product_Desc'], 'string'],
            [['Group_Product', 'Product', 'Type_Invent_Code'], 'unique', 'targetAttribute' => ['Group_Product', 'Product', 'Type_Invent_Code']],
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
            'Product' => 'Product',
            'Product_Desc' => 'Product  Desc',
        ];
    }
}
