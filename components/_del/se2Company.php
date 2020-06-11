<?php
namespace app\components;

/**
 *
 * @author Noppakun
 */

class se2Company extends Xse2 {    
    function __construct() {
        $this->_sql =
            "
                select companycode as co_code,companycode+' : '+companyname as co_name 
                from Company a
                where ((CHARINDEX('|'+rtrim(a.companycode)+'|', :idFilter) > 0)  or  (:idFilter2 = '*'))
                order by companycode
            ";
        $this->se2_id          = 'co_code';
        $this->se2_name        = 'co_name';        
    }
}
?>

 