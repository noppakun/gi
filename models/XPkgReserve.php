<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_pkg_reserve".
 *
 * @property int $id
 * @property string $group_product
 * @property string $product
 * @property string $condition
 * @property double $reserve
 * @property int $reserve_pcs 
 * @property string $reserve_remark
 */
class XPkgReserve extends \yii\db\ActiveRecord
{

    public function getGproduct()
    {        
        // 05	Packaging Materials
        return $this->hasOne(GProduct::className(), ['Group_Product' => 'group_product'])            
            ->andOnCondition('GProduct.Type_Invent_code = :Type_Invent_code1', [':Type_Invent_code1' => '05']);            
            ;         
    }
    public function getProduct2()
    {        
        return $this->hasOne(Product::className(), ['Group_Product' => 'group_product','Product' => 'product'])
            ->andOnCondition('Product.Type_Invent_code = :Type_Invent_code2', [':Type_Invent_code2' => '05']);
            ;            
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_pkg_reserve';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_product', 'product', 'condition', 'reserve_remark'], 'string'],
            [['reserve'], 'number'],
            [['reserve_pcs'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_product' => 'Group Product',
            'product' => 'Product',
            'condition' => 'Condition',
            'reserve' => 'Reserve %',
            'reserve_pcs' => 'Reserve Pcs',
            'reserve_remark' => 'Remark',
        ];
    }
}
