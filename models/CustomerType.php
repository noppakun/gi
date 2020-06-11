<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CustomerType".
 *
 * @property string $CustomerTypeCode
 * @property string $CustomerTypeDesc
 */
class CustomerType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CustomerType';
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
            [['CustomerTypeCode'], 'required'],
            [['CustomerTypeCode', 'CustomerTypeDesc'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CustomerTypeCode' => 'Customer Type Code',
            'CustomerTypeDesc' => 'Customer Type Desc',
        ];
    }
}
