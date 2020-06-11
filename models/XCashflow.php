<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_cashflow".
 *
 * @property int $id
 * @property string $tr_date
 * @property string $description
 * @property string $amt
 * @property string $note
 */
class XCashflow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_cashflow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tr_date'], 'safe'],
            [['description', 'note'], 'string'],
            [['amt'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tr_date' => 'Tr Date',
            'description' => 'Description',
            'amt' => 'Amt',
            'note' => 'Note',
        ];
    }
}
