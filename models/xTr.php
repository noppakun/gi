<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_tr".
 *
 * @property int $id
 * @property string|null $doc_no
 * @property string|null $cust_no
 * @property string|null $cust_name
 * @property string|null $product_name
 * @property string|null $product_cat
 * @property string|null $product_cat_other
 */
class xTr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function getProduct()
    {     
        return $this->hasOne(XPkr::className(), ['doc_no' => 'doc_no']);
    }     
    public static function tableName()
    {
        return 'x_tr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_no'], 'string', 'max' => 20],
            [['cust_no'], 'string', 'max' => 10],
            [['cust_name', 'product_name'], 'string', 'max' => 200],
            [['product_cat'], 'string', 'max' => 1],
            [['product_cat_other'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doc_no' => 'Doc No',
            'cust_no' => 'Cust No',
            'cust_name' => 'Cust Name',
            'product_name' => 'Product Name',
            'product_cat' => 'Product Cat',
            'product_cat_other' => 'Product Cat Other',
        ];
    }
}
