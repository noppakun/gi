<?php

namespace app\components;

use Yii;

const NOTIFY_USERS_APPROVE = [
    'parun',     // MD    
    'mayura',

    'jirapat',   // RD
    'nittaya',
    'siriwan',
    'jiraporn',   // k.jeed  9/1/2020                  


    'woranuth',   // BD
    'pattiya',
    'punnee',
    'kanlaya',

    'noppakun',   // IT
];
const NOTIFY_USERS_CREATE_UPDATE = [

    'woranuth',   // BD
    'pattiya',
    'punnee',
    'kanlaya',

    'noppakun',   // IT
];
const NOTIFY_USERS_CREATE_UPDATE_PKR = [

    'woranuth',   // BD
    'pattiya',
    'punnee',
    'kanlaya',
    // 'jiraporn',   // k.jeed  8/1/2020 => create // 9/1/2020  k.jeed  ไม่เอาแล้ว ย้ายไป approve  แทน


    'noppakun',   // IT
];

class XNotify //extends Component
{
    //xnotify::notify('ทดสอบหัวข้อ', 'ทดสอบข้อความ');


    static $notifyList = [
        // PDR
        [
            'act' => 'app/xpdr/cancel',
            'users' => NOTIFY_USERS_CREATE_UPDATE,
        ],
        [
            'act' => 'app/xpdr/create',
            'users' => NOTIFY_USERS_CREATE_UPDATE,
        ],
        [
            'act' => 'app/xpdr/update',
            'users' => NOTIFY_USERS_CREATE_UPDATE,
        ],
        [
            'act' => 'app/xpdr/update/bd_approve',
            'users' => NOTIFY_USERS_APPROVE,
        ],
        [
            'act' => 'app/xpdr/update/rd_approve',
            'users' => NOTIFY_USERS_APPROVE,
        ],


        // PKR
        [
            'act' => 'app/xpkr/cancel',
            'users' => NOTIFY_USERS_CREATE_UPDATE_PKR,
        ],
        [
            'act' => 'app/xpkr/create',
            'users' => NOTIFY_USERS_CREATE_UPDATE_PKR,
        ],
        [
            'act' => 'app/xpkr/update',
            'users' => NOTIFY_USERS_CREATE_UPDATE_PKR,
        ],
        [
            'act' => 'app/xpkr/update/bd_approve',
            'users' => NOTIFY_USERS_APPROVE,
        ],
        [
            'act' => 'app/xpkr/update/rd_approve',
            'users' => NOTIFY_USERS_APPROVE,
        ],



        // AAAAAAAAAAAAAAAAAAAAAAAAA
        // --------- test
        [
            'act' => 'dbma/xquery/view',
            'users' => [
                'noppakun',
                //'itadmin',
                //'tassanai',
            ],
        ],
        [
            'act' => 'dbma/xquery/view/TOSPREADSHEET',
            'users' => [
                'noppakun',
            ],

        ]
        // BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
    ];

    // ----------------------------------------------------------------------------------
    public function notify($subject, $message = '', $actTag = null)
    // --------------------------------------------------------------------------------
    {

        // ------------------ get action
        $act = Yii::$app->controller->module->id
            . '/' . Yii::$app->controller->id
            . '/' . Yii::$app->controller->action->id
            . ($actTag == null ? '' : '/' . $actTag);
        $key = array_search($act, array_column(self::$notifyList, 'act'));
        if ($key === null) {
            $_username = ['noppakun'];
            $subject = 'array_search not found';
            $message = '(' . $act . ')';
        } else {
            $_username = self::$notifyList[$key]['users'];
        }

        // ------------------ get mail list
        $rows = \app\models\XUser::find()->where(['username' => $_username])->all();
        $emaillist = array_map(function ($object) {
            return $object->email;
        }, $rows);

        if ($subject == '@GETACT') {
            $emaillist = ['noppakun@greaterman.com'];
            $message = $act;
        }
        // *********************************************************8
        if (Yii::$app->user->identity->username == 'noppakun') {
            return; // for test
        }
        // *********************************************************8
        //  --------------  send notify_mail         
        Yii::$app->mailer->compose()
            ->setFrom('itadmin@greaterman.com')
            ->setTo($emaillist)
            ->setSubject($subject)
            ->setTextBody(
                $message
                // .'('.$key.')'
                // .$act
            )
            ->send();

        // \app\components\XLib::xprint_r($emaillist);


    }
}