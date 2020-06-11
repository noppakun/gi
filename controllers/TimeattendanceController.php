<?php

namespace app\controllers;
//use app\models\Test;
use Yii;
use app\models\EmployeeSearch;
use app\models\SelectForm;


class TimeattendanceController extends \yii\web\Controller
{
    // public function actionView($emcode)
    // {
    //     return $this->render('view', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //         'DeptList' => $DeptList,
    //     ]);
    // }
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $params = Yii::$app->request->queryParams;
        //'supem_code'=>'110254',

        $row = \app\models\XEmployeeExt::findOne(['gi_username' => Yii::$app->user->identity->username]);
        //$row = \app\models\XEmployeeExt::findOne(['gi_username'=>'noppakun1']);
        if ($row) {
            $supervisor = $row->employee_code;
        } else {
            $supervisor = 'not found';
        }
        // $DeptCodeList = \app\models\Depart::find()
        //     ->select('DeptCode')
        //     ->where(['ImmediateSuperior' => $supervisor])
        //     ->asArray()
        //     ->all();
        $DeptCodeList=[];
        
        if ( trim($row->deptcode_ext)!==''){        
            $DeptCodeList = array_merge($DeptCodeList, array_map(function ($n) {
                // return (['DeptCode' => $n]);
                return ($n);
            }, explode(",", $row->deptcode_ext)));

        //\app\components\XLib::xprint_r($DeptCodeList);


            //$DeptCodeList = ['DeptCode' => '091'];             
            //$DeptCodeList[] = ['DeptCode' => '090'];
            //$DeptCodeList[] = ['DeptCode' => '091'];            
            //$str = explode(",", $str);
            //\app\components\XLib::xprint_r($str);
 
            //\app\components\XLib::xprint_r($b);
            //\app\components\XLib::xprint_r($DeptCodeList);

            //\app\components\XLib::xprint_r($DeptCodeList);
        }

 
        $DeptList = \app\models\Depart::find()
            ->select('Depart.DeptCode,Depart.DeptName')                        
            ->leftJoin('Section','
                Depart.Companycode=Section.Companycode
                and Depart.DeptCode=Section.DeptCode
            ')
            ->where([
                'or',
                ['IN', 'Depart.DeptCode', $DeptCodeList],
                ['IN', "concat(Depart.DeptCode,'/',Section.SectionCode)", $DeptCodeList]
            ])
            ->orderBy(['DeptName' => SORT_ASC])   
            ->distinct()
            ->asArray()
            ->all();            
            //\app\components\XLib::xprint_r($DeptCodeList);
            //\app\components\XLib::xprint_r( $DeptList);
            //\app\components\XLib::xprint_r($DeptCodeList);
        $params['TD_OPTION'] = [
            //'supervisor' => $supervisor,
            'DeptCodeList' => $DeptCodeList,
        ];

        $dataProvider = $searchModel->search($params);

  

        $SelectForm = new SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year'];
            $SelectForm->month      = Yii::$app->request->queryParams['SelectForm']['month'];
        } else {
            $SelectForm->year   = date("Y");
            $SelectForm->month  = date("n");
        }



        //\app\components\XLib::xprint_r($DeptList);


        return $this->render('index', [
            'SelectForm'    =>  $SelectForm,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'DeptList' => $DeptList, // display in index->title
            'DeptCodeList'=>$DeptCodeList,
        ]);
    }
}
