<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test".
 
 */
class Test extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CarRegisterNo', 'CarTaxNo'], 'required'],
            [['CarTaxNo'], 'integer'],
            [['TaxDate', 'TaxDueDate'], 'safe'],
            [['TaxAmount'], 'number'],
            [['CarRegisterNo'], 'string', 'max' => 15],
            [['ReceiptNo'], 'string', 'max' => 30],
            [['CarRegisterNo'], 'unique'],
            ['TaxAmount', 'required', 'when' => function ($model) {
                return $model->ReceiptNo == '3';
            }, 'whenClient' => "function (attribute, value) {
                return $('#test-receiptno').val() == '3';
            }"]            
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
