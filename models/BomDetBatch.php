<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "BomDetBatch".
 *
 * @property string $Assembly
 * @property string $StandardBatchSize
 * @property int $Sequence
 * @property string $Component
 * @property string $Qty
 */
class BomDetBatch extends \yii\db\ActiveRecord
{
    
    // private function bpr($Order_Number,$RefDoc,$P1,$P2)
    // {
    //     // return - = +
    //     return   $this->hasMany(StCard::className(), ['Item_Number' => 'Component'])
    //     ->JoinWith('stHead')       
    //     ->andOnCondition(
    //         'stHead.Order_Number = :Order_Number and stHead.RefDoc = :RefDoc and stHead.DocType in (:P1,:P2)',     
    //         [
    //             ':Order_Number' => $Order_Number,
    //             ':RefDoc' => $RefDoc,                
    //             ':P1'=>$P1,
    //             ':P2'=>$P2,                
    //         ]
    //     )->sum('isnull(issue_qty,0)-isnull(recv_Qty,0)');
    // }    
    // public function bpr_returned($Order_Number,$RefDoc)
    // {
    //     // return - = +
    //     return - $this->bpr($Order_Number,$RefDoc,'R3','RA');
    // }    
    // public function bpr_issue($Order_Number,$RefDoc)
    // {
    //     return   $this->bpr($Order_Number,$RefDoc,'I1','IA');
 
    // }        
   
    // // ****************************************************
  
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['Item_Number' => 'Component']);
    }
    // **********************************************************************
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'BomDetBatch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Assembly', 'StandardBatchSize', 'Sequence'], 'required'],
            [['Assembly', 'Component'], 'string'],
            [['StandardBatchSize', 'Qty'], 'number'],
            [['Sequence'], 'integer'],
            [['Assembly', 'Sequence', 'StandardBatchSize'], 'unique', 'targetAttribute' => ['Assembly', 'Sequence', 'StandardBatchSize']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Assembly' => 'Assembly',
            'StandardBatchSize' => 'Standard Batch Size',
            'Sequence' => 'Sequence',
            'Component' => 'Component',
            'Qty' => 'Qty',
        ];
    }
}
