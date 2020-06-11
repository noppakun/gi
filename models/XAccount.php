<?php

 

namespace app\models;

use dektrium\user\models\Account as BaseAccount;

class XAccount extends BaseAccount
{
    /*
    public function register()
    {
        // do your magic
    }
    */
    public static function tableName()
    {
        return '{{%x_social_account}}';
    }    
}