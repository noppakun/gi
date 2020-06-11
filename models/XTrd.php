<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_trd".
 *
 * @property int $id
 * @property int $tr_id
 * @property string|null $item
 * @property string|null $material
 * @property string|null $owner
 * @property string|null $remark
 */
class xTrd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_trd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tr_id'], 'required'],
            [['tr_id'], 'integer'],
            [['item', 'remark'], 'string', 'max' => 200],
            [['material'], 'string', 'max' => 50],
            [['owner'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tr_id' => 'Tr ID',
            'item' => 'Item',
            'material' => 'Material',
            'owner' => 'Owner',
            'remark' => 'Remark',
        ];
    }
}
