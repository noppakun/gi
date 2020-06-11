<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CarTax".
 *
 * @property string $CarRegisterNo
 * @property int $CarTaxNo
 * @property string $TaxDate
 * @property string $TaxDueDate
 * @property string $ReceiptNo
 * @property string $TaxAmount
 */
class CarTax extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'CarTax';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CarRegisterNo', 'CarTaxNo'], 'required'],
            [['CarRegisterNo', 'ReceiptNo'], 'string'],
            [['CarTaxNo'], 'integer'],
            [['TaxDate', 'TaxDueDate'], 'safe'],
            [['TaxAmount'], 'number'],
            [['CarRegisterNo', 'CarTaxNo'], 'unique', 'targetAttribute' => ['CarRegisterNo', 'CarTaxNo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CarRegisterNo' => 'Car Register No',
            'CarTaxNo' => 'Car Tax No',
            'TaxDate' => 'Tax Date',
            'TaxDueDate' => 'Tax Due Date',
            'ReceiptNo' => 'Receipt No',
            'TaxAmount' => 'Tax Amount',
        ];
    }
}
