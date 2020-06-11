<?php

namespace app\models;

use Yii;
use app\models\PurchaseOrder;
use app\models\Supplier;
/**
 * This is the model class for table "PODetail".
 *
 * @property string $CompanyCode
 * @property string $Order_Number
 * @property integer $Seq_Number
 * @property string $Item_Number
 * @property string $Due_Date
 * @property string $Order_Qty
 * @property string $Rlse_Date
 * @property string $Price
 * @property string $PurDet_Desc
 * @property string $Uom
 * @property string $Rlse_Qty
 * @property string $Pr_Company
 * @property string $Pr_No
 * @property string $Iqc_Qty
 * @property string $Rej_date
 * @property string $Rej_Qty
 * @property string $Disc_Percent
 * @property string $Disc_Cash
 * @property integer $Type_Desc
 * @property string $Delivery_Date
 * @property string $SpecNo
 * @property string $EffectiveDate
 * @property string $Seq_Pr
 * @property string $PR_Number
 */
class PODetail extends \yii\db\ActiveRecord
{
    //public $Supp_Name;

    public function getPo()
    { 
        return $this->hasOne(PurchaseOrder::className(), ['CompanyCode'=>'CompanyCode','Order_Number' => 'Order_Number']);         
    }
    public function getSupplier()
    { 
        return $this->hasOne(Supplier::className(), ['Supp_Number'=>'Supp_Number']);         
    }    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PODetail';
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
    // public function getSupp_Number()
    // {
    //     return '$this->po->Supp_Number';
    // }    
    public function rules()
    {
        return [
            [['CompanyCode', 'Order_Number', 'Seq_Number', 'Order_Qty', 'Price', 'Type_Desc'], 'required'],
            [['CompanyCode', 'Order_Number', 'Item_Number', 'PurDet_Desc', 'Uom', 'Pr_Company', 'Pr_No', 'SpecNo', 'Seq_Pr', 'PR_Number'], 'string'],
            [['Seq_Number', 'Type_Desc'], 'integer'],
            [['Due_Date', 'Rlse_Date', 'Rej_date', 'Delivery_Date', 'EffectiveDate'], 'safe'],
            [['Order_Qty', 'Price', 'Rlse_Qty', 'Iqc_Qty', 'Rej_Qty', 'Disc_Percent', 'Disc_Cash'], 'number'],
            // // ----------------------------------
            //[['Supp_Name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'Order_Number' => 'เลขที่ PO.',
            'Seq_Number' => 'Seq  Number',
            'Item_Number' => 'รหัสสินค้า',
            'Due_Date' => 'Due Date',
            'Order_Qty' => 'จำนวน',
            'Rlse_Date' => 'Rlse  Date',
            'Price' => 'Price',
            'PurDet_Desc' => 'รายการ',
            'Uom' => 'หน่วย',
            'Rlse_Qty' => 'Rlse  Qty',
            'Pr_Company' => 'Pr  Company',
            'Pr_No' => 'Pr  No',
            'Iqc_Qty' => 'Iqc  Qty',
            'Rej_date' => 'Rej Date',
            'Rej_Qty' => 'Rej  Qty',
            'Disc_Percent' => 'Disc  Percent',
            'Disc_Cash' => 'Disc  Cash',
            'Type_Desc' => 'Type  Desc',
            'Delivery_Date' => 'Delivery  Date',
            'SpecNo' => 'Spec No',
            'EffectiveDate' => 'Effective Date',
            'Seq_Pr' => 'Seq  Pr',
            'PR_Number' => 'Pr  Number',
            'Order_date' => 'วันที่ PO.',
        ];
    }
}
