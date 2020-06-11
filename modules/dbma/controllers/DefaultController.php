<?php
namespace app\modules\dbma\controllers;

use yii\web\Controller;
use yii\httpclient\Client;
/**
 * Default controller for the `dbma` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
      
    public function actionTest()
    {        
        echo '<pre>';
        //print_r($this->actionGetcontrollersandactions());
        echo '</pre>';
        //return \Yii::$app->response->redirect('http://192.168.0.5/tr/');
    }    
    public function actionIndex()
    {
        return $this->render('index');
    }
}

