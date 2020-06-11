<?php

 

namespace app\models;

use dektrium\user\models\Profile as BaseProfile;


class XProfile extends BaseProfile
{
    /*
    public function register()
    {
        // do your magic
    }
    */
    public static function tableName()
    {
        return '{{%x_profile}}';
    }    
}