<?php
namespace app\components;

use yii;
//use yii\helpers\Html;

//use yii\base\Widget;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kartik\select2\Select2;
 *
 * @author Noppakun
 */

//class Xse2 extends widget 
class Xse2 extends \yii\bootstrap\Widget
{    


    public $form;
    public $model;
    public $field;
    public $selectAll = false;
    public $showToggleAll = true;  //  false : show '*** ALL ***'     true : showToggleAll=true     
    public $idFilter = '*';
    public $multiple = false;
    public $allowClear  = false;
    public $hideSearch  = false; 
    public $width       = null;    
    public $options     = []; // exp. : ['onchange'=>'this.form.submit()']
    
    
    // *************************************************
    protected $_sql;
    protected $se2_id;
    protected $se2_name;
   
    

    public function itemsQueryArrayMap(){
        $connection = (Yii::$app->erpdb);
        
        $command=$connection->createCommand($this->_sql);
         
        $command->bindParam(":idFilter" ,$this->idFilter); 
        $command->bindParam(":idFilter2",$this->idFilter); 
        $row=$command->queryAll();        
        $itemsArray = ArrayHelper::map($row=$command->queryAll(), $this->se2_id, $this->se2_name);        
        return $itemsArray;
        
    }

    public function run() {
        // $connection = (Yii::$app->erpdb);
        
        // $command=$connection->createCommand($this->_sql);
         
        // $command->bindParam(":idFilter" ,$this->idFilter); 
        // $command->bindParam(":idFilter2",$this->idFilter); 
        // $row=$command->queryAll();        
        // $itemsArray = ArrayHelper::map($row=$command->queryAll(), $this->se2_id, $this->se2_name);        
        $itemsArray = $this->itemsQueryArrayMap();
        $this->options = array_merge ( $this->options, ['multiple' => $this->multiple]  );
        if (($this->selectAll) and (!$this->showToggleAll)){
            $itemsArray['*']  = '*** ALL ***' ;
            asort($itemsArray);        
        } 
        return $this->form->field($this->model, $this->field)->widget(Select2::classname(), [            
            'data' => $itemsArray,            
            'options' => $this->options,
            // 'options' => [
                
            //     //'onchange'=>'this.form.submit()',
            // ],
            'showToggleAll'=>(($this->selectAll) and ($this->showToggleAll)),
            'pluginOptions' => [
                'allowClear'    => $this->allowClear,
                'width'         => $this->width,
                
            ],
            'hideSearch'    =>  $this->hideSearch,
            // ,'option'=>['onchange'=>'this.form.submit()']
            
            
        ]);
    } 
}
?>
