<?php

namespace app\modules\dbma\controllers;

use Yii;

 
use app\models\PODetailSearch;

 
use yii\web\NotFoundHttpException;
 
use yii\data\ArrayDataProvider;
use app\models\SelectForm;

/**
 * PurchaseOrderController implements the CRUD actions for PurchaseOrder model.
 */


class PurchaseOrderController extends \app\components\XETableController
{
    //protected $RECTYPE      = xaraptran::RECTYPE_STOCKIN;


    protected $MAIN_MODEL     =   'app\models\PurchaseOrder';
    protected $MAIN_MODELD     =   'app\models\PODetail';
    protected $SEARCH_MODEL  =   'app\models\PurchaseOrderSearch';
    protected $VIEWPATH      =   '@app/views/purchase-order/';
    protected $VIEWPARA      =   [
        //'RECTYPE' =>  xaraptran::RECTYPE_STOCKIN,
        //'RECTYPE' =>  RECTYPE,
        'TABLECAPTION' =>  'ใบสั่งซื้อ'
    ];
    // ---------------------------------------------------------------------------------                           
    public function actionCreate()
    {
        $CompanyCode = 'GPM';
        return $this->actionUpdate($CompanyCode, null, null);
    }

    // -------------------------------------------------------------------------------------------------------------------------
    public function actionUpdate($id = null, $id2 = null, $id3 = null, $viewmode = false)
    // -------------------------------------------------------------------------------------------------------------------------
    {
        // id = Order_Number
        //echo '<br><br><br><br><br><br><br>000000000000';

        if ($id == null) { // create
            //echo '<br><br><br><br>11111111111';
            $model = new $this->MAIN_MODEL();
            $model->CompanyCode = 'GPM';
            /*----------------   init field here -----------------------
  
  
            $model->rectype = $this->RECTYPE;  
                        $model->warehouse_id  =  \app\models\Refdata::$default_warehouse; 
                        $model->vat_rate  		=  \app\models\Refdata::$default_vat_rate; 
                        $model->doc_no				=	  docrunno::nextdocno(xaraptran::$docprefix[$this->RECTYPE],0);
            $model->doc_date  		= Yii::$app->formatter->asDate('now'); 
                        $model->inv_date  		= Yii::$app->formatter->asDate('now'); 
                        $model->credit_terms	= 0;
            */
        } else {    // update             

            $model = $this->findModel($id, $id2, $id3);
            /* ------------------- convert database field->datetime   to display field
            $model->doc_date=Yii::$app->formatter->format(strtotime($model->doc_date), 'date'); 
                        $model->inv_date=Yii::$app->formatter->format(strtotime($model->inv_date), 'date'); 
            */
        }
        //echo '<br><br><br><br>11111111111';
        if ($model->load(Yii::$app->request->post())) {   // save
            //echo '<br><br><br><br>222222222222222';
            /*-------------  convert display field to database field here
            $model->doc_no	=	  docrunno::nextdocno(xaraptran::$docprefix[$this->RECTYPE],1);
            $model->doc_date = date('Y-m-d', strtotime(str_replace('/', '-', $model->doc_date)));           
            $model->inv_date = date('Y-m-d', strtotime(str_replace('/', '-', $model->inv_date)));           
            */
            $model->save();
            //	after update redirect to inxex    / after create redirect to update
            return ($id <> null) ? $this->redirect(['index']) : $this->redirect(['update', 'CompanyCode' => $model->CompanyCode, 'id' => $model->Order_Number]);
        } else { // display update view
            $modeld = new ArrayDataProvider([
                'allModels' => $model->detail,
            ]);
            if ($id2 == null) { // create
                $modeld1 = new $this->MAIN_MODELD();
                $modeld1->CompanyCode = $id;
                $modeld1->Order_Number = $id2;
            } else {
                $modeld1 = $this->findModel($id, $id2, $id3);
            }
            $this->VIEWPARA['model']  = $model;
            $this->VIEWPARA['modeld'] = $modeld;
            $this->VIEWPARA['modeld1'] = $modeld1;
            return $this->render($this->VIEWPATH . 'update', $this->VIEWPARA);
        }
    }
    // ---------------------------------------------------------------------------------
    public function findModel($id = null, $id2 = null, $id3 = null)
    // ---------------------------------------------------------------------------------
    {

        //-----------------------------------------------------------------------------------

        if ($id2 != null) {    // ******* find detail
            $fOne = new \ReflectionMethod($this->MAIN_MODELD, 'findOne');
        } else {              // ******* find header
            $fOne = new \ReflectionMethod($this->MAIN_MODEL, 'findOne');
        }

        if (($model = $fOne->invoke(NULL, ($id2 != null) ? $id2 : $id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested id does not exist.');
        }
    }





    // --------------------------------------------------------------------
    // --------------------------------------------------------------------
    // --------------------------------------------------------------------
    // --------------------------------------------------------------------
    // --------------------------------------------------------------------


    // for ext report
    // --------------------------------------------------------------------
    public function actionTop()
    // --------------------------------------------------------------------    
    {
        $sql = "
            declare @tr_year int
            declare @Item_Number varchar(20)
            
            set @Item_Number = null
            -- set @Item_Number = 'R0097'
            set @Item_Number = :Item_Number
            set @tr_year =  year(getdate())-2 -- 2+1
            
            --
            select top 10 *,0 as status from (
                select 
                    --b.*
                    case when  @Item_Number is  null then 0 else  year(a.Order_date) end as yyear
                    ,rtrim(b.Item_Number) as Item_Number,b.PurDet_Desc as description
                    ,min(b.price/isnull(d.factor,1)) as min_price
                    ,max(b.price/isnull(d.factor,1)) as max_price                    
                    ,sum(b.Rlse_Qty*isnull(d.factor,1)) as qty                    
                    ,sum(b.Rlse_Qty*b.Price) as amount                    
                    ,isnull(d.uom_to,c.uom) as uom 
                from po a 
                left join podetail b on a.CompanyCode=b.CompanyCode and a.Order_Number=b.Order_Number
                left join item c on b.Item_Number=c.Item_Number
                    
                left join  Uom d on c.uom=d.uom_from and  d.uom_from in ('g','ml','GRAM') 
                
                where (year(a.Order_date)>=@tr_year)
                and (b.Rlse_Qty>0)                
                and (c.Type_Invent_Code='04') -- 02:rawmat  05:packaging                
                and  ((@Item_Number = b.Item_Number) or (@Item_Number is  null))
                
                group by case when @Item_Number is  null then 0 else  year(a.Order_date) end 
                    ,rtrim(b.Item_Number),b.PurDet_Desc,c.uom ,d.uom_to                
            )a           
        ";
        $connection = \Yii::$app->erpdb;
        $_Item_Number=null;
        $rows   = $connection->createCommand($sql . ' order by qty desc')->bindParam(":Item_Number", $_Item_Number)->queryAll();
        $rows2  = $connection->createCommand($sql . ' order by amount desc')->bindParam(":Item_Number", $_Item_Number)->queryAll();


        // $command = $connection->createCommand($sql . ' order by yyear');
        // $command->bindParam(":Item_Number", null);
        // $rows = $command->queryAll();




        // \app\components\XLib::xprint_r($rows2);
        foreach ($rows as $key => $value) {
            //echo $value['Item_Number']. ' ';


            //$rows[$key]['description'] = $key2.'   '.gettype($key2); 
            //if(($key2!= NULL)){
            $key2 = array_search($value['Item_Number'], array_column($rows2, 'Item_Number'));
            if ($key2 !== false) {
                //\app\components\XLib::xprint_r( $value['Item_Number']);
                $rows[$key]['status'] = 1;
                $rows2[$key2]['status'] = 1;
            }
        }

        $dataProvider   = new ArrayDataProvider(['allModels' => $rows]);
        $dataProvider2  = new ArrayDataProvider(['allModels' => $rows2]);


        return $this->render('top', [
            'dataProvider'  =>  $dataProvider,
            'dataProvider2'  =>  $dataProvider2,
            'sql' => $sql,
        ]);
    }

    // --------------------------------------------------------------------
    public function actionShipdateitem() // newwwwwwwwwww
    // --------------------------------------------------------------------    
    {
        $searchModel = new PODetailSearch();
        $SelectForm = new SelectForm();
        $SelectForm->labels['date'] = 'วันที่ ของเข้า:';
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->date       = Yii::$app->request->queryParams['SelectForm']['date'];
            $SelectForm->date2      = Yii::$app->request->queryParams['SelectForm']['date2'];
        } else {
            $SelectForm->date  = Yii::$app->formatter->asDate(date('m') . '/1/' . date('y'));
            $SelectForm->date2  = Yii::$app->formatter->asDate('now');
        }

        //$this->layout = 'layout-fluid';
        //$this->params['fluid'] = true;
        $dataProvider = $searchModel->shipdatesearch(Yii::$app->request->queryParams, $SelectForm);
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParam,1);                
        return $this->render('shipdateitem', [
            'searchModel' => $searchModel,
            'SelectForm'    =>  $SelectForm,
            'dataProvider' => $dataProvider,
        ]);
    }

    //  ----------------------------------------------------------------------------
    // -------------------------------------------------------------------------------------------------------------------------
    public function actionPrint($id)
    // -------------------------------------------------------------------------------------------------------------------------
    {

        $datah = $this->findModel($id);


        $pdf = new Pdf();
        $mpdf = $pdf->api; // fetches mpdf api        
        //<link rel="stylesheet" href="../views/salesorder/invoice/style.css" media="all" />      
        $stylesheet = file_get_contents('../views/purchaseorder/printform/style.css');

        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->setTopMargin(51);

        $mpdf->SetHeader(
            $this->renderPartial('printform/header', [
                'datah' => $datah,
                //'datad'=>$datad          
            ])
        );


        $mpdf->SetFooter(
            $this->renderPartial('printform/footer')
        );


        $mpdf->WriteHtml(
            $this->renderPartial('printform/detail', [
                'datah' => $datah,
                //'datad'=>$datad

            ])
        ); // call mpdf write html        



        $mpdf->Output('filename', 'I'); // call the mpdf api output as needed




    }
}
