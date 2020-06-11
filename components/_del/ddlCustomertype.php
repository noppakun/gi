<?php
namespace app\components;

use yii;
use yii\helpers\Html;
use yii\base\widget;
use yii\helpers\ArrayHelper;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ddlYear
 *
 * @author Noppakun
 */

class ddlCustomertype extends widget {    
    public $form;
    public $model;
    public $field;
    public $selectAll = false;
    public function run() {
        $connection = (Yii::$app->erpdb);
        
        $command=$connection->createCommand(            
                "select customertypecode ,customertypecode +':'+customertypedesc as customertypedesc from  CustomerType order by customertypecode"
        );
        $row=$command->queryAll();
        //$itemsArray = CHtml::listData($row, 'subteam_group_id', 'subteam_group_name');        
        $itemsArray = ArrayHelper::map($row=$command->queryAll(), 'customertypecode', 'customertypedesc');
         
        if ($this->selectAll) {
            $itemsArray['*']  = '*** ALL ***' ;
            asort($itemsArray);        
        }        
        return $this->form->field($this->model, $this->field)->dropDownList($itemsArray);

        
    } 
}
?>
