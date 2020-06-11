<?php

namespace app\models;

/**
 * This is the model class for table "Location".
 *
 * @property string $WhCode
 * @property string $Location_Code
 * @property string $Location_Name
 * @property int $NotActive
 */
class Location extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['WhCode', 'Location_Code', 'Location_Name'], 'required'],
            [['WhCode', 'Location_Code', 'Location_Name'], 'string'],
            [['NotActive'], 'integer'],
            [['Location_Code', 'WhCode'], 'unique', 'targetAttribute' => ['Location_Code', 'WhCode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'WhCode' => 'Wh Code',
            'Location_Code' => 'Location  Code',
            'Location_Name' => 'Location  Name',
            'NotActive' => 'Not Active',
        ];
    }
}
