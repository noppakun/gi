<?php
namespace app\widgets;

/**
 *
 * @author Noppakun
 */

class se2Customer extends Xse2 {      
    public function init()
    {
        parent::init();
        $this->_sql =        
            "        
                select cust_no,cust_name+' ('+rtrim(cust_no)+')' as cust_desc 
                from Customer 
                where ((CHARINDEX('|'+rtrim(cust_no)+'|', :idFilter) > 0)  or  (:idFilter2 = '*'))
                order by cust_name 

            ";
        $this->se2_id          = 'cust_no';
        $this->se2_name        = 'cust_desc';  
    }       
}
?>



 