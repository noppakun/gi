<?php

namespace app\controllers;
use Yii;
use app\models\PODetailSearch; 
class PoHistoryController extends \yii\web\Controller
{
    public function actionIndex($viewby=null,$viewby_code=null)
    {

        // call by quotation / price-by-supp
        $searchModel = new PODetailSearch();       
        
            
        $params = Yii::$app->request->queryParams;

        if ($viewby!=null){    
            if ($viewby=='supp'){    
                $params['PODetailSearch']['Supp_Number'] = $viewby_code;            
            }else if ($viewby=='item'){    
                $params['PODetailSearch']['Item_Number'] = $viewby_code;                            
            }    
        }

 
        $dataProvider = $searchModel->search($params);

        return $this->render('index',[
            'dataProvider'=>$dataProvider,
            'searchModel'=>$searchModel,            
            'viewby' =>$viewby,                
            'viewby_code'=>$viewby_code,                
        ]);
    }

}
