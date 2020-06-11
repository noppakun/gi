<?php
namespace app\widgets;
/*
    1/11/2018
        year -5 +5  
*/
use yii\base\widget; 

class ddlYear extends \yii\bootstrap\Widget {
    public $form;
    public $model;
    public $field;    
    public $options   = []; // exp. : ['onchange'=>'this.form.submit()']
   
    public function run() {
        $itemsArray=[];
        $y=date("Y")-(5+1);
        for ($i = 1; $i <= (10+1); $i++) {
            $itemsArray[$y+$i]= $y+$i;    
        };              
        return $this->form->field($this->model, $this->field)->dropDownList($itemsArray,$this->options);




/*
        Html::activeDropDownList($model, 's_id',
      ArrayHelper::map(Standard::find()->all(), 's_id', 'name')) ?>     
      */
    } 
}
?>
