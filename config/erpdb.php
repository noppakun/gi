<?php

return [
/*
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
*/
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlsrv:Server=192.168.0.4;Database=GPM',
  //  'dsn' => 'sqlsrv:Server=192.168.0.4;Database=NBO',    
//    'dsn' => 'sqlsrv:Server=192.168.0.4;Database=gpm_test',
    'username' => 'giuser',
    'password' => 'computer',
    
    'charset' => 'utf8',
    
];
