<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "BomDet".
 *
 * @property string $Assembly
 * @property integer $Sequence
 * @property string $Component
 * @property double $Qty
 * @property string $Effectivity
 * @property string $Obsolete
 * @property string $Engineer
 * @property string $Remarks
 * @property string $Yield
 * @property string $ExtendQty
 * @property integer $PrintQty
 */
class BomDet extends \yii\db\ActiveRecord
{
    public function getComponentnotecount()
    {
        /*
        return $this->hasMany(XProdnote::className(), ['Component' => 'component'])
        ->onCondition(['status' => 'N','order_no'=>'*','item_no'=>'*'])
        ->count();        
        */

        return 99;
        
        
    }     
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'BomDet';
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
            [['Assembly', 'Sequence', 'Qty'], 'required'],
            [['Assembly', 'Component', 'Engineer', 'Remarks', 'ExtendQty'], 'string'],
            [['Sequence', 'PrintQty'], 'integer'],
            [['Qty', 'Yield'], 'number'],
            [['Effectivity', 'Obsolete'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Assembly' => 'Assembly',
            'Sequence' => 'Sequence',
            'Component' => 'Component',
            'Qty' => 'Qty',
            'Effectivity' => 'Effectivity',
            'Obsolete' => 'Obsolete',
            'Engineer' => 'Engineer',
            'Remarks' => 'Remarks',
            'Yield' => 'Yield',
            'ExtendQty' => 'Extend Qty',
            'PrintQty' => 'Print Qty',
        ];
    }
}
