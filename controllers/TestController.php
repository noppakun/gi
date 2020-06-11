<?php

namespace app\controllers;

use Yii;
use app\models\xTr;
use app\models\XTrd;
use app\models\XTrSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestController implements the CRUD actions for xTr model.
 */
class TestController extends Controller
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
     * Lists all xTr models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new XTrSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single xTr model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new xTr model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    // aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
    // aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
    // aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa


    protected function modeldjsonUpdate($master_id, $_m_json)
    //--------------------------------------------------------
    {
        foreach ($_m_json as $row) {        //foreach ($_m_json as $row) :
            if (!(empty($row->rec_status))) {
                if (($row->rec_status == 'n')
                    or ($row->rec_status == 'e')
                ) { // creater // edit
                    $_m_upd = ($row->rec_status == 'n') ? new xTrd() : xTrd::findOne($row->id);
                    $_m_upd->tr_id = $master_id;
                    $_m_upd->item = $row->item;
                    $_m_upd->material = $row->material;
                    $_m_upd->remark = $row->remark;
                    $_m_upd->save();
                } elseif ($row->rec_status == 'd') { // delete
                    xTrd::findOne($row->id)->delete();
                }
                //print_r($row);
            }
        }   //endforeach;  
    }

    public function actionCreate()
    //--------------------------------------------------------
    {
        $model = new xTr();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $_m_json =  json_decode(Yii::$app->request->post('modeldjson'));
            $this->modeldjsonUpdate($model->id, $_m_json);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'modeldjson' => json_encode([]),
        ]);
    }

    public function actionUpdate($id)
    //--------------------------------------------------------
    {

        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $_m_json =  json_decode(Yii::$app->request->post('modeldjson'));
            $this->modeldjsonUpdate($id, $_m_json);
            //return $this->redirect(['view', 'id' => $model->id]);
            //return $this->redirect(['index']);
        }
        $modeld = xTrd::find()
            ->where('tr_id = :tr_id', [':tr_id' => $id])
            ->asArray()
            ->all();

        return $this->render('update', [
            'model' => $model,
            'modeldjson' => json_encode($modeld),
        ]);
    }
    public function actionDelete($id)
    //--------------------------------------------------------
    {
        xTrd::deleteAll('tr_id = :tr_id', [':tr_id' => $id]);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    //bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb
    //bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb
    //bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb
    /**
     * Deletes an existing xTr model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */


    /**
     * Finds the xTr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return xTr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = xTr::findOne($id)) !== null) {
            return    $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
