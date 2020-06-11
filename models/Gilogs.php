<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gi_logs".
 *
 * @property integer $id
 * @property string $username
 * @property string $ipaddress
 * @property string $logtime
 * @property string $controller
 * @property string $action
 * @property string $details
 */
class Gilogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'x_gi_logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'ipaddress'], 'required'],
            [['username', 'ipaddress', 'controller', 'action', 'details'], 'string'],
            [['logtime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'ipaddress' => 'Ipaddress',
            'logtime' => 'Logtime*',
            'controller' => 'Controller',
            'action' => 'Action',
            'details' => 'Details',
        ];
    }
}
