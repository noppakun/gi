<?php

namespace app\controllers;

use Yii;
use app\models\SelectForm;
use app\models\ItemSearch; 
use app\models\SupplierSearch;

class QuotationController extends \yii\web\Controller
{
    // ----------------------------------------------------------------------------------------------
    public function actionPriceBySupp()
    // ----------------------------------------------------------------------------------------------
    {
        /*
        04	Raw Materials                                     
        05	Packaging Materials                               
        */        
        $SelectForm = new SelectForm();
        $searchModel = new SupplierSearch();

        $dataProvider = $searchModel->quotationPriceSearch(Yii::$app->request->queryParams);
        return $this->render('priceBySupp', [            
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]);        
        
        
    }    
    // ----------------------------------------------------------------------------------------------
    public function actionPrice()
    // ----------------------------------------------------------------------------------------------
    {
        /*
        04	Raw Materials                                     
        05	Packaging Materials                               
        */        
        $SelectForm = new SelectForm();
        $searchModel = new ItemSearch();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {                                        
            $SelectForm->ti_code = Yii::$app->request->queryParams['SelectForm']['ti_code'];             
        } else {
            $SelectForm->ti_code = '04';
        }         

        $dataProvider = $searchModel->quotationPriceSearch(Yii::$app->request->queryParams,$SelectForm);
        return $this->render('price', [
            'SelectForm'    => $SelectForm, 
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]);        
        
        
    }
     
}
