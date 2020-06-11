<?php
namespace app\widgets;

/**
 *
 * @author Noppakun
 */

class se2Company extends Xse2 {    
    public function init(){
        parent::init();
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

 