<?php

 

namespace app\models;

use dektrium\user\models\Token as BaseToken;

class XToken extends BaseToken
{
    /*
    public function register()
    {
        // do your magic
    }
    */
    public static function tableName()
    {
        return '{{%x_token}}';
    }    
}