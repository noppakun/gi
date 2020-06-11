<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DocType".
 *
 * @property string $DocType
 * @property string $DocTypeDesc
 * @property string $ReportDesc
 */
class DocType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DocType';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DocType', 'DocTypeDesc'], 'required'],
            [['DocType', 'DocTypeDesc', 'ReportDesc'], 'string'],
            [['DocType'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DocType' => 'Doc Type',
            'DocTypeDesc' => 'Doc Type Desc',
            'ReportDesc' => 'Report Desc',
        ];
    }
}
