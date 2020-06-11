<?php

namespace app\controllers;
use Yii;
use app\models\Item;
use app\models\Bom;
use app\models\BomSearch;
use app\models\BomTempSearch;
use app\models\SelectForm;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;


/**
 * BomController implements the CRUD actions for Bom model.
 */

class BomController extends \yii\web\Controller
{
    /**
     * @inheritdoc
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
     * Lists all Bom models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $SelectForm = new SelectForm();
        $SelectForm->labels['date']='Effective Date :';            
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {                            
            $SelectForm->date           = Yii::$app->request->queryParams['SelectForm']['date']; 
            $SelectForm->date2          = Yii::$app->request->queryParams['SelectForm']['date2']; 
            $SelectForm->checkbox   = Yii::$app->request->queryParams['SelectForm']['checkbox']; 
        }else{
            //$SelectForm->date           = Yii::$app->formatter->asDate(date('m').'/1/'. date('y'));   
            $SelectForm->date           = Yii::$app->formatter->asDate('1/1/'. date('y'));   
            $SelectForm->date2          = Yii::$app->formatter->asDate('now');
            $SelectForm->checkbox   = false; 
        }         
        $searchModel = (Yii::$app->controller->id == 'bom-temp') ? new BomTempSearch() : new BomSearch();            
 

        
        $param = Yii::$app->request->queryParams;

        // additional param options 
        $param['SelectForm'] = $SelectForm;   
        $param['defaultOrder'] =  [
            'EffectiveDate' => SORT_DESC,
            'Assembly' => SORT_ASC,
        ]; 
 
        $dataProvider = $searchModel->search($param);
         

        
        return $this->render('/bom/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'SelectForm'    =>  $SelectForm,
        ]);
    }
    // ------------------------------------------------------------------------------------------
    function setCellNum($p_sheet,$p_cell,$p_value,$p_format) 
    // ------------------------------------------------------------------------------------------
    {
        
        $p_sheet->setCellValue($p_cell,$p_value==0?'-':$p_value);            
        $p_sheet->getStyle($p_cell)->getNumberFormat()->setFormatCode($p_format);
        if($p_value==0){
            $p_sheet->getStyle($p_cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }
    }
    // ------------------------------------------------------------------------------------------
    public function actionTospreadsheet($id)    
    // ------------------------------------------------------------------------------------------
    {
        $type_invent_code  = (Item::findOne($id))->Type_Invent_Code;   
        $rows = $this->processRows($id,$type_invent_code);

 
        $startRow1=4;
        $_RowHeight=20;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();        
        

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(45);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(12);
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->getColumnDimension('L')->setWidth(12);
        $sheet->getRowDimension($startRow1-2)->setRowHeight($_RowHeight*2);                    
        
        $sheet->getStyle('A2:L2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:L2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->getRowDimension($startRow1-3)->setRowHeight($_RowHeight);                    
        $sheet->setCellValue('A'.($startRow1-3), 'Item No.');
        $sheet->setCellValue('B'.($startRow1-3), $id);        
        $sheet->setCellValue('A'.($startRow1-2), 'No.');            
        $sheet->setCellValue('B'.($startRow1-2), 'Code');
        $sheet->setCellValue('C'.($startRow1-2), 'Raw Material');
        $sheet->setCellValue('D'.($startRow1-2), 'ราคา (R/M)');
        $sheet->setCellValue('E'.($startRow1-2), 'w/w');
        $sheet->setCellValue('F'.($startRow1-2), 'Cost');
        $sheet->setCellValue('G'.($startRow1-2), 'วันที่สั่งซื้อล่าสุด');
        $sheet->setCellValue('H'.($startRow1-2), "จำนวนสั่งซื้อ\nล่าสุด");
            $sheet->getStyle('H'.($startRow1-2))->getAlignment()->setWrapText(true);
        $sheet->setCellValue('I'.($startRow1-2), 'Lead Time (วัน)');
        $sheet->setCellValue('J'.($startRow1-2), 'จำนวนคงเหลือ');
        $sheet->setCellValue('K'.($startRow1-2), 'Quarantine');
        $sheet->setCellValue('L'.($startRow1-2), 'Reserved');
        
        foreach($rows as $key => $row){
 
            $_row = $key+$startRow1;
            $sheet->getRowDimension($_row)->setRowHeight($_RowHeight);            
            
            $sheet->setCellValue('A'.$_row, $key+1);
            $sheet->setCellValue('B'.$_row, $row['component']);           
            $sheet->setCellValue('C'.$_row, $row['item_name']);
            $this->setCellNum($sheet,'D'.$_row,$row['lastprice'],'#,##0.00') ;            
            $this->setCellNum($sheet,'E'.$_row,$row['qty'],'#,##0.000') ;
            $sheet->setCellValue('F'.$_row, '=D'.$_row.'*E'.$_row); // cost            
 
 
            if ($row['order_date'] == null){
                $sheet->setCellValue('G'.$_row, '-');            
            }else{
                $order_date = date('Y-m-d', strtotime(str_replace('/', '-', $row['order_date'])));
                $excelDateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( $order_date );            
                $sheet->setCellValue('G'.$_row, $excelDateValue);            
            }
            $this->setCellNum($sheet,'H'.$_row,$row['order_qty'],'#,##0.00') ;         
            $this->setCellNum($sheet,'I'.$_row,$row['leadtime'],'#,##0') ;
            $this->setCellNum($sheet,'J'.$_row,$row['qtyonhand'],'#,##0.00') ;
            $this->setCellNum($sheet,'K'.$_row,$row['qtyquarantine'],'#,##0.00') ;
            $this->setCellNum($sheet,'L'.$_row,$row['qtyreserved'],'#,##0.00') ;

            $sheet->getStyle('A'.$_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F'.$_row)->getNumberFormat()->setFormatCode('#,##0.000');
            $sheet->getStyle('G'.$_row)->getNumberFormat()->setFormatCode('DD-MM-YYYY');
            $sheet->getStyle('G'.$_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I'.$_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        };
        $_row_sum = $startRow1+count($rows);
        $sheet->getRowDimension($_row_sum)->setRowHeight($_RowHeight);            
        $sheet->getRowDimension($_row_sum+1)->setRowHeight($_RowHeight);                    
        
        $sheet->setCellValue('C'.$_row_sum,'Total (100 kg)' );

        $sheet->setCellValue('E'.$_row_sum, '=SUM(E'.$startRow1.':E'.($_row_sum-1).')');
            $sheet->getStyle('E'.$_row_sum)->getNumberFormat()->setFormatCode('#,##0.000');
               
        $sheet->setCellValue('F'.$_row_sum, '=SUM(F'.$startRow1.':F'.($_row_sum-1).')');
            $sheet->getStyle('F'.$_row_sum)->getNumberFormat()->setFormatCode('#,##0.000');

        $sheet->setCellValue('C'.($_row_sum+1), 1);
        $sheet->setCellValue('D'.($_row_sum+1), 'g.');
            $sheet->getStyle('C'.($_row_sum+1))->getNumberFormat()->setFormatCode('#,##0');

        $sheet->setCellValue('F'.($_row_sum+1), '=F'.$_row_sum.'/1000/100');        
        $sheet->getStyle('F'.($_row_sum+1))->getNumberFormat()->setFormatCode('#,##0.000');
        
        
        $testSizes = [
             6
            ,8
            ,40
            ,80
            ,100
            ,120
            ,160
            ,240
            ,250
            ,500
        ];
        foreach($testSizes as $key => $testSize){
            $_row = $_row_sum+1+$key+1;
            $f1= 'F'.($_row_sum+1).'*C'.$_row;
            $sheet->getRowDimension($_row)->setRowHeight($_RowHeight);            
            $sheet->setCellValue('C'.$_row, $testSize);
            $sheet->setCellValue('D'.$_row, 'g.');
            $sheet->setCellValue('E'.$_row, .03);
                $sheet->getStyle('E'.$_row)->getNumberFormat()->setFormatCode('0%');            
            $sheet->setCellValue('F'.$_row,'='.$f1.'+('.$f1.'*E'.$_row.')' );        
                $sheet->getStyle('F'.$_row)->getNumberFormat()->setFormatCode('#,##0.000');            
        }        
 
        $writer = new Xls($spreadsheet);
        
        //-------------------------------
        
        // header("Content-Type: application/vnd.ms-excel; charset=utf-8"); # Important 
        // header('Content-Disposition: attachment;filename="myfile.xls"');
        // header('Cache-Control: max-age=0');

        // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');        
        // $writer->save('php://output');

        //------------------------------------------------------------------------

       
        /* $filename = 'bom_' .rtrim($id) . '.xls';*/
        $filename = 'bom.xls';        
        $writer->save($filename); 
        return $this->redirect($filename);
    }
    //--------------------------------------------------------------------------
    function processRows($id,$type_invent_code ) {
    //--------------------------------------------------------------------------
        /*
        BomTemp
        BomDetTemp
        */ 
        //$type_invent_code  = (Item::findOne($id))->Type_Invent_Code;
        // //$item = (Item::findOne($id))->Type_Invent_Code;
        // echo '<br><br><br><br>';
        // //echo $item->Type_Invent_Code ;
        // echo $type_invent_code ;
        //$detTable = (Yii::$app->controller->id == 'bom-temp'  ? "BomDetTemp" : ($type_invent_code=='01'?"BomDet":"BomDetBatch"));            
        //$addWhere = (Yii::$app->controller->id == 'bom-temp'?"":" and a.StandardBatchSize=100");    

        $addWhere = "";
        if (Yii::$app->controller->id == 'bom-temp'){
            $detTable = "BomDetTemp";            
        }else{            
            if ($type_invent_code=='01'){                
                $detTable = "BomDet";                                                
            }else{
                $detTable = "BomDetBatch";                
                $addWhere = " and a.StandardBatchSize=100";
            }
        }

		$sql = "
            select rtrim(a.component) as component
                ,b.item_name
				,isnull(e.ext_price,isnull(f.po_price,d.itemloc_price)) as lastprice
                -- ,c.unitprice as lastprice
				-- ,case
                ,a.qty                 
				,isnull(e.ext_price,isnull(f.po_price,d.itemloc_price)) * a.qty  as cost                 

                ,f.po_price	,d.itemloc_price,e.ext_price  
                ,f.order_date,f.order_qty
                ,b.leadtime
                ,g.qtyonhand
                ,g.qtyquarantine
                ,h.qtyreserved
            from "
            .$detTable
            //---.(Yii::$app->controller->id == 'bom-temp'  ? "BomDetTemp" : "BomDet")            
            ." a                                    
            left join Item b on b.item_number = a.component
			left join (
				----- price from itemloc (last lot) -----
				select b.item_number 
				-- ,b.item_name
				,max(c.unitprice) as itemloc_price
				from item b 
				left join (
				    select distinct  a.item_number,a.unitprice,a.mfg_date 
				    from itemloc a
				) c on c.item_number = b.item_number
				where  c.mfg_date in (
					select max(cc.mfg_date)
					from   itemloc cc 
					where cc.item_number = c.item_number
                )  
                group by  b.item_number
			)d on d.item_number = a.component
			left join (
				select 'R0081' as item_number, cast(1 as float) as ext_price --  R0081 = DI WATER
            )e on e.item_number = a.component 
            left join (
                -- จำนวนที่ซื้อล่าสุด // ราคาล่าสุด
                select   b.item_number,a.order_date ,sum(b.order_qty) as order_qty,avg(b.price*a.currency_rate) as po_price,
                    row_number() OVER (PARTITION BY b.item_number order by b.item_number ,a.order_date desc,a.order_number desc ) seq
                    from po a    
                    left join  podetail b  on  a.order_number = b.order_number
                where isnull(b.item_number,'') <> ''             
                group by b.item_number,a.order_date ,a.order_number
            ) f on f.item_number = a.component  and  f.seq = 1
            left join (
                -- จำนวนคงเหลือ 
                select 
                    item_number,sum(ana_qty) as qtyonhand 
                    ,sum(Quarantine) as qtyquarantine
                from itemloc 
                where ana_qty > 0
                group by item_number
            ) g on g.item_number = a.component  
            left join (
                select  
                    component, SUM(Req_Qty) -SUM(Pick_Qty) as qtyreserved 
                from Job_Pick
                where Req_Qty<>Pick_Qty            
                group by Component                
            )h on h.component = a.component
            where a.assembly=:item_number"
            .$addWhere
            ." order by  a.sequence";

        //echo '<br><br><br>';
            //echo $sql;
        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);
        $command->bindParam(":item_number",$id);


        $rows = $command->queryAll();
        return $rows;
    }
    //--------------------------------------------------------------------------
    public function actionView($id)
    //--------------------------------------------------------------------------
    {


        $type_invent_code = (Item::findOne($id))->Type_Invent_Code;
        $rows = $this->processRows($id,$type_invent_code);

        $dataProvider=new ArrayDataProvider( [
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => 40,
            ],            
            
        ]);

        return $this->render('/bom/view', [
            'item_number' => $id,
            'dataProvider' => $dataProvider,
            'type_invent_code'=>$type_invent_code,
        ]);
    }    



    /**
     * Creates a new Bom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bom();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Assembly]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Bom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Assembly]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Bom model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Bom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bom::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
