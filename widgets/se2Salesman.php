<?php
namespace app\widgets;

/**
 *
 * @author Noppakun
 */

class se2Salesman extends Xse2 {    
    public function init(){
        parent::init();
        $this->_sql =
            "             
                select a.SalesmanCode as sm_code, a.SalesmanName as sm_name 
                from Salesman a            
                where ((CHARINDEX('|'+rtrim(a.SalesmanCode)+'|', :idFilter) > 0)  or  (:idFilter2 = '*'))
            ";
        $this->se2_id          = 'sm_code';
        $this->se2_name        = 'sm_name';        
    }    
}
?>
