<?php

namespace app\models;

use Yii;
use \app\components\XLib;

/**
 * This is the model class for table "x_pkr".
 *
 * @property int $id
 * @property string $doc_no
 * @property string $doc_date
 * @property string $cust_no
 * @property string $cust_name
 * @property string $product_name
 * @property string $product_cat
 * @property string $product_cat_other
 * @property string $bulk
 * @property string $benchmark
 * @property string $target_group
 * @property string $size
 * @property string $size_unit
 * @property string $first_order 
 * @property string $total_order
 * @property string $order_unit
 * @property string $artwork_design
 * @property string $other_detail
 * @property string $other_detail_other
 * @property string $present_req_date
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
 */
class XPkr extends \yii\db\ActiveRecord
{


    public $imageFile;


    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
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
    public static $bulk_LIST = [                                    
        '1'=>'กำลังพัฒนา',
        '2'=>'สรุปสูตรสินค้า',
    ];    
    public static $size_unit_LIST = [                                    
        'G'=>'gm',
        'M'=>'ml',
    ];
    public static $order_unit_LIST = [                                    
        'P'=>'pcs',
        'K'=>'kg',
    ];
    public static $artwork_design_LIST = [                                    
        'G'=>'GPM จัดหา',
        'C'=>'ลูกค้าจัดหา',
        'W'=>'รอสรุป',
    ];
    public static $owner_LIST = [                                    
        'G'=>'GPM',
        'C'=>'Customer',        
    ];
    public static $other_detail_LIST = [                                    
        'P'=>'รูปภาพ',
        'S'=>'ตัวอย่างสินค้า',        
        'O'=>'อื่นๆ',          
    ];    
    
    

    

    public function afterFind(){
        parent::afterFind();
        $this->doc_date             = XLib::dateConv($this->doc_date,'a');        
        $this->present_req_date      = XLib::dateConv($this->present_req_date,'a');        
        $this->price_req_date       = XLib::dateConv($this->price_req_date,'a');                                
        $this->user_approve_date    = XLib::dateConv($this->user_approve_date,'a');                                
        $this->manager_approve_date = XLib::dateConv($this->manager_approve_date,'a');
    }
 


    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->doc_date             = XLib::dateConv($this->doc_date,'b');        
        $this->present_req_date      = XLib::dateConv($this->present_req_date,'b');           
        $this->price_req_date       = XLib::dateConv($this->price_req_date,'b');        
        $this->user_approve_date    = XLib::dateConv($this->user_approve_date,'b');                                
        $this->manager_approve_date = XLib::dateConv($this->manager_approve_date,'b');        

        if(($this->manager_accept == 'Y') and ($this->manager_approve_date == null)){
            $this->manager_approve = Yii::$app->user->identity->username;    
            $this->manager_approve_date   = XLib::dateConv(Yii::$app->formatter->asDate('now'),'b');                    
        }


 

        return true;
    }
    public function genDocNumber()
    {   
        

        $prefix='PKR'        
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
        return 'x_pkr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_no', 'cust_no', 'cust_name', 'product_name', 'product_cat', 'product_cat_other', 'bulk', 'benchmark', 'target_group', 'size_unit', 'order_unit',  'artwork_design', 'other_detail', 'other_detail_other', 'user_inform', 'user_accept','user_remark', 'user_approve', 'manager_accept', 'manager_remark', 'manager_approve'], 'string'],
            [['doc_date', 'present_req_date', 'price_req_date', 'user_approve_date', 'manager_approve_date'], 'safe'],
            [['size', 'first_order', 'total_order'], 'number'],
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
            'doc_date' => 'วันที่เอกสาร',
            'cust_no' => 'รหัสลูกค้า',
            'cust_name' => 'ชื่อลูกค้า ( Customer Name )',
            'product_name' => 'ชื่อสินค้า ( Product Name )',
            'product_cat' => 'Product (ประเภทผลิตภัณฑ์)',
            'product_cat_other' => 'อื่น ๆ',
            'bulk' => 'Bulk (ตัวยา)',
            'benchmark' => 'Benchmark (ผลิตภัณฑ์เปรียบเทียบ)',
            'target_group' => 'Target Group (กลุ่มลูกค้าเป้าหมาย)',
            'size' => 'Size',
            'size_unit' => 'Size Unit',
            'first_order' => 'First Order',            
            'total_order' => 'Total Order',            
            'order_unit' => 'Order Unit',
            'artwork_design' => 'Artwork Design',
            'other_detail' => 'รายละเอียดอื่น ๆ (ถ้ามี)',
            'other_detail_other' => 'อื่น ๆ',
            'present_req_date' => 'วันที่ต้องการนำเสนอบรรจุภัณฑ์',
            'price_req_date' => 'วันที่ต้องการราคา',
            'user_inform' => 'ผู้แจ้ง',
            'user_accept' => 'อนุมัติ',      
            'user_remark' => 'หมายเหตุ',                                            
            'user_approve' => 'BD. Approve',
            'user_approve_date' => 'วันที่อนุมัติ',
            //'manager_accept' => 'ตอบรับงานวิจัยและพัฒนาผลิตภัณฑ์',
            'manager_accept' => 'ตอบรับ',
            'manager_remark' => 'Remark',
            'manager_approve' => 'RD Manager',
            'manager_approve_date' => 'Manager Approve Date',
        ];
    }
}
