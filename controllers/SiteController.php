<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl; 
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm; 
use yii\helpers\Json;



class SiteController extends \yii\web\Controller
{
    // for DepDrop 
    // AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
        // $out = \app\models\item::depDropList_Product('01','04'); 
        // echo '<pre>';
        // print_r($out);
        // echo '</pre>';
        // return;
    
    public function actionDdpifattached() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id = $parents[0];
                $param1 = null;
                if (!empty($_POST['depdrop_params'])) {
                    $params = $_POST['depdrop_params'];
                    $param1 = $params[0]; // get the value of input-type-1
                    $param2 = $params[1]; // get the value of input-type-1
                }                
                //$out = \app\models\item::depDropList_Location($id);
                
                $path=[
                    'G'=>$param2,
                    'M'=>'msds',
                    'S'=>'spec',
                ];
                // ***** windows web application server
                // $filePath = '\\\\fileserver\\iso_gpm\\pif\\'.$path[$id];   

                // ***** linux web application serve
                $filePath = '/media/pif/'.$path[$id];   
                $files=\yii\helpers\FileHelper::findFiles($filePath,['recursive'=>FALSE]);
                asort($files);
                $filelist=[];
                foreach ($files as $key=>$val) {                    
                    //$bn=iconv('TIS-620','UTF-8', basename($val)) ;
                    $bn=basename($val) ;
                    $filelist[]=['id' => $bn, 'name' => $bn];
         
                }
                $out = $filelist;
                echo Json::encode(['output'=>$out, 'selected'=>$param1]);
                return; 
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    public function actionDdbrand() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                
                $id     = empty($parents[0]) ? null : $parents[0];
                $id2    = empty($parents[1]) ? null : $parents[1];
                $id3    = empty($parents[2]) ? null : $parents[2];
                $param1 = null;

                if (!empty($_POST['depdrop_params'])) {
                    $params = $_POST['depdrop_params'];
                    $param1 = $params[0]; // get the value of input-type-1
                }                
                $out = \app\models\Item::depDropList_Brand($id,$id2,$id3);                 
                echo Json::encode(['output'=>$out, 'selected'=>$param1]);
                return; 
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    } 

    public function actionDdproduct() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                
                $id     = empty($parents[0]) ? null : $parents[0];
                $id2    = empty($parents[1]) ? null : $parents[1];
                $param1 = null;

                if (!empty($_POST['depdrop_params'])) {
                    $params = $_POST['depdrop_params'];
                    $param1 = $params[0]; // get the value of input-type-1
                }                
                $out = \app\models\Item::depDropList_Product($id,$id2);                 
                echo Json::encode(['output'=>$out, 'selected'=>$param1]);
                return; 
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }    
    
    public function actionDdgroupproduct() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id = $parents[0];
                $param1 = null;
                if (!empty($_POST['depdrop_params'])) {
                    $params = $_POST['depdrop_params'];
                    $param1 = $params[0]; // get the value of input-type-1
                }                
                $out = \app\models\Item::depDropList_GProduct($id);                 
                echo Json::encode(['output'=>$out, 'selected'=>$param1]);
                return; 
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    public function actionDdlocation() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id = $parents[0];
                $param1 = null;
                if (!empty($_POST['depdrop_params'])) {
                    $params = $_POST['depdrop_params'];
                    $param1 = $params[0]; // get the value of input-type-1
                }                
                $out = \app\models\Item::depDropList_Location($id); 
                echo Json::encode(['output'=>$out, 'selected'=>$param1]);
                return; 
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    // BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
    
    public function actionTest()
    {
       
        $filePath = '\\\\fileserver\\iso_gpm\\pif\\10-1-5311631' ;   
        $files=\yii\helpers\FileHelper::findFiles($filePath,['recursive'=>FALSE]);
         foreach ($files as $key=>$val) {
            //$bn=utf8_encode ( basename($val) );
            //$bn=mb_convert_encoding(basename($val), "UTF-8", "auto");
            $bn=iconv('TIS-620','UTF-8', basename($val)) ;
            //$bn=iconv('TIS-620','UTF-8', basename($val)) ;
            $filelist[]=['id' => $bn, 'name' => $bn];
 
        }
echo '<pre>';
        print_r($filelist);

        

    }    
// ----------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()    
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
