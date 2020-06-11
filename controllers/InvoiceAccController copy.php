<?php

namespace app\controllers;

use Yii;
use app\models\Invoice;
use app\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InvoiceAccController implements the CRUD actions for Invoice model.
 */
class xInvoiceAccController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param string $CompanyCode
     * @param string $Inv_Number
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($CompanyCode, $Inv_Number)
    {
        return $this->render('view', [
            'model' => $this->findModel($CompanyCode, $Inv_Number),
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'CompanyCode' => $model->CompanyCode, 'Inv_Number' => $model->Inv_Number]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $CompanyCode
     * @param string $Inv_Number
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($CompanyCode, $Inv_Number)
    {
        $model = $this->findModel($CompanyCode, $Inv_Number);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'CompanyCode' => $model->CompanyCode, 'Inv_Number' => $model->Inv_Number]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $CompanyCode
     * @param string $Inv_Number
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($CompanyCode, $Inv_Number)
    {
        $this->findModel($CompanyCode, $Inv_Number)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $CompanyCode
     * @param string $Inv_Number
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($CompanyCode, $Inv_Number)
    {
        if (($model = Invoice::findOne(['CompanyCode' => $CompanyCode, 'Inv_Number' => $Inv_Number])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
