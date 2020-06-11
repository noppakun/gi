<?php
namespace app\widgets;

/**
 *
 * @author Noppakun
 */
// waste Category
class se2Wca extends Xse2 {    
    public function init(){
        parent::init();
        $this->_sql =
            "             
                select rtrim(a.refcode) as wca_code, a.refname as wca_name
                from x_refdata a            
                where a.reftype='WCA' and  ((CHARINDEX('|'+rtrim(a.refcode)+'|', :idFilter) > 0)  or  (:idFilter2 = '*'))
            ";
        $this->se2_id          = 'wca_code';
        $this->se2_name        = 'wca_name';        
    }    
}
?>
