<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use \app\components\XLib;

/**
 * This is the model class for table "x_invoice_ext".
 *
 * @property string $companycode
 * @property string $inv_number
 * @property string $due_date_acc
 * @property string $created_at
 * @property string $updated_at
 * @property string $created_user
 * @property string $updated_user
 */
class XInvoiceExt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [            
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('getdate()'),
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_user','updated_user'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_user',
                ],
                'value' =>  Yii::$app->user->identity->username,            
            ],
        ];
    }    
    public function afterFind()
    {
        parent::afterFind();
        $this->due_date_acc             = XLib::dateConv($this->due_date_acc, 'a');

 
    }
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->due_date_acc = XLib::dateConv($this->due_date_acc, 'b');
 
        return true;
    }    
    public static function tableName()
    {
        return 'x_invoice_ext';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['companycode', 'inv_number'], 'required'],
            [['due_date_acc', 'created_at', 'updated_at'], 'safe'],
            [['companycode'], 'string', 'max' => 3],
            [['inv_number'], 'string', 'max' => 12],
            [['created_user', 'updated_user'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'companycode' => 'Companycode',
            'inv_number' => 'Inv Number',
            'due_date_acc' => 'วันที่ครบกำหนด (ยังไม่ได้วางบิล)',// 'Due Date Acc',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_user' => 'Created User',
            'updated_user' => 'Updated User',
        ];
    }
}
