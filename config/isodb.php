<?php

$cfg =  [
/*
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
*/
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlsrv:Server=192.168.0.4;Database=ISO',
    //'dsn' => 'sqlsrv:Server=192.168.0.4;Database=GPM',
    'username' => 'giuser',
        
    'password' => 'computer',
    
    'charset' => 'utf8',
];
 
return $cfg;