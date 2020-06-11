<?php
namespace app\widgets;

/**
 *
 * @author Noppakun
 */

class se2Warehouse extends Xse2 {    
    public function init(){
        parent::init();
        $this->_sql =
            "             
                select a.whcode as wh_code, a.whcode as wh_name 
                from warehouse a            
                where ((CHARINDEX('|'+rtrim(a.whcode)+'|', :idFilter) > 0)  or  (:idFilter2 = '*'))
            ";
        $this->se2_id          = 'wh_code';
        $this->se2_name        = 'wh_name';        
    }    
}
?>
