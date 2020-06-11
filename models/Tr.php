<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr".
 *
 * @property string $rgroup
 * @property string $rname
 * @property string $item_number
 * @property string $Item_Name
 * @property string $onhand_est_kg
 * @property string $onhand_amt
 * @property string $prod_est_kg
 * @property string $prod_repack_est_kg
 * @property string $sales_est_kg
 * @property string $sales_amt
 */
class Tr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $sum_onhand_est_kg;
    public static function tableName()
    {
        return 'tr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rgroup', 'item_number'], 'required'],
            [['onhand_est_kg', 'onhand_amt', 'prod_est_kg', 'prod_repack_est_kg', 'sales_est_kg', 'sales_amt'], 'number'],
            
            
            [['rgroup'], 'string', 'max' => 2],
            [['rname'], 'string', 'max' => 22],
            [['item_number'], 'string', 'max' => 20],
            [['Item_Name'], 'string', 'max' => 70],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rgroup' => 'Rgroup',
            'rname' => 'Rname',
            'item_number' => 'Item Number',
            'Item_Name' => 'Item Name',
            'onhand_est_kg' => 'Onhand Est Kg',
            'onhand_amt' => 'Onhand Amt',
            'prod_est_kg' => 'Prod Est Kg',
            'prod_repack_est_kg' => 'Prod Repack Est Kg',
            'sales_est_kg' => 'Sales Est Kg',
            'sales_amt' => 'Sales Amt',
        ];
    }
}
