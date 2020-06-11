<?php
namespace app\components;

/**
 *
 * @author Noppakun
 */

class se2Customertype extends Xse2 {    
    function __construct() {
        $this->_sql =        
            "        
            

                select customertypecode ,customertypecode +':'+customertypedesc as customertypedesc 
                from  CustomerType 
                where ((CHARINDEX('|'+rtrim(customertypecode)+'|', :idFilter) > 0)  or  (:idFilter2 = '*'))                
                order by customertypecode

            ";
        $this->se2_id          = 'customertypecode';
        $this->se2_name        = 'customertypedesc';        
    }    
}
?>



 