<?php

namespace app\controllers;

use Yii; 
use app\models\Item;
use app\models\ItemSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemInfoController implements the CRUD actions for Item model.
 */
class ItemInfoController extends Controller
{
    /**
     * {@inheritdoc}
     */
 
    public function actionPackaging()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->searchPackaging(Yii::$app->request->queryParams);

        return $this->render('packaging', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($id)
    {
        //$model = $this->findModel($id);
        $model = Item::findOne($id);
        $VIEWPARA=[];
        $VIEWPARA['model'] = $model;
        //$VIEWPARA['viewmode'] = $viewmode;
        return $this->render('packaging_view', $VIEWPARA);
    
    }   
   
}
