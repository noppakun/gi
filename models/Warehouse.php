<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "warehouse".
 *
 * @property string $WhCode
 * @property string $WhName
 * @property string $Address1
 * @property string $Address2
 * @property string $Address3
 * @property string $Address4
 * @property string $Phone
 * @property string $Fax
 * @property string $Person_Incharge
 * @property string $Remarks
 * @property integer $NotActive
 */
class Warehouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'warehouse';
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
            [['WhCode', 'WhName', 'NotActive'], 'required'],
            [['WhCode', 'WhName', 'Address1', 'Address2', 'Address3', 'Address4', 'Phone', 'Fax', 'Person_Incharge', 'Remarks'], 'string'],
            [['NotActive'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'WhCode' => 'รหัสคลัง',
            'WhName' => 'Wh Name',
            'Address1' => 'Address1',
            'Address2' => 'Address2',
            'Address3' => 'Address3',
            'Address4' => 'Address4',
            'Phone' => 'Phone',
            'Fax' => 'Fax',
            'Person_Incharge' => 'Person  Incharge',
            'Remarks' => 'Remarks',
            'NotActive' => 'Not Active',
        ];
    }
}
