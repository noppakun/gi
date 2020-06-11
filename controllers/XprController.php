<?php

namespace app\controllers;

//use Yii;
//use app\models\XPr;
//use app\models\XPrSearch;

//use yii\web\Controller;
//use yii\web\NotFoundHttpException;
//use yii\filters\VerbFilter;

use Yii;
use app\models\XPr;
use app\models\XPrd;
use yii\web\Response;
use app\models\XUser;

/**
 * XPrController implements the CRUD actions for XPr model.
 */
class XprController extends \app\components\XETableController

{
    protected $SEARCH_MODEL =   'app\models\XPrSearchByUser';
    protected $MAIN_MODEL =   'app\models\XPr';
    protected $MAIN_MODELD = true;


    public function init()
    {
        parent::init();
        $this->VIEWPARA['TABLECAPTION'] = 'ใบขอซื้อ';
    }
    public function actionDocaction($id, $action)
    {
        $user_field = $action == 'review' ? 'review_user' : 'approve_user';
        $date_field = $action == 'review' ? 'review_date' : 'approve_date';
        $model = XPr::find()
            ->where('doc_no = :doc_no', [':doc_no' => $id])->one();
        $model[$user_field] = Yii::$app->user->identity->username;
        $model[$date_field] = \app\components\XLib::dateTimeConv(Yii::$app->formatter->asDateTime('now'), 'b');
        $model->update();
        return $this->redirect(['index']);
    }


    public function actionApi_detail($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($id == null) { // create
            $modeldjson = [];
        } else {
            $modeldjson = XPrd::find()
                ->where('doc_no = :doc_no', [':doc_no' => $id])
                ->asArray()
                ->all();
        }
        $row =  new XPrd();
        return [
            'row' => $row->attributes,
            'rows' => $modeldjson
        ];
    }

    // **********************************************************************************
    // protected function ***************************************************************
    // **********************************************************************************
    protected function afterInsert($model)
    {

        $model->doc_no = $model->genDocNumber();
        $model->doc_date = Yii::$app->formatter->asDate('now');
        $model->dept_code = XUser::findOne(Yii::$app->user->identity->id)->employee->DeptCode;
        $model->prepare_user = Yii::$app->user->identity->username;
        $model->prepare_date =  Yii::$app->formatter->asDateTime('now');
        $model->vat_type = 'i';
        $model->vat_percent = 7;

        // $model->user_inform = Yii::$app->user->identity->username;
        // $model->bd_owner = Yii::$app->user->identity->username;

        // $model->user_accept = 'N';
        // $model->manager_accept = 'N';

        // $model->product_cat = 'O';

        // if (Yii::$app->controller->id == 'xpkr') {
        //     $model->bulk = '1';
        //     $model->artwork_design = 'G';
        // }
    }

    //--------------------------------------------------------    
    // call from XETableController -> actionUpdate
    protected function modeld_update($master_model, $_m_json)
    //--------------------------------------------------------
    {

        foreach ($_m_json as $row) {        //foreach ($_m_json as $row) :
            if (!(empty($row->rec_status))) {
                if (($row->rec_status == 'n')
                    or ($row->rec_status == 'e')
                ) { // creater // edit
                    $_m_upd = ($row->rec_status == 'n') ? new XPrd() : XPrd::findOne($row->id);
                    $_m_upd->doc_no = $master_model->doc_no;
                    // ----------------------------------------
                    $_m_upd->item_desc = $row->item_desc;
                    $_m_upd->qty = $row->qty;
                    $_m_upd->uom = $row->uom;
                    $_m_upd->price = $row->price;
                    $_m_upd->remark = $row->remark;
                    // ----------------------------------------
                    $_m_upd->save();
                } elseif ($row->rec_status == 'd') { // delete
                    XPrd::findOne($row->id)->delete();
                }
            }
        }   //endforeach;  
    }

    //--------------------------------------------------------
    protected function modeld_delete($id)
    //--------------------------------------------------------
    {
        XPrd::deleteAll('doc_no = :doc_no', [':doc_no' => $id]);
    }
}
