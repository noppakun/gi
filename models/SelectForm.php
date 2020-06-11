<?php
namespace app\models;

use Yii;
use yii\base\Model;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SelectForm
 *
 * @author Noppakun
 */
class SelectForm extends  Model
{

    public $action;  // for let search to know is call from ?  // exp: salesinfo/index
    // ---------------------
    public $customertypecode;
    public $cust_no;
    public $cust_no2;
    public $supp_no;
    public $supp_no2;    
    public $item_number;
    public $item_number2;
    public $doctype;
    public $sm_code; // salesman
    // ---------------------
    public $date;
    public $date2;
    public $year;  
    public $year2;  
    public $month;     
    public $wh_code;
    public $ti_code; // type_invent_code
    public $co_code;
    
    // ----------------------    
    public $status;
    public $checkbox;        
    public $checkbox2;            
    public $checkbox3;         
    // ----------------------   
    public $var1; 
    public $var2; 
    public $var3;     

    public $labels = [
            'date'      =>  'วันที่ :  ',
            'date2'     =>  'ถึง :  ',
            'year'      =>  'ปี : ' ,  
            'year2'     =>  'ถึง :  ',
            'month'     =>  'เดือน : ' ,
            'customertypecode'  =>  'ประเภทลูกค้า : ' ,
            'cust_no'   =>  'ลูกค้า : ' ,
            'wh_code'   =>  'คลังสินค้า',
            'ti_code'   =>  'ประเภทสินค้า',
            'co_code'   =>  'บริษัท',
            'doctype'   =>  'ประเภทเอกสาร',
            'status'    =>  'สถานะ',            
            'sm_code'   =>  'พนักงานขาย',   
            'item_number'   =>'สินค้า : ',
            'item_number2'   =>'ถึง : ',
    ];

    public function rules()
    {
        return [

            [['date', 'date2','var1'], 'safe'],

        ];
    }



/*
    protected function beforeSave()
    {
         $this->date=date('Y-m-d', strtotime($this->date));
        return TRUE;
    }
    protected function afterFind()
    {
        $this->date=date('d-m-Y', strtotime($this->date));
        return TRUE;
    }
*/
    public function attributeLabels()
    {
        return $this->labels;
    }
 
}


?>
