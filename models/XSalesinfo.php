<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_salesinfo".
 *
 * @property int $tryear
 * @property string $trquarter
 * @property int $trmonth
 * @property string $cust_no
 * @property string $cust_name
 * @property string $CustomerTypeCode
 * @property string $customertypedesc
 * @property string $item_name
 * @property string $group_product_desc
 * @property string $product_desc
 * @property string $branddesc
 * @property string $qty
 * @property string $amt
 * @property string $markup
 * @property string $sku
 * @property string $unit_markup
 * @property string $std_price
 * @property string $item_number
 * @property string $ana_no
 * @property string $actual_cost
 * @property string $variable_cost
 * @property string $percent_markup
 * @property string $salesman
 */
class XSalesinfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_salesinfo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tryear', 'trmonth'], 'integer'],
            [['trquarter', 'cust_no', 'cust_name', 'CustomerTypeCode', 'customertypedesc', 'item_name', 'group_product_desc', 'product_desc', 'branddesc', 'sku', 'item_number', 'ana_no', 'salesman'], 'string'],
            [['qty', 'amt', 'markup', 'unit_markup', 'std_price', 'actual_cost', 'variable_cost', 'percent_markup'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tryear' => 'Tryear',
            'trquarter' => 'Trquarter',
            'trmonth' => 'เดือน',
            'cust_no' => 'Cust No',
            'cust_name' => 'ลูกค้า',
            'CustomerTypeCode' => 'Customer Type Code',
            'customertypedesc' => 'Customertypedesc',
            'item_name' => 'สินค้า',
            'group_product_desc' => 'Group Product Desc',
            'product_desc' => 'Product Desc',
            'branddesc' => 'Branddesc',
            'qty' => 'จำนวนขาย',
            'amt' => 'มูลค่า',
            'markup' => 'Markup',
            'sku' => 'Sku',
            'unit_markup' => 'Unit Markup',
            'std_price' => 'Std Price',
            'item_number' => 'Item Number',
            'ana_no' => 'Ana No',
            'actual_cost' => 'Actual Cost',
            'variable_cost' => 'Variable Cost',
            'percent_markup' => 'Percent Markup',
            'salesman' => 'Salesman',
        ];
    }
}
