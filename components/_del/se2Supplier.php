<?php
namespace app\components;

/** 
 *
 * @author Noppakun
 */

class se2Supplier extends Xse2 {    
    function __construct() {
        $this->_sql =
            "
                select supp_number as su_code,supp_number+' : '+supp_name as su_name from supplier a
                where ((CHARINDEX('|'+rtrim(a.supp_number)+'|', :idFilter) > 0)  or  (:idFilter2 = '*'))
            ";        
        $this->se2_id          = 'su_code';
        $this->se2_name        = 'su_name';        
    }
}
?>
