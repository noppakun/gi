<?php
namespace app\widgets;

use yii\base\widget;
 

class ddlMonth extends \yii\bootstrap\Widget {
    public $form;
    public $model;
    public $field;
    public $SelectQuarter = false;
    public $selectAll = false;   
    public $options = [];
    
  
   
    public function run() {

        $itemsQuarter=[
            "Quarter"=>[
                "21"=>"Q1",  
                "22"=>"Q2",
                "23"=>"Q3",
                "24"=>"Q4",
            ]            
        ];
        $itemsArray=\app\components\XLib::monthTextArray;
  
        $labels=$this->model->attributeLabels();
        $label=$labels[$this->field];
          
        if ($this->SelectQuarter){
            $itemsMonth=[
                "Month"=>$itemsArray
            ];
            $itemsArray = $itemsQuarter+$itemsMonth;
            $label='ไตรมาส / เดือน : ' ;
            
        }
        
/*
        $itemsArray=[];        
        for ($i = 1; $i < 12; $i++) {            
            $itemsArray[$i] = date('F', mktime(0, 0, 0, ($i), 10)); 
        };        
        */
        if ($this->selectAll) {
            $itemsArray['0']  = '*** ALL ***' ;
            asort($itemsArray);        
        }            
     
        return $this->form->field($this->model, $this->field)->dropDownList($itemsArray,$this->options)->label($label);

    } 
}
?>
