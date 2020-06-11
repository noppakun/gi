<?php

namespace app\controllers;

use Yii;
use app\models\Invoice;
use app\models\InvoiceSearch;
use app\models\XInvoiceExt;
 
class InvoiceAccController extends \yii\web\Controller

{

    public function actionIndex()
    { 
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionDuedateacc($CompanyCode, $Inv_Number)
    {
        $invModel = $this->findModelMaster($CompanyCode, $Inv_Number);
        $model = XInvoiceExt::findOne(['companycode' => $CompanyCode, 'inv_number' => $Inv_Number]);
        if ($model == null) {
            $model = new XInvoiceExt();
            $model->companycode = $CompanyCode;
            $model->inv_number = $Inv_Number;
        }
 

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('duedate', [
                'invModel' => $invModel,
                'model' => $model
            ]);
        }
    }
    protected function findModelMaster($CompanyCode, $Inv_Number)
    {
        if (($model = Invoice::findOne(['CompanyCode' => $CompanyCode, 'Inv_Number' => $Inv_Number])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
