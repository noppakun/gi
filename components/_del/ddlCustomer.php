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

class ddlCustomer extends widget {    
    public $form;
    public $model;
    public $field;
    public $selectAll = false;
    public function run() {
        $connection = (Yii::$app->erpdb);
        
        $command=$connection->createCommand(            
                " select cust_no,cust_name+' ('+rtrim(cust_no)+')' as cust_desc from Customer order by cust_name"
        );
        $row=$command->queryAll();
        //$itemsArray = CHtml::listData($row, 'subteam_group_id', 'subteam_group_name');        
        $itemsArray = ArrayHelper::map($row=$command->queryAll(), 'cust_no', 'cust_desc');
         
        if ($this->selectAll) {
            $itemsArray['*']  = '*** ALL ***' ;
            asort($itemsArray);        
        }        
        return $this->form->field($this->model, $this->field)->dropDownList($itemsArray);

        
    } 
}
?>
