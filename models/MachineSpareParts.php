<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "MachineSpareParts".
 *
 * @property string $MachCode
 * @property string $Item_Number
 */
class MachineSpareParts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MachineSpareParts';
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
            [['MachCode', 'Item_Number'], 'required'],
            [['MachCode', 'Item_Number'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MachCode' => 'Mach Code',
            'Item_Number' => 'Item  Number',
        ];
    }
}
