<?php

namespace app\models;

use Yii;
use \app\components\XLib;

/**
 * This is the model class for table "x_pdr".
 *
 * @property int $id
 * @property string $doc_no
 * @property string $doc_date
 * @property string $cust_no
 * @property string $cust_name
 * @property string $product_name
 * @property string $product_cat
 * @property string $product_cat_other
 * @property string $description
 * @property string $active_ingredients
 * @property string $appearance
 * @property string $color
 * @property string $taste
 * @property string $odor
 * @property string $viscosity
 * @property string $bubble
 * @property string $other
 * @property string $benchmark
 * @property string $feeling_after_use
 * @property string $target_group
 * @property string $size_text
 * @property string $size
 * @property string $size_unit
 * @property string $order_text
 * @property string $first_order
 * @property string $total_order
 * @property string $order_unit
 * @property int $packaging_conclude
 * @property string $sample_req_date
 * @property string $price_req_date
 * @property string $user_inform
 * @property string $user_accept 
 * @property string $user_remark  
 * @property string $user_approve
 * @property string $user_approve_date
 * @property string $manager_accept
 * @property string $manager_remark
 * @property string $manager_approve
 * @property string $manager_approve_date
 * @property string $picture_filename
 * @property string $rd_remark
 * @property string $bd_owner
 * @property string $rd_owner
 * @property string $cancel_date
 * @property string $cancel_user
 * @property string $cancel_resson
 * @property string $bd_approve_request_date
 */
class XPdr extends \yii\db\ActiveRecord
{

