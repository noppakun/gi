<?php
namespace app\widgets;

/**
 *
 * @author Noppakun
 */

class se2Uom extends Xse2 { 
    public function init(){
        parent::init();
        $this->_sql =
            "
                select a.uom_from as uom ,a.uom_from+' :  '+a.from_desc as name from uom a 
                where ((CHARINDEX('|'+rtrim(a.uom_from)+'|', :idFilter) > 0)  or  (:idFilter2 = '*'))
                order by a.uom_from
            ";
        $this->se2_id          = 'uom';
        $this->se2_name        = 'name';        
    }    
}
?>
