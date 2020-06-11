<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_item_ext_vcost".
 *
 * @property integer $id
 * @property string $ana_no
 * @property string $item_number
 * @property string $variable_cost
 */
class XItemExtVcost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'x_item_ext_vcost';
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
            [[ 'ana_no', 'item_number'], 'required'],
            [[ 'ana_no', 'item_number'], 'string'],
            [['variable_cost'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ana_no' => 'Ana No',
            'item_number' => 'Item Number',
            'variable_cost' => 'Variable Cost',
        ];
    }
}
