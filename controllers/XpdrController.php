<?php

namespace app\controllers;

use Yii;

use yii\web\UploadedFile;
use app\models\FileUpload;
use app\models\SelectForm;
use app\models\XPdr;
use app\models\XPkr;

use app\components\XLib;
use app\components\XPrintForm;
use app\components\XNotify;
use yii\helpers\ArrayHelper;

use yii\web\Response;
//class XfdaregisterController extends \app\components\XETableController

//class XpdrController extends \app\components\XQEdit\XQEditController
class XpdrController extends \app\components\XETableController
{
    protected $MAIN_MODEL         =   'app\models\XPdr';
    protected $SEARCH_MODEL     =   'app\models\XPdrSearch';
    protected $VIEWPARA      =   [
        'TABLECAPTION' =>  'ใบแจ้งเพื่อขอให้พัฒนาผลิตภัณฑ์',
    ];
    protected $IMAGE_PATH      =   'images/xpdr/';
    // --------------------------
    protected $VIEWPATH         =   '@app/views/xpdr/';
    // --------------------------------------------------------
    function bdOwnerList()
    // --------------------------------------------------------
    {
        $connection = (Yii::$app->erpdb);
        $command = $connection->createCommand(
            " 
            select c.gi_username as code ,c.gi_username as name
                from Salesman a
                left join x_salesman_ext b on a.SalesmanCode=b.salesman_code
                left join x_employee_ext c on b.employee_code = c.employee_code
                where b.salesman_code is not null
            order by c.gi_username
            "
        );
        return $command->queryAll();
    }
    // --------------------------------------------------------
    function rdOwnerList()
    // --------------------------------------------------------
    {
        $_doc_type = ((Yii::$app->controller->id == 'xpkr') ? 'P' : 'B');
        $connection = (Yii::$app->erpdb);
        $command = $connection->createCommand(
            " 
            select a.em_name as code,a.em_name  as name
            from ( VALUES 
                ('B','kanita'),
                ('B','warangkhana'),
                ('B','ratchadaporn'),                
                ('B','jutaporn'),
                ('B','siriwan'),
                ('B','kansiree'),	

                ('P','jiraporn'),
                ('P','sopa')
            ) as a(doc_type,em_name)
           
            where a.doc_type=:doc_type
            order by a.em_name
            "
        );

        $command->bindParam(":doc_type", $_doc_type);

        return $command->queryAll();
    }

