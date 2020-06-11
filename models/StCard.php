<?php

namespace app\models;

use Yii;
use app\models\Item;
/**
 * This is the model class for table "StCard".
 *
 * @property string $CompanyCode
 * @property string $DocType
 * @property string $VoucherNo
 * @property string $Item_Number
 * @property string $WhCode
 * @property string $Location
 * @property string $Ana_No
 * @property string $Item_Desc
 * @property string $Recv_Qty
 * @property string $Issue_Qty
 * @property string $UnitPrice
 * @property string $SumPrice
 * @property string $AccountCode
 * @property string $CsCode
 * @property string $Status
 * @property int $Batch
 * @property string $TimeRecord
 * @property string $UserName
 * @property string $WorkStart
 * @property string $WorkStop
 * @property string $QA_StartDateTime
 * @property string $QA_StopDateTime
 * @property string $QA_MachCode
 * @property string $QA_ApvDate
 * @property string $MachCode
 * @property string $Item_Uom
 * @property string $WantQCDate
 * @property string $EmployeeCode
 * @property int $Checker_Status
 * @property string $Tare_Weight
 * @property string $KpiDte2
 * @property string $KpiDte1
 */


 /*

 *** DocType  ประเภทการรับจ่ายสินค้า   from Pattawit
รับ
R0 ยอดยกมา
R1 รับจากการซื้อ
R2 รับจากการผลิต
R3 รับคืนจาการผลิต
R4 รับคืนจากลูกค้า
R5 ปรับปรุงการรับอื่นๆ
R6 รับจากการโอน
R7 รับเข้าจากการตรวจนับ
R8 รับจากผู้จ้างผลิต
R9 รับคืนจาก Supplier

จ่าย
I0 Reject จาก LAB
I1 เบิกวัตถุดิบเพื่อการผลิต
I2 เบิกสินค้าใช้ภายใน
I3 เบิกสินค้าเป็นตัวอย่าง
I4 ตัดสินค้าชำรุด
I5 เบิกเพื่อโอน
I6 เบิกสินค้าเพื่อจำหน่าย
I7 ปรับปรุงการเบิกอื่นๆ
I8 เบิกออกจากการตรวจนับ
I9 ตัดสินค้าชำรุดจาก Supplier

 */
class StCard extends \yii\db\ActiveRecord
{
    public function getStHead()
    {        
        return $this->hasMany(StHead::className(), [
            'CompanyCode' => 'CompanyCode',
            'DocType' => 'DocType',
            'VoucherNo' => 'VoucherNo',
            ]);
    }    
    public function getDocType_ref()
    {        
        return $this->hasOne(DocType::className(), ['DocType' => 'DocType']);         
    }    
    public function getItem()
    {        
 
        return $this->hasOne(Item::className(), ['Item_Number' => 'Item_Number']);         
    }    

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'StCard';
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
 
        // เนื่องจาก TimeRecord update ไม่ได้
        $scenarios['default']= ['WhCode','Location','Recv_Qty','UnitPrice' ,'SumPrice','Item_Desc'];
        
 
        
        return $scenarios;
        
    } 



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'DocType', 'VoucherNo', 'Item_Number', 'WhCode', 'Location', 'Ana_No'], 'required'],
            [['CompanyCode', 'DocType', 'VoucherNo', 'Item_Number', 'WhCode', 'Location', 'Ana_No', 'Item_Desc', 'AccountCode', 'CsCode', 'Status', 'UserName', 'QA_MachCode', 'MachCode', 'Item_Uom', 'EmployeeCode'], 'string'],
            [['Recv_Qty', 'Issue_Qty', 'UnitPrice', 'SumPrice', 'Tare_Weight'], 'number'],
            [['Batch', 'Checker_Status'], 'integer'],
            [['TimeRecord', 'WorkStart', 'WorkStop', 'QA_StartDateTime', 'QA_StopDateTime', 'QA_ApvDate', 'WantQCDate', 'KpiDte2', 'KpiDte1'], 'safe'],
            [['Ana_No', 'CompanyCode', 'DocType', 'Item_Number', 'Location', 'VoucherNo', 'WhCode'], 'unique', 'targetAttribute' => ['Ana_No', 'CompanyCode', 'DocType', 'Item_Number', 'Location', 'VoucherNo', 'WhCode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'DocType' => 'Doc Type',
            'VoucherNo' => 'Voucher No',
            'Item_Number' => 'Item  Number',
            'WhCode' => 'คลัง',
            'Location' => 'Location',
            'Ana_No' => 'Ana  No',
            'Item_Desc' => 'Item  Desc',
            'Recv_Qty' => 'Recv  Qty',
            'Issue_Qty' => 'Issue  Qty',
            'UnitPrice' => 'มูลค่าต่อหน่วย',
            'SumPrice' => 'มูลค่ารวม    ',
            'AccountCode' => 'Account Code',
            'CsCode' => 'Cs Code',
            'Status' => 'Status',
            'Batch' => 'Batch',
            'TimeRecord' => 'Time Record',
            'UserName' => 'User Name',
            'WorkStart' => 'Work Start*',
            'WorkStop' => 'Work Stop',
            'QA_StartDateTime' => 'Qa  Start Date Time',
            'QA_StopDateTime' => 'Qa  Stop Date Time',
            'QA_MachCode' => 'Qa  Mach Code',
            'QA_ApvDate' => 'Qa  Apv Date',
            'MachCode' => 'Mach Code',
            'Item_Uom' => 'Item  Uom',
            'WantQCDate' => 'Want Qcdate',
            'EmployeeCode' => 'Employee Code',
            'Checker_Status' => 'Checker  Status',
            'Tare_Weight' => 'Tare  Weight',
            'KpiDte2' => 'Kpi Dte2',
            'KpiDte1' => 'Kpi Dte1',
        ];
    }
}
