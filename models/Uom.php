<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Uom".
 *
 * @property string $Uom_From
 * @property string $Uom_To
 * @property string $From_Desc
 * @property string $To_Desc
 * @property string $Factor
 */
class Uom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Uom';
    }
    public function getStatus($uom)
    {
        return [
            'Litres'=>'volume',
            'ml'=>'volume'
            'kg'=>'weight'
            'g'=>'weight'
        ]
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Uom_From', 'Uom_To', 'From_Desc', 'To_Desc', 'Factor'], 'required'],
            [['Uom_From', 'Uom_To', 'From_Desc', 'To_Desc'], 'string'],
            [['Factor'], 'number'],
            [['Uom_From', 'Uom_To'], 'unique', 'targetAttribute' => ['Uom_From', 'Uom_To']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Uom_From' => 'Uom  From',
            'Uom_To' => 'Uom  To',
            'From_Desc' => 'From  Desc',
            'To_Desc' => 'To  Desc',
            'Factor' => 'Factor',
        ];
    }
}
