<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ProdDet".
 *
 * @property string $Order_No
 * @property string $Item_Number
 * @property string $Order_Qty
 * @property string $Priority
 * @property string $Rlse_Qty
 * @property string $Rlse_Date
 * @property string $Status
 * @property string $Due_Date
 * @property string $UserName
 */
class ProdDet extends \yii\db\ActiveRecord
{

    protected $labels = [
        'Order_No' => 'Order No',
        'Item_Number' => 'รหัสสินค้า',
        'Order_Qty' => 'Order Qty',
        'Priority' => 'Priority',
        'Rlse_Qty' => 'Rlse Qty',
        'Rlse_Date' => 'Rlse Date',
        'Status' => 'Status',
        'Due_Date' => 'Due Date',
        'UserName' => 'User Name',

        // for relation display
        'Item_Name'=> 'รายละเอียด',
        'Industry_Code' => 'รหัสโรงงาน / รหัสลูกค้า',

    ];
    public function getProdnotecount()
    {
        return $this->hasOne(XProdnotecount::className(), ['order_no' => 'Order_No','item_number' => 'Item_Number']);
    }           
    public function getProd()
    {
        return $this->hasOne(Prod::className(), ['Order_No' => 'Order_No']);
    }   

    public function getPriority()
    {
        return $this->hasOne(XRefdata::className(), ['refcode' => 'Priority'])        
        ->onCondition(['reftype' => 'PRI']);        
    }     
    public function getStatus()
    {
        return $this->hasOne(xrefdata::className(), ['refcode' => 'Status'])
        ->onCondition(['reftype' => 'JST']);         
    }      
    
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['Item_Number' => 'Item_Number']);
    }

    public function getNotecount()
    {
        // นับ รวมทั้ง R และ P
        
        return $this->hasMany(XProdnote::className(), ['order_no' => 'Order_No'])
        ->onCondition(['status' => 'N'])
        ->count();    

        
    }  
    
    public function getxprodnote()
    {
    
        return $this->hasMany(XProdnote::className(), ['order_no' => 'Order_No','item_no' => 'Item_Number']);
    }  
        
 
    public function getStcardcount()
    {
    
        return $this->hasOne(StCard::className(), ['Item_Number' => 'Item_Number'])->count(); 
    }            
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProdDet';
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
            [['Order_No', 'Item_Number', 'Order_Qty'], 'required'],
            [['Order_No', 'Item_Number', 'Priority', 'Status', 'UserName'], 'string'],            
            [['Order_Qty', 'Rlse_Qty'], 'number'],
            [['Rlse_Date', 'Due_Date'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->labels;

    }
}
