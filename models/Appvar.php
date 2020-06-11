<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "appvar".
 *
 * @property string $app_key
 * @property string $app_value
 * @property string $lastupdate
 */
class Appvar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'x_appvar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_key', 'app_value'], 'string'],
            [['lastupdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'app_key' => 'App Key',
            'app_value' => 'App Value',
            'lastupdate' => 'Lastupdate',
        ];
    }
}
