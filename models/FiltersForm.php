<?php
namespace app\models;
use Yii;
/*  
    for filter in  OdrController,PohistoryController ... 
*/ 

class FiltersForm extends \yii\db\ActiveRecord
{
    public $filters = array();
 
    
/**
     * Override magic getter for filters
     * @param string $name
     */
    public function __get($name)
    {
        if (!array_key_exists($name, $this->filters)) {
            $this->filters[$name] = '';
        }
        return $this->filters[$name];
    }


    /**
     * Override magic setter for filters
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->filters[$name] = $value;
    }



    /**
     * Filter input array by key value pairs
     * @param array $data rawData
     * @return array filtered data array
     */
    public function filter(array $data)
    {


        foreach($data AS $rowIndex => $row) {

            foreach($this->filters AS $key => $value) {
                
                // unset if filter is set, but doesn't match
                if(array_key_exists($key, $row) AND !empty($value)) {
//                    if(stripos(iconv( "TIS-620", "UTF-8", ($row[$key])), $value) === false)                    
                    if(stripos( ($row[$key]), $value) === false)                            
                        unset($data[$rowIndex]);
                }
            }
        }
        return $data;
    }
}