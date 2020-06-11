<?php

namespace app\controllers;

use Yii;

use app\models\WPlanDet;
use app\models\WPlanDetSearch;
use app\models\XWplandetWaste;
use app\models\XWplandetExt;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\SelectForm;
use yii\web\Response;
use yii\data\Pagination;

class BatchPackingRecordController extends \yii\web\Controller
{
    // -----------------------------------------------------------------------------------------------------
    // ********************* AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA ********************************************
    // -----------------------------------------------------------------------------------------------------
    // -----------------------------------------------------------------------------------------------------
    public function actionPostdata()
    // -----------------------------------------------------------------------------------------------------    
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        //XLib::xprint_r($post);
        return $post;
    }

    // -----------------------------------------------------------------------------------------------------
    public function actionGetdata($order_no = '428071', $item_number = '8850279428454')
    // -----------------------------------------------------------------------------------------------------
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $WPlanDet = WPlanDet::findOne(['Order_No' => $order_no, 'Item_Number' => $item_number]);
        $Compound = WPlanDet::findOne(['Order_No' => $order_no, 'Item_Type' => 'B']);

        $rows = $WPlanDet->packaging_materials_usage(['Component' => $Compound->Item_Number]);
        array_unshift(
            $rows,
            [
                'Component' => $Compound->item->Item_Number,
                'Item_Name' => $Compound->item->Item_Name,
                'Uom' => $Compound->item->Uom,
                'waste' => 0

            ]
        );


        // --------------------------------------
        // summary from XWplandetWaste
        // --------------------------------------
        foreach ($rows as $key => $row) {
            $rows[$key]['waste'] = $WPlanDet->XWplandetWasteSumQty($row['Component']);
        };
        if (($xWplandetExt = $WPlanDet->xWplandetExt) == null) {
            $xWplandetExt = new XWplandetExt;
        };

        return [
            'item_name' =>  $WPlanDet->item->Item_Name,
            'netfill'   =>  $xWplandetExt->netfill,
            'detail' => $rows
        ];
    }

    // -----------------------------------------------------------------------------------------------------
    public function actionVwaste($order_no, $item_number, $id = null)
    {
        // -----------------------------------------------------------------------------------------------------
        // 467140/8850279467217           
        $post = Yii::$app->request->post();

        // \app\components\XLib::xprint_r($post); 
        // if (isset($post['XWplandetWaste'])){
        //     echo '<br> = 1';
        // }else if (isset($post['XWplandetExt'])){
        //     echo '<br> = 2';
        // }


        $modelExt =  XWplandetExt::findOne(['order_no' => $order_no, 'item_number' => $item_number]);
        if (!$modelExt) { // create
            $modelExt = new XWplandetExt;
            $modelExt->order_no = $order_no;
            $modelExt->item_number = $item_number;
        }
        //if (isset($post['XWplandetExt'])){
        if ($modelExt->load($post)) {
            if ($modelExt->save()) {
                // $modelExt = new XWplandetWaste;
            };
        }

        // }else if (isset($post['XWplandetWaste'])){
        //    // echo '<br> = 1';
        // }



        if ($id !== null) { // update
            $model = XWplandetWaste::findOne($id);
        } else {  // create
            $model = new XWplandetWaste;
        }
        if ($model->load($post)) {
            $model->tran_date = \app\components\XLib::dateConv($model->tran_date, 'b');
            if ($model->save()) {
                $model = new XWplandetWaste;
            };
        }
        if ($model->IsNewRecord) {
            $model->tran_date = Yii::$app->formatter->asDate('now');
            $model->order_no = $order_no;
            $model->item_number = $item_number;
        }



        // ----------------------------------------------------
        $WPlanDet = WPlanDet::findOne(['Order_No' => $order_no, 'Item_Number' => $item_number]);
        //$Compound = WPlanDet::findOne(['Order_No'=>$order_no,'Item_Type'=>'B']); 

        return $this->render('vwaste', [
            'order_no' => $order_no,
            'item_number' => $item_number,




            'model' => $model,
            'modelExt' => $modelExt,

        ]);
    }
    // -----------------------------------------------------------------------------------------------------
    // ********************* BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB ********************************************
    // -----------------------------------------------------------------------------------------------------

    // -----------------------------------------------------------------------------------------------------
    public function actionJlist($year = 2018, $page = 1)
    {
        // -----------------------------------------------------------------------------------------------------    
        //\app\components\XLib::xprint_r($pagesParam);        

        Yii::$app->response->format = Response::FORMAT_JSON;
        $query = WPlanDet::find()
            //->select('WPlanDet.*,item.Item_Name') 
            //->select('WPlanDet.*,item.Item_Name') 
            ->andFilterWhere([
                'WPlanDet.Item_Type' => 'F',
                'year(StartDateTime)' => $year,
            ])
            ->joinWith('item')
            ->orderBy(['StartDateTime' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $pages->params['page'] = $page;



        //$pages->setPage(2);



        $rows = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();



        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'Order_No' => $row['Order_No'],
                'Item_Number' => $row['Item_Number'],
                'JobQty' => $row['JobQty'],
                'Item_Name' => $row['item']['Item_Name'],
                'StartDateTime' => $row['StartDateTime'],
                'Remark2' => $row['Remark2'],


            ];
        }

        return [
            'pages' => $pages,
            'rows' => $data
        ];
    }

    // -----------------------------------------------------------------------------------------------------
    public function actionIndex()
    {
        // -----------------------------------------------------------------------------------------------------

        $SelectForm = new SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year'];
            $SelectForm->year2       = Yii::$app->request->queryParams['SelectForm']['year2'];
        } else {
            $SelectForm->year   = date("Y") - 1;
            $SelectForm->year2   = date("Y");
        }

        $searchModel = new WPlanDetSearch();

        $param = Yii::$app->request->queryParams;

        // additional param options
        $param['BatchPackingRecord'] = !null;
        $param['SelectForm'] = $SelectForm;

        $dataProvider = $searchModel->search($param);
        //\app\components\XLib::xprint_r($dataProvider);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'SelectForm'    =>  $SelectForm,

        ]);
    }


    // -----------------------------------------------------------------------------------------------------
    public function actionWaste_delete($order_no, $item_number, $component, $id = null)
    {
        // -----------------------------------------------------------------------------------------------------
        XWplandetWaste::findOne($id)->delete();
        return $this->actionWaste($order_no, $item_number, $component, null);
    }
    // -----------------------------------------------------------------------------------------------------
    public function actionWaste_update($order_no, $item_number, $component, $id = null)
    {
        // -----------------------------------------------------------------------------------------------------
        return $this->actionWaste($order_no, $item_number, $component, $id);
    }
    // -----------------------------------------------------------------------------------------------------
    public function actionWaste($order_no, $item_number, $component, $id = null)
    {
        // -----------------------------------------------------------------------------------------------------
        $post = Yii::$app->request->post();

        // \app\components\XLib::xprint_r($post); 
        // if (isset($post['XWplandetWaste'])){
        //     echo '<br> = 1';
        // }else if (isset($post['XWplandetExt'])){
        //     echo '<br> = 2';
        // }


        $modelExt =  XWplandetExt::findOne(['order_no' => $order_no, 'item_number' => $item_number]);
        if (!$modelExt) { // create
            $modelExt = new XWplandetExt;
            $modelExt->order_no = $order_no;
            $modelExt->item_number = $item_number;
        }
        //if (isset($post['XWplandetExt'])){
        if ($modelExt->load($post)) {
            if ($modelExt->save()) {
                // $modelExt = new XWplandetWaste;
            };
        }

        // }else if (isset($post['XWplandetWaste'])){
        //    // echo '<br> = 1';
        // }



        if ($id !== null) { // update
            $model = XWplandetWaste::findOne($id);
        } else {  // create
            $model = new XWplandetWaste;
        }
        if ($model->load($post)) {
            $model->tran_date = \app\components\XLib::dateConv($model->tran_date, 'b');
            if ($model->save()) {
                $model = new XWplandetWaste;
            };
        }
        if ($model->IsNewRecord) {
            $model->tran_date = Yii::$app->formatter->asDate('now');
            $model->order_no = $order_no;
            $model->item_number = $item_number;
            $model->component = $component;
            $model->wca_code = '01'; // production
        }



        // ----------------------------------------------------
        $WPlanDet = WPlanDet::findOne(['Order_No' => $order_no, 'Item_Number' => $item_number]);
        $Compound = WPlanDet::findOne(['Order_No' => $order_no, 'Item_Type' => 'B']);


        $row = $WPlanDet->packaging_materials_usage(['Component' => $component]);
        array_unshift(
            $row,
            [
                'Component' => $Compound->item->Item_Number,
                'Item_Name' => $Compound->item->Item_Name,
                'Uom' => $Compound->item->Uom,
                // 'requested' => 0,
                // 'added' => 0,
                // 'returned' => 0,
                // 'used' => 0,
                //'waste' => $WPlanDet->XWplandetWasteSumQty($Compound->item->Item_Number),
                'waste' => 0

            ]
        );

        $packaging_materials_usage = new ArrayDataProvider([
            'allModels' => $row,
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);
        return $this->render('waste', [

            'WPlanDet' => $WPlanDet,
            'pmu' => $packaging_materials_usage,
            'model' => $model,
            'modelExt' => $modelExt,
            //  'Compound'=>$Compound,      
        ]);
    }
    
    // -----------------------------------------------------------------------------------------------------
    public function actionRefreshbombatch($order_no, $item_number)
    {
    // -----------------------------------------------------------------------------------------------------
        $WPlanDet = WPlanDet::findOne(['Order_No' => $order_no, 'Item_Number' => $item_number]);           
        $this->create_x_wplan_bomdetbatch($WPlanDet->JobNo,$WPlanDet->JobNo);

        
        //return Yii::$app->response->redirect(['batch-packing-record/view','order_no' => $order_no, 'item_number' => $item_number]);
        return $this->actionView($order_no, $item_number);

    }    
    // -----------------------------------------------------------------------------------------------------    
    private function create_x_wplan_bomdetbatch($JobNo,$JobNoDelete=null)
    // -----------------------------------------------------------------------------------------------------    
    {
        $connection = \Yii::$app->db;
        // clear x_wplan_bomdetbatch if wplandet BatchSize  is CHANGE
        $sql = "
            -- select a.JobNo,a.Assembly,a.StandardBatchSize from   x_wplan_bomdetbatch a
            delete x_wplan_bomdetbatch from   x_wplan_bomdetbatch a
            left join wplandet b on a.JobNo=b.JobNo and a.Assembly=b.Item_Number and a.StandardBatchSize=b.JobQty
            where b.JobNo is null  
                or a.JobNo =  :JobNoDelete
        ";
        $command = $connection->createCommand($sql);        
        $command->bindParam(":JobNoDelete", $JobNoDelete);
        $command->execute();

        // add x_wplan_bomdetbatch if not exist
 
        $sql = "
            declare @JobNo varchar(20)
            set @JobNo = '18326'
            set @JobNo = :JobNo
            insert into x_wplan_bomdetbatch (JobNo, Assembly, StandardBatchSize, Sequence, Component, Qty)
                select b.JobNo
                    ,c.Assembly, c.StandardBatchSize, c.Sequence, c.Component, c.Qty
                from wplan a
                left join wplandet b on a.JobNo=b.JobNo
                left join BomDetBatch c on b.item_number=c.Assembly	and b.jobqty=c.StandardBatchSize
                left join x_wplan_bomdetbatch d 
                    on b.JobNo=d.JobNo 
                        and c.Component = d.Component
                        and b.jobqty = d.StandardBatchSize
                where b.jobno=@JobNo
                and c.Assembly is not null
                and d.id is null
                -- and @JobNo not in (select distinct JobNo from x_wplan_bomdetbatch)                        
                -- and rtrim(@JobNo)+c.Component not in (select distinct rtrim(JobNo)+component from x_wplan_bomdetbatch)
        ";
        
        $command = $connection->createCommand($sql);
        $command->bindParam(":JobNo", $JobNo);
        $command->execute();
    }
    // -----------------------------------------------------------------------------------------------------
    public function actionView($order_no, $item_number)
    // -----------------------------------------------------------------------------------------------------
    {



        $PackIngCount = WPlanDet::find()->where(['Order_No' => $order_no, 'Item_Type' => 'F'])->count();

        $WPlanDet = WPlanDet::findOne(['Order_No' => $order_no, 'Item_Number' => $item_number]);
        $this->create_x_wplan_bomdetbatch($WPlanDet->JobNo);

        $packaging_materials_usage = new ArrayDataProvider([
            'allModels' => $WPlanDet->packaging_materials_usage(),
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);
        //$rows = $WPlanDet->compoundIssue;
        //\app\components\XLib::xprint_r($rows); 


        // v.1
        //)*($WPlanDetCompound->bom->Density > 0?$WPlanDetCompound->bom->Density : 1);          
        // ไม่ต้องคำนวน Density nui 13/2/2019
        // 11/2/2019  nui   กรณี 1 job มี 2 finish good  
        /*
         v.2
        'value' => function() use ($param){                              
          if (isset($param['BulkByJobQty'])){
            $ret = number_format($param['BulkByJobQty'],($param['Density'] > 0?2:0))
              .' '. $param['Uom'];              
          }else{
            $ret = 'N/A';
          }
          return $ret;
        }, 

        v.1  กลับมาใช้ v1 11/2/2019  nui   กรณี 1 job มี 2 finish good            
        */

        /*
        v.3 5/4/2019
        เปลี่ยนมาใช้ weight ตาม ปริมาณที่ใช้ กรณี มี มากกว่า 1 packsize
        
        */
        $sql = "        
            select                 
                sum(a.jobqty * b.Pack*b.PackSize) as allqty
            from WPlanDet a
                left join item b on a.Item_Number=b.Item_Number
                where a.order_no=:order_no
                and a.Item_Type = 'F'
        ";

        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);
        $command->bindParam(":order_no", $order_no);
        $rows = $command->queryAll();
        $qty_all_order_no = $rows[0]['allqty'];

        // ***** job repack with out component *****
        $WPlanDetCompound = WPlanDet::findOne(['Order_No' => $order_no, 'Item_Type' => 'B']);
        if ($WPlanDetCompound == null) {
            $Bulk_Batch_Size = null;
        } else {


            $Bulk_Batch_Size = ($PackIngCount == 1)
                ? $WPlanDetCompound->JobQty

                // v.3  เฉลี่ย 
                : $WPlanDetCompound->JobQty / $qty_all_order_no
                * ($WPlanDet->JobQty * $WPlanDet->bom->item->Pack * $WPlanDet->bom->item->PackSize);
            // more than 1 packsize
            // v.2
            // $WPlanDet->JobQty
            // *$WPlanDet->bom->item->Pack
            // *$WPlanDet->bom->item->PackSize/1000  


        }

        return $this->render('view', [
            'WPlanDet' => $WPlanDet,
            'WPlanDetCompound' => $WPlanDetCompound,
            'pmu' => $packaging_materials_usage,
            'Bulk_Batch_Size' => $Bulk_Batch_Size,
        ]);
    }
}