    // --------------------------------------------------------
    public function actionCancel($id = null)
    // --------------------------------------------------------
    {
        $model = $this->findModel($id);
        $model->scenario = 'cancel';
        if ($model->load(Yii::$app->request->post())) {
            $subject = 'Cancel ' . $this->VIEWPARA['TABLECAPTION']
                . ' : ' . $model->doc_no
                . ' BD : ' . $model->bd_owner;;
            XNotify::notify($subject, $subject . ' ( action user : ' . Yii::$app->user->identity->username . ' )');


            $model->cancel_user = Yii::$app->user->identity->username;

            $model->cancel_date = XLib::dateTimeConv(Yii::$app->formatter->asDateTime('now'), 'b');
            $model->save();
            return $this->redirect(['update', 'id' => $id]);
        } else {
            $this->VIEWPARA['model'] = $model;
            return $this->render($this->VIEWPATH . 'rdowner_cancel', $this->VIEWPARA);
        }
    }
    // --------------------------------------------------------
    public function actionRdowner($id = null, $page = 1)
    // --------------------------------------------------------
    {


        $model = $this->findModel($id);
        // error
        if ($model->manager_approve == null) {
            return $this->redirect(['/']);
            //return Yii::warning("Division by zero.");
        }
        // **********************************

        //\app\components\XLib::xprint_r(Yii::$app->request->queryParams);


        $model->scenario = 'rdowner';
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            //return $this->redirect(['update', 'id' => $id]);
            return $this->redirect(['index', 'page' => $page]);
        } else {
            $this->VIEWPARA['model'] = $model;
            $this->VIEWPARA['rdOwnerList'] =  ArrayHelper::map($this->rdOwnerList(), 'code', 'name');
            $this->VIEWPARA['page'] = $page;
            return $this->render($this->VIEWPATH . 'rdowner_cancel', $this->VIEWPARA);
        }
    }
    // -------------------------------------------------------------------------------           
    function key2value($key, $array)

    {
        return array_key_exists($key, $array) ? $array[$key] : '';
    }

    // -------------------------------------------------------------------------------        
    //public function actionTospreadsheet(array $searchModel = null)
    public function actionTospreadsheet(array $searchModel = null)
    // -------------------------------------------------------------------------------        
    {


        $_cid = Yii::$app->controller->id; // xpdr, xpkr

        $_searchModel = new $this->SEARCH_MODEL();
        $queryParams = Yii::$app->request->queryParams;
        $className = explode('\\', get_class($_searchModel));
        $className = $className[count($className) - 1];
        //$queryParams[$className] =  $queryParams['searchModel'];
        $queryParams[$className] =  $searchModel;

        if (!isset($queryParams['searchModel'])) {
            $queryParams['searchModel'] = [];
        }
        if (!isset($queryParams['SelectForm']['checkbox'])) {
            $queryParams['SelectForm']['checkbox']  = [];
        }

        //--------------------
        // if (Yii::$app->user->identity->username == 'noppakun') {            
        //     //\app\components\XLib::xprint_r($SelectForm);
        //     \app\components\XLib::xprint_r($queryParams);

        //     return;
        // }  
        //-------------------------   

        $dataProvider = $_searchModel->search($queryParams);


        $rows = $dataProvider->query->all();

        foreach ($rows as $key => $row) {
            $row->product_cat = xpdr::$product_cat_LIST[$row->product_cat];
            $row->size_unit = $this->key2value($row->size_unit, xpkr::$size_unit_LIST);
            $row->order_unit = $this->key2value($row->order_unit, xpkr::$order_unit_LIST);

            if ($_cid == 'xpkr') {
                $row->bulk = xpkr::$bulk_LIST[$row->bulk];
                $row->artwork_design = $this->key2value($row->artwork_design, xpkr::$artwork_design_LIST);
                $option = [
                    'noExportColumns' => [0, 3, 7, 8, 13, 14, 16, 17, 18, 20, 21, 22, 26, 28, 29, 32, 38, 39],
                    /*
                        export only 
                        Doc_No	Doc_Date	Cust_Name	Product_Name	Product_Cat	Bulk_Note	Benchmark	Target_Group	Size_Text	Order_Text	Artwork_Design	Other_Detail_Other_Text	Present_Req_Date	Price_Req_Date	User_Accept	User_Approve_Date	Manager_Accept	Manager_Approve	Manager_Approve_Date	Bd_Owner	Rd_Owner	Cancel_Date
                    */
                ];
            } elseif ($_cid == 'xpdr') {
                $row->packaging_conclude = $this->key2value($row->packaging_conclude, [false => 'รอสรุป', true => 'สรุปแล้ว']);
                $option = [
                    'noExportColumns' => [0],
                ];
            }
        };


        //return '';

        $filename = $_cid . '.xls';
        \app\components\XExport::x2xls($rows, $filename, $option);
        (new Response())->sendFile($filename)->send();
        unlink($filename);
    }
    //******************************************************** */    
    public function actionIndex()
    // --------------------------------------------------------
    {

        $SelectForm = new SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->checkbox   = Yii::$app->request->queryParams['SelectForm']['checkbox'];
        } else {
            $SelectForm->checkbox   = [];
        }
        if ($SelectForm->checkbox == null) {
            $SelectForm->checkbox = [];
        }

        $searchModel = new $this->SEARCH_MODEL();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['SelectForm']['checkbox']  = $SelectForm->checkbox;
        $dataProvider = $searchModel->search($queryParams);



        $this->VIEWPARA['searchModel'] = $searchModel;
        $this->VIEWPARA['dataProvider'] = $dataProvider;
        $this->VIEWPARA['SelectForm'] = $SelectForm;
        $this->VIEWPARA['bdOwnerList'] =  ArrayHelper::map($this->bdOwnerList(), 'code', 'name');
        $this->VIEWPARA['rdOwnerList'] =  ArrayHelper::map($this->rdOwnerList(), 'code', 'name');


        //\app\components\XLib::xprint_r(count($dataProvider->query->all()));         
        // \app\components\XLib::xprint_r($queryParams);

        return $this->render(
            $this->VIEWPATH .
                //'@app/views/xpdr/'.
                'index',
            $this->VIEWPARA
        );
    }

    public function afterInsert($model)
    {

        $model->user_inform = Yii::$app->user->identity->username;
        $model->bd_owner = Yii::$app->user->identity->username;
        $model->doc_date = Yii::$app->formatter->asDate('now');
        $model->doc_no = $model->genDocNumber();
        $model->user_accept = 'N';
        $model->manager_accept = 'N';

        $model->product_cat = 'O';

        if (Yii::$app->controller->id == 'xpkr') {
            $model->bulk = '1';
            $model->artwork_design = 'G';
        }
    }
    public function actionRevise($id)
    {
        return $this->actionCopy($id, $action = 'REVISE');
    }
    //public function actionRevise($id)
    private function reviseDocNumber($id)
    {

        $model = $this->findModel($id);
        $_masterdoc_no =  substr($model->doc_no, 0, 10);
        $sql = " select top 1 doc_no from "
            . ((Yii::$app->controller->id == 'xpkr') ? 'x_pkr' : 'x_pdr') .
            "
            where left(doc_no,10) = '" . $_masterdoc_no  . "'
            order by doc_no desc
        ";
        $_rows = $model::findBySql($sql)->all();
        //echo '<br><br>';        
        //print_r($ret);
        return  $_masterdoc_no . 'R' . (((int) substr($_rows[0]['doc_no'], 11, 10)) + 1);
    }
    public function actionCopy($id, $action = 'COPY')
    { // approve from BD.MG.
        $model = $this->findModel($id);
        $model2 = new $this->MAIN_MODEL();
        $model2->setAttributes($model->attributes);
        if ($action == 'REVISE') {
            $model2->doc_no = $this->reviseDocNumber($id);
        } else {    // $action = 'COPY'
            $model2->doc_no = $model->genDocNumber();
        }


        $model2->doc_date = Yii::$app->formatter->asDate('now');

        $model2->user_inform = Yii::$app->user->identity->username;

        $model2->user_approve = null;
        $model2->user_approve_date = null;        

        $model2->manager_accept = 'N';
        $model2->manager_approve = null;
        $model2->manager_approve_date = null;

        $model2->bd_approve_request_date = null;

        //$model2->bd_owner = null;
        //$model2->rd_owner = null;
        if ($model2->validate()) {
            $model2->save();
            if (Yii::$app->controller->id == 'xpkr') {
                $rows = \app\models\XPkrD::find()->andFilterWhere(['pkr_id' => $id])->all();
                $arows = array_map(function ($value){
                    // pkr_id,item,material,owner,remark   
                    return [null, $value->item, $value->material, $value->owner, $value->remark];
                    //return [999, $value->item, $value->material, $value->owner, $value->remark];                
                }, $rows);
                array_walk($arows, function (&$item2, $key, $pid) {
                    $item2[0] = $pid;            
                }, $model2->id);
                
    
                Yii::$app->db->createCommand()->batchInsert(
                    'x_pkr_d',
                    ['pkr_id', 'item', 'material', 'owner', 'remark'],
                    $arows
                )->execute();
            }
    
             return $this->redirect(['index']);            
        } else {
            // validation failed: $errors is an array containing error messages
           
            return $this->render(
                $this->VIEWPATH .                    
                    'error',                
                ['errors'=> $model2->errors]
            );            
        }

        
    }

    public function actionApprove1($id)
    { // approve from BD.MG.
        $model = $this->findModel($id);
        $model->user_approve = Yii::$app->user->identity->username;
        $model->user_approve_date = \app\components\XLib::dateConv(Yii::$app->formatter->asDate('now'), 'b');

        $model->save();
        return $this->redirect(['index']);
    }

    // -- ยกเลิกการใช้ปุ่ม delete k.jeed 6/9/2019

    // public function actionDelete($id = null)
    // {
    //     $model = $this->findModel($id);
    //     //$image_file = 'images/xpdr/' . $model->doc_no . '.jpg';
    //     $image_file = $this->IMAGE_PATH . $model->doc_no . '.jpg';
    //     if (file_exists($image_file)) {
    //         unlink($image_file);
    //     }
    //     $model->delete();
    //     return $this->redirect(['index']);
    // }

    public function actionDeleteimage($id = null, $image_file)
    {
        if (file_exists($image_file)) {


            if (Yii::$app->controller->id == 'xpkr') {
                $modelmaster = $this->findModel($id);
                $modelmaster->other_detail_picture = 0;
                $modelmaster->save();
            }

            unlink($image_file);
        }
        return $this->redirect(['image', 'id' => $id]);
    }
    public function actionImage($id = null)
    {


        $modelmaster = $this->findModel($id);



        $model = new FileUpload();
        $this->VIEWPARA['model'] = $model;
        $this->VIEWPARA['modelmaster'] = $modelmaster;

        if (Yii::$app->request->isPost) {
            $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
            //if ($model->upload('images/xpdr/', $modelmaster->doc_no)) {     // file is uploaded successfully
            if ($model->upload($this->IMAGE_PATH, $modelmaster->doc_no)) {     // file is uploaded successfully
                if (Yii::$app->controller->id == 'xpkr') {
                    $modelmaster->other_detail_picture = 1;
                    $modelmaster->save();
                }
                $this->VIEWPARA['download'] = true;
                return $this->redirect(['update', 'id' => $modelmaster->id]);
            }
        }
        $this->VIEWPARA['download'] = false;
        $this->VIEWPARA['IMAGE_PATH'] = $this->IMAGE_PATH;

        return $this->render($this->VIEWPATH . 'image', $this->VIEWPARA);
    }



    public function actionUpdate($id = null, $viewmode = false)
    {

        if ($id == null) { // create            
            $model = new $this->MAIN_MODEL();
            // new function 28/8/2018
            $this->afterInsert($model);
        } else {
            $model = $this->findModel($id);
            // cancel 28/8/2018
            // $this->afterLoad($model);            
        }
        if ($this->MODEL_SCENARIO != 'default') {
            $model->scenario = $this->MODEL_SCENARIO;
        }

        if ($model->load(Yii::$app->request->post())) {
            // cancel 28/8/2018
            // $this->beforeSave($model);    


            $_remark = '';
            if (isset($_POST['bt_approve1'])) {
                $model->user_approve = Yii::$app->user->identity->username;
                $model->user_approve_date   = XLib::dateConv(Yii::$app->formatter->asDate('now'), 'b');
                $_act = 'bd_approve';
                $_acttext = 'BD Approve';
                $_remark = 'หมายเหตุ : ' . $model->user_remark;
            } elseif (isset($_POST['bt_approve2'])) {
                $model->manager_approve = Yii::$app->user->identity->username;
                $model->manager_approve_date   = XLib::dateConv(Yii::$app->formatter->asDate('now'), 'b');
                $_act = 'rd_approve';
                $_acttext = 'RD Approve';
                $_remark = 'หมายเหตุ : ' . $model->manager_remark;
            } else {
                $_act = '';
                $_acttext = ($id == null) ? 'New' : 'Update';
                $_acttext = '_SKIP_';
            }
            if ($_acttext !== '_SKIP_') {
                $_owner = 'BD : ' . $model->bd_owner;
                $subject = $_acttext . ' ' . $this->VIEWPARA['TABLECAPTION']
                    . ' : ' . $model->doc_no
                    . ' ' . $_owner;
                XNotify::notify(
                    $subject,
                    $subject . ' ( action user : ' . Yii::$app->user->identity->username . ' ) ' . $_remark,
                    $_act
                );
            }



            $model->save();
            return $this->redirect(['index']);
        } else {
            //\app\components\XLib::xprint_r($model->attributes);
            //\app\components\XLib::xprint_r($model->attributeLabels());

            //$itemsArray = CHtml::listData($row, 'subteam_group_id', 'subteam_group_name');        
            //            $bdOwnerList =;


            $this->VIEWPARA['model'] = $model;
            $this->VIEWPARA['viewmode'] = $viewmode;
            $this->VIEWPARA['bdOwnerList'] =  ArrayHelper::map($this->bdOwnerList(), 'code', 'name');


            return $this->render($this->VIEWPATH . 'update', $this->VIEWPARA);
        }
    }
    public function actionPrint($id = null)
    {
        $model = XPdr::findOne($id);
        if (substr($model->doc_no, 10, 1) <> 'R') {
            $modelCompare = $model;
        } else {
            $pre_no = substr($model->doc_no, 11) - 1;
            $pre_docno = substr($model->doc_no, 0, 10)
                . ($pre_no == 0 ? '' : 'R' . $pre_no);
            $modelCompare = XPdr::find()
                ->where('doc_no = :doc_no', [':doc_no' => ($pre_docno)])->one();
            if (!$modelCompare) {
                $modelCompare = $model;
            }
        }
        $params = [
            'IMAGE_PATH' => $this->IMAGE_PATH,
            'modelCompare' => $modelCompare,
        ];
        $form = new XPrintForm($model, [], $params);
        return $form->print();
    }


    public function actionNewdone($id = null)
    {
        $model = $this->findModel($id);
        $model->scenario = 'newdone';

        $model->bd_approve_request_date = XLib::dateTimeConv(Yii::$app->formatter->asDateTime('now'), 'b');
        $model->save();


        $_remark='';
        $_act = '';
        $_acttext = 'New';    
    
        $_owner = 'BD : ' . $model->bd_owner;
        $subject = $_acttext . ' ' . $this->VIEWPARA['TABLECAPTION']
            . ' : ' . $model->doc_no
            . ' ' . $_owner;
        XNotify::notify(
            $subject,
            $subject . ' ( action user : ' . Yii::$app->user->identity->username . ' ) ' . $_remark,
            $_act
        );
    

        //return $this->redirect(['index', 'page' => $page]);
        return $this->redirect(['index']);
    }
}