    public $imageFile;
    //
    // public $_APPROVE2;
    public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios['cancel']    = ['cancel_date','cancel_user','cancel_resson'];        
        $scenarios['rdowner']    = ['rd_owner'];                
        $scenarios['newdone']    = ['bd_approve_request_date'];                
        return $scenarios;        
    }   
     

    
    public function upload()
    {
        if ($this->validate()) {
            //$this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.jpg');
            return true;
        } else {
            return false;
        }
    }

    public static $product_cat_LIST = [                                    
        'O'=>'Oral Care',
        'H'=>'Hair Care',
        'S'=>'Skin Care',
        '9'=>'Other (อื่นๆ)',        
    ];
    public static $size_unit_LIST = [                                    
        'G'=>'gm',
        'M'=>'ml',
    ];
    public static $order_unit_LIST = [                                    
        'P'=>'pcs',
        'K'=>'kg',
    ];

    

    public function afterFind(){
        parent::afterFind();
        $this->doc_date             = XLib::dateConv($this->doc_date,'a');        
        $this->sample_req_date      = XLib::dateConv($this->sample_req_date,'a');        
        $this->price_req_date       = XLib::dateConv($this->price_req_date,'a');                                
        $this->user_approve_date    = XLib::dateConv($this->user_approve_date,'a');                                
        $this->manager_approve_date = XLib::dateConv($this->manager_approve_date,'a');



        // $RD_M = \Yii::$app->user->can('/@XPDR/RD-M');
        // $this->_APPROVE2 = false;
        // if (($RD_M) and ($this->user_approve!=null)){
        //     $this->_APPROVE2 = true;
        // }
                
        // 
        // $model->_APPROVE2 = false;
        // if (($RD_M) and ($model->user_approve!=null)){
        //     $model->_APPROVE2 = true;
        // }
        //         
    }
 


    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->doc_date             = XLib::dateConv($this->doc_date,'b');        
        $this->sample_req_date      = XLib::dateConv($this->sample_req_date,'b');        
        $this->price_req_date       = XLib::dateConv($this->price_req_date,'b');        
        $this->user_approve_date    = XLib::dateConv($this->user_approve_date,'b');                                
        $this->manager_approve_date = XLib::dateConv($this->manager_approve_date,'b');        

        if ($this->user_approve == null){
            $this->user_accept = null;
        } 
        if ($this->manager_approve == null){
            $this->manager_accept = null;
        } 
        
        return true;

        //echo '<br><br><br>';
        //\app\components\XLib::xprint_r($this->getDirtyAttributes());
        //if(($this->manager_accept == 'Y') and ($this->manager_approve_date == null)){
        // if($this->_APPROVE2){
        //     $this->manager_approve = Yii::$app->user->identity->username;    
        //     $this->manager_approve_date   = XLib::dateConv(Yii::$app->formatter->asDate('now'),'b');                    
        // }


        //die(); 

    }
    public function genDocNumber()
    {   
        

        $prefix='PDR'        
        .substr('0'.(date('y')+0),-2)        
        .substr('0'.(date('m')+0),-2);        
        $lastdoc = $this->find()
            ->select('max(doc_no) as doc_no')
            ->where(['left(doc_no,7)' => $prefix])          
            ->one();
        $next_num = ($lastdoc) ? (substr($lastdoc->doc_no,7,3)+1) : 1 ;
            
        return $prefix.substr('000'.$next_num,-3);        
    }
    
    // ----------------------------------------------------------------------------
    // ----------------------------------------------------------------------------
    // ----------------------------------------------------------------------------
        
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_pdr';
    }

    /**
     * {@inheritdoc}
     */
    // public function rules()
    // {
    //     return [
    //         [['doc_no', 'cust_no', 'cust_name', 'product_name', 'product_cat', 'product_cat_other', 'description', 'active_ingredients', 'appearance', 'color', 'taste', 'odor', 'viscosity', 'bubble', 'other', 'benchmark', 'feeling_after_use', 'target_group', 'size_unit', 'first_order', 'total_order', 'order_unit', 'user_inform', 'user_approve', 'manager_accept', 'user_accept','user_remark', 'manager_remark', 'manager_approve','size_text','order_text'], 'string'],
    //         [['doc_date', 'sample_req_date', 'price_req_date', 'user_approve_date', 'manager_approve_date'], 'safe'],
    //         [['size'], 'number'],
    //         [['packaging_conclude'], 'integer'],

    //         // [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],           
    //     ];
    // }
    public function rules()
    {
        return [
            [[
                'cust_name','product_name','product_cat','description','active_ingredients','appearance','color',
                'taste','odor','bubble','size_text','order_text','packaging_conclude',
                // 'sample_req_date','price_req_date'  // k.jeed แจ้งไม่ต้องบังคับใส่ 13/5/2020
            ], 'required'],
            // ---------------------------------------------------
            [['doc_date', 'sample_req_date', 'price_req_date', 'user_approve_date', 'manager_approve_date', 'cancel_date','bd_approve_request_date'], 'safe'],
            [['size'], 'number'],
            [['packaging_conclude'], 'integer'],
            [['doc_no'], 'string', 'max' => 20],
            [['cust_no'], 'string', 'max' => 10],
            [['cust_name', 'product_name', 'appearance', 'color', 'taste', 'odor', 'viscosity', 'bubble', 'other', 'benchmark', 'feeling_after_use', 'target_group', 'size_text', 'order_text', 'first_order', 'total_order', 'user_remark', 'manager_remark', 'rd_remark', 'cancel_resson'], 'string', 'max' => 200],
            [['product_cat', 'size_unit', 'order_unit', 'user_accept', 'manager_accept'], 'string', 'max' => 1],
            [['product_cat_other', 'user_inform', 'user_approve', 'manager_approve', 'picture_filename'], 'string', 'max' => 50],
            [['description', 'active_ingredients'], 'string', 'max' => 300],
            [['bd_owner', 'rd_owner', 'cancel_user'], 'string', 'max' => 30],
        ];
    }    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doc_no' => 'เลขที่เอกสาร',
            'doc_date' => 'วันที่',
            'cust_no' => 'รหัสลูกค้า',            
            'cust_name' => 'Customer Name (ชื่อลูกค้า)',
            'product_name' => 'Product Name (ชื่อสินค้า)',
            'product_cat' => 'Product (ประเภทผลิตภัณฑ์)',
            'product_cat_other' => 'อื่น ๆ',
            'description' => 'Description (สรรพคุณ)',
            'active_ingredients' => 'Active Ingredients (สารสำคัญ)',
            'appearance' => 'Appearance (ลักษณะเนื้อ)',
            'color' => 'Color (สี)',
            'taste' => 'Taste (รส)',
            'odor' => 'Odor (กลิ่น)',
            'viscosity' => 'Viscosity (ความหนืด)',
            'bubble' => 'Bubble (ฟอง)',
        
            'other' => 'อื่นๆ',
            'benchmark' => 'Benchmark (ผลิตภัณฑ์ที่เปรียบเทียบ)',
            'feeling_after_use' => 'Feeling After Use (ความรู้สึกหลังการใช้)',
            'target_group' => 'Target Group (กลุ่มลูกค้าเป้าหมาย)',
            'size_text' => 'Size (ปริมาณการบรรจุ g, ml / PCS)',
            //'size_text' => 'Size (ปริมาณการบรรจุ)',
            'size' => 'Size (ปริมาณการบรรจุ / pcs)',
            'size_unit' => 'Size Unit',            
            //'order_text' => 'First order, Total order (pcs./kg.)',

            'order_text' => 'Order',
            'first_order' => 'First Order',
            'total_order' => 'Total Order',
            'order_unit' => 'Order Unit',
            'packaging_conclude'=>'Packaging',
            'sample_req_date' => 'วันที่ต้องการตัวอย่าง',
            'price_req_date' => 'วันที่ต้องการราคา',
            'user_inform' => 'ผู้แจ้ง',
            'user_accept' => 'อนุมัติ',      
            'user_remark' => 'หมายเหตุ',                        
            'user_approve' => 'BD. Approve',
            'user_approve_date' => 'วันที่อนุมัติ',
            //'user_accept' => 'ตอบรับงานวิจัยและพัฒนาผลิตภัณฑ์',
            'manager_accept' => 'ตอบรับ',
            'manager_remark' => 'หมายเหตุ',
            'manager_approve' => 'RD. Approve',
            'manager_approve_date' => 'วันที่ตอบรับ',

            'picture_filename' => 'Picture Filename',
            'rd_remark' => 'Rd Remark',
            'bd_owner' => 'BD. ผู้รับผิดชอบ',
            'rd_owner' => 'RD. ผู้รับผิดชอบ',
            'cancel_date' => 'วันที่ยกเลิก',
            'cancel_user' => 'ผู้ยกเลิก',
            'cancel_resson' => 'สาเหตุการยกเลิก',            
            
        ];
    }
}

