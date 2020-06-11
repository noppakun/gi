<?php
namespace app\widgets;

/** 
 *
 * @author Noppakun
 */

class se2Typeinvent extends Xse2 {    
    public function init(){
        parent::init();
        $this->_sql =
            "
                select Type_Invent_Code as ti_code,Type_Invent_desc as ti_name from Type_Invent a
                where ((CHARINDEX('|'+rtrim(a.Type_Invent_Code)+'|', :idFilter) > 0)  or  (:idFilter2 = '*'))
            ";        
        $this->se2_id          = 'ti_code';
        $this->se2_name        = 'ti_name';        
    }
}
?>
