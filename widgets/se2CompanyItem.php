<?php
namespace app\widgets;

/**
 *
 * @author Noppakun
 */

class se2CompanyItem extends Xse2 {    
    public function init(){
        parent::init();
        $this->_sql =
            "
                select rtrim(companycode) as co_code,companycode as co_name 
                from Company a
                where ((CHARINDEX('|'+rtrim(a.companycode)+'|', :idFilter) > 0)  or  (:idFilter2 = '*'))
                and companycode in (select distinct companycode from Item)
                order by companycode
            ";
        $this->se2_id          = 'co_code';
        $this->se2_name        = 'co_name';        
    }
}
?>

 