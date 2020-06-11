<?php
namespace app\widgets;

/**
 *
 * @author Noppakun
 */

class se2Customertype extends Xse2 {    
    public function init(){
        parent::init();
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



 