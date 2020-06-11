<?php
namespace app\widgets;
 
use yii\web\JsExpression;
use kartik\select2\Select2;

use app\models\Item;
 
class se2aItem extends  \yii\bootstrap\Widget {
    public $form;
    public $model;
    public $field;    
    public $options   = []; // exp. : ['onchange'=>'this.form.submit()']
   
    public function run() {        
        return  $this->form->field($this->model, $this->field)->widget(Select2::classname(), [
            'initValueText' => ($_it = Item::findOne($this->model[$this->field])) ? $_it->Item_Number.' : '.$_it->Item_Name : '',
            'options' => $this->options,            
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['/xapi/json-list/item']),   
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                
                // 'language' => [
                //     'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                // ],
                // 'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                // 'templateResult' => new JsExpression('function(Item_Number) { return Item_Number.text; }'),
                // 'templateSelection' => new JsExpression('function (Item_Number) { return Item_Number.text; }'),
            ],
        ]);
 
    } 
}
