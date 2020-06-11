<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DeleteLog".
 *
 * @property string $Delete_DESC
 * @property string $UserName
 * @property string $Item_Number
 * @property string $Qty
 * @property string $DocNo
 * @property string $Delete_Date
 * @property string $Ana_No
 * @property integer $id
 */
class DeleteLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DeleteLog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Delete_DESC', 'UserName', 'Delete_Date'], 'required'],
            [['Delete_DESC', 'UserName', 'Item_Number', 'DocNo', 'Ana_No'], 'string'],
            [['Qty'], 'number'],
            [['Delete_Date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Delete_DESC' => 'Delete  Desc',
            'UserName' => 'User Name',
            'Item_Number' => 'Item  Number',
            'Qty' => 'Qty',
            'DocNo' => 'Doc No',
            'Delete_Date' => 'Delete  Date',
            'Ana_No' => 'Ana  No',
            'id' => 'ID',
        ];
    }
}
