<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Quote".
 *
 * @property string $CompanyCode
 * @property string $Quote
 * @property string $RefDoc_Number
 * @property string $Supp_Number
 * @property string $Supp_Name
 * @property string $QuoteDate
 * @property string $Salesman
 * @property integer $ConfirmDay
 */
class Quote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Quote';
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
            [['CompanyCode', 'Quote'], 'required'],
            [['CompanyCode', 'Quote', 'RefDoc_Number', 'Supp_Number', 'Supp_Name', 'Salesman'], 'string'],
            [['QuoteDate'], 'safe'],
            [['ConfirmDay'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'Quote' => 'Quote',
            'RefDoc_Number' => 'Ref Doc  Number',
            'Supp_Number' => 'Supp  Number',
            'Supp_Name' => 'Supp  Name',
            'QuoteDate' => 'Quote Date',
            'Salesman' => 'Salesman',
            'ConfirmDay' => 'Confirm Day',
        ];
    }
}
