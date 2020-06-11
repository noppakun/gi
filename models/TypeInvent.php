<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Type_Invent".
 *
 * @property string $Type_Invent_Code
 * @property string $Type_Invent_Desc
 * @property string $Type_Invent
 * @property int $RunningAna_no
 */
class TypeInvent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Type_Invent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Type_Invent_Code', 'Type_Invent_Desc'], 'required'],
            [['Type_Invent_Code', 'Type_Invent_Desc', 'Type_Invent'], 'string'],
            [['RunningAna_no'], 'integer'],
            [['Type_Invent_Code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Type_Invent_Code' => 'Type  Invent  Code',
            'Type_Invent_Desc' => 'Type  Invent  Desc',
            'Type_Invent' => 'Type  Invent',
            'RunningAna_no' => 'Running Ana No',
        ];
    }
}
