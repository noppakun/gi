<?php
namespace app\widgets;

/**
 *
 * @author Noppakun
 */

class se2DocType extends Xse2 {    
    public function init(){
        parent::init();
        $this->_sql =
            "
            select doctype,   doctypedesc as docname 
            from doctype a
            where ((CHARINDEX('|'+rtrim(a.doctype)+'|', :idFilter) > 0)  or  (:idFilter2 = '*'))
             
            order by doctype
            ";
        $this->se2_id          = 'doctype';
        $this->se2_name        = 'docname';        
    }
}
?>

 