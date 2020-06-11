<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "BomBatchFormNo".
 *
 * @property string $Assembly
 * @property string $StandardBatchSize
 * @property string $FormNo
 * @property string $EffectiveDate
 * @property string $ProcessRemark
 */
class BomBatchFormNo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'BomBatchFormNo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Assembly', 'StandardBatchSize'], 'required'],
            [['Assembly', 'FormNo', 'ProcessRemark'], 'string'],
            [['StandardBatchSize'], 'number'],
            [['EffectiveDate'], 'safe'],
            [['Assembly', 'StandardBatchSize'], 'unique', 'targetAttribute' => ['Assembly', 'StandardBatchSize']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Assembly' => 'Assembly',
            'StandardBatchSize' => 'Standard Batch Size',
            'FormNo' => 'Form No',
            'EffectiveDate' => 'Effective Date',
            'ProcessRemark' => 'Process Remark',
        ];
    }
}
