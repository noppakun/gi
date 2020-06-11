<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Brand".
 *
 * @property string $Type_Invent_Code
 * @property string $Group_Product
 * @property string $Product
 * @property string $Brand
 * @property string $BrandDesc
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Brand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Type_Invent_Code', 'Group_Product', 'Product', 'Brand', 'BrandDesc'], 'required'],
            [['Type_Invent_Code', 'Group_Product', 'Product', 'Brand', 'BrandDesc'], 'string'],
            [['Brand', 'Group_Product', 'Product', 'Type_Invent_Code'], 'unique', 'targetAttribute' => ['Brand', 'Group_Product', 'Product', 'Type_Invent_Code']],
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
            'Brand' => 'Brand',
            'BrandDesc' => 'Brand Desc',
        ];
    }
}
