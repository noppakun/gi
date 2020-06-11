<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    //'bootstrap' => ['log','assetsAutoCompress'],
    // !! test 11-10-19  remark
    //'timezone' => 'Asia/Bangkok',


    /*
        set timezone แล้ว  php ดึงข้อมูลจาก database  มาจะมา +7 อีกรอบ
        'format' => ['datetime'], ใน gridview แสดงไม่ถูกต้อง (GilogsController)
        
    */
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [

        'xapi'      => ['class' => 'app\modules\xapi\Module',],
        'report'    => ['class' => 'app\modules\report\Module',],
        'dbma'      => ['class' => 'app\modules\dbma\Module',],

        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            //'downloadAction' => 'gridview/export/download',
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'modelMap' => [
                'Account' => 'app\models\XAccount',
                'Profile' => 'app\models\XProfile',
                'Token' => 'app\models\XToken',
                'User' => 'app\models\XUser',

            ],

            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin', 'noppakun', 'tassanai']
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    //'userClassName' => 'dektrium\user\models\User',
                    'userClassName' => 'app\models\XUser',
                    'idField' => 'id', // id field of model User
                ]
            ],
            'layout' => 'left-menu', // default null. other avaliable value 'right-menu' and 'top-menu'          
            'mainLayout' => '@app/views/layouts/main.php',

        ],
        // 'datecontrol' =>  [
        //     'class' => '\kartik\datecontrol\Module'
        // ]        

    ],
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    //'@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'


                    // '@app/views' => in_array($_SERVER['REMOTE_ADDR'] , ['192.168.0.232'])
                    //     ? '@app/views/themes/adminlte'
                    //     : '@app/views',
                    //'@app/views' => '@app/views/themes/adminlte',
                    '@app/views' => '@app/views',
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'RHUck6ZyP8kA9D3qpWAP4kncIyJWf4PQ',
            //'enableCsrfValidation' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // 'user' => [
        //     'identityClass' => 'app\models\User',
        //     'enableAutoLogin' => true,
        // ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => true,
            'useFileTransport' => false,
            // 'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => 'mail2.greaterman.com',
            //     'username' => 'mail@greaterman.com',
            //     'password' => 'GpM@028868866',
            //     'port' => '587',
            //     //'encryption' => 'STARTTLS',
            // ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.greaterman.com',
                'username' => 'itadmin@greaterman.com',
                'password' => '028868866',
                'port' => '587',
                //'encryption' => 'STARTTLS',
            ],


        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        //'db' => $db,
        'db'    => require(__DIR__ . '/db.php'),
        'erpdb' => require(__DIR__ . '/erpdb.php'),
        'isodb' => require(__DIR__ . '/isodb.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        // AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

        'authManager' => [
            'class' => 'yii\rbac\DbManager',

            'itemTable' => 'x_auth_item',
            'assignmentTable' => 'x_auth_assignment',
            'itemChildTable' => 'x_auth_item_child',
            'ruleTable' => 'x_auth_rule',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            //'dateFormat' => 'php:d/m/Y',                         
            //'datetimeFormat' => 'php:d/m/Y H:i:s',

            //'dateFormat' => 'php:d-m-Y',             
            'dateFormat' => 'dd-MM-yyyy',
            'datetimeFormat' => 'php:d-m-Y H:i:s',



            //'timeFormat' => 'php:H:i:s',
            'timeFormat' => 'php:H:i',
            // !!! test 11-10-19  set
            'timeZone' => 'Asia/Bangkok',


            //'dateControlDisplayTimezone'=>  'Asia/Bangkok',
            //'dateControlDisplayTimezone'=>  'Europe/Rome',   
            // !!! test 11-10-19  set 
            'defaultTimeZone' => 'Asia/Bangkok',

        ],
    ],

    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [

            //'xpr/*',
            // ------- common -------------
            'debug/*',
            //---------- for test ------------------
            // 'salesinfo/rawdata',
            //'batch-packing-record/*',
            // 'batch-packing-record/jlist',
            // 'batch-packing-record/getdata',







            //%2Fcompany%2Fcreate
            // ----- for vue api call ------------------------------
            'xapi/production/*',
            'xapi/planning/*',
            'xapi/kpi/*',
            'xapi/cash-flow/*',
            'xapi/cashflows/*',
            'xapi/hr/*',
            'xapi/json-list/*',
            // -----------------------------------
            'alarm/alarmtable', // add or remove allowed actions to this list
            'site/*',
            'user/security/login',
            'user/security/logout',
            'hr/calender',
            'gridview/export/download',
            'xjobtracking/notify',
            'xfdaregister/notify',
            'dbma/xquery/v_parcel_list',



            //,            '*', // for all
        ],
        // 'denyActions' => [
        //     'xapi/ui/*',
        // ],


    ],
    'on beforeAction' => function ($event) {
        // To log action   
        if (!in_array(
            Yii::$app->controller->id . '/' . Yii::$app->controller->action->id,
            [
                'site/index',
                'gilogs/index',
            ]
        )) {
            $params = Yii::$app->request->queryString;
            $params = str_replace("%2F", "/", $params);
            $params = str_replace("%5B", "[", $params);
            $params = str_replace("%5D", "]", $params);
            $params = str_replace("&", "\n", $params);

            $username = (isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username : 'n/a');
            $sql = "insert into  x_gi_logs (username , ipaddress , logtime , controller, action , details ) "
                . "VALUES ('" . $username . "','" . $_SERVER['REMOTE_ADDR'] . "',getdate(),'" . Yii::$app->controller->id . "','" . Yii::$app->controller->action->id . "','" . $params . "')";

            $command = Yii::$app->db->createCommand($sql);
            $command->execute();
        }
        return $event;
    },
    'params' => $params,
];

if (YII_ENV_DEV) {
//if (true) {

    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['192.168.0.130'],
        //'allowedIPs' => [ '*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'allowedIPs' => ['*'],
        'generators' => [ // HERE
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'adminlte' => '@vendor/dmstr/yii2-adminlte-asset/gii/templates/crud/simple',
                ]
            ]
        ],

    ];
}

return $config;
