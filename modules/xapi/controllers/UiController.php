<?php

namespace app\modules\xapi\controllers;



/**
 * Default controller for the `epa` module
 */
class UiController extends \yii\web\Controller
{

    // const BASE_URL = 'http://192.168.0.130:8080/epa';
    //const BASE_URL = 'http://gi.greaterman.com/epa';
    //const BASE_URL = 'http://gpmclearos.poweredbyclear.com:50004/epa';    
    // const BASE_URL = 'http://192.168.0.130:8080/epa';
    //const BASE_URL = 'http://greaterman.ddns.info:50004/epa';

    // call ea app
    //const BASE_URL = 'http://greaterman.ddns.info:53001';



    private function call($act)
    {
        $BASE_URL = (substr($_SERVER['REMOTE_ADDR'],0,7) =='192.168')
            ?'http://192.168.0.5:3001'        
            :'http://greaterman.ddns.mobi:53001';
    
        //$_base_url = substr($_SERVER['REMOTE_ADDR'], 9) == "192.168.0" ? 'http://192.168.0.5/epa' : 'http://greaterman.ddns.info:50004/epa';
        $actionlist = [
            'itemrd'        =>            '/item-rd',
            'kpi'               => '/kpi_supp_date_receive',
            'matsalesorder'            =>            '/mat_salesorder',
            'prodyieldmach'            => '/prod_yieldmach',
        ];
        $string_json_fromPHP = json_encode(
            [
                // expire in 1 min.
                password_hash(substr(microtime(true), 0, 9), PASSWORD_BCRYPT),
                \Yii::$app->user->identity->auth_key
            ]
        );
        return $this->render('index', [
            'url' => $BASE_URL . $actionlist[$act] . "?iframe=" . $string_json_fromPHP,
            'string_json_fromPHP'=>$string_json_fromPHP
            //'url' => $_base_url . $actionlist[$act]
        ]);
    }

    public function actionItemrd()
    {
        return $this->call('itemrd');
    }
    public function actionKpi()
    {
        return $this->call('kpi');
    }

    public function actionMatsalesorder()
    {
        return $this->call('matsalesorder');
    }

    public function actionProdyieldmach()
    {
        return $this->call('prodyieldmach');
    }
}
