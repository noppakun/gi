<?php
namespace app\components;

/**
 *
 * @author Noppakun
 */

class se2Salesman extends Xse2 {    
    function __construct() {
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
