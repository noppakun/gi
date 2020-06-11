<?php

namespace app\controllers;

use yii;
use yii\data\ArrayDataProvider;
use app\models\SelectForm;

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xls;

use app\components\XExport;

class PackagingWasteController extends \yii\web\Controller
{
	/*
		Yii::$app->controller->id == '
		- rawmaterial-waste
		- packaging-waste
	*/


	protected $viewpart = "/packaging-waste/";

	function genSql($cho)
	{
		// ($cho == 1){ //  Packaging Waste Report
		// ($cho == 2){ //  Packaging Waste Rawdata

		$sql10 = "
       
		declare @trdate as date
		declare @trdate2 as date
		declare @tryear as int
		declare @tryear2 as int
		declare @type_invent_code as char(2)

		-- Type_Invent_Code='01'  Finish Good 			-> Packaging
		-- Type_Invent_Code='03'  Semi Finished Goods 	-> Raw Materials		
		
		set @trdate2 = getdate()
		set @trdate  = cast(cast((year(DATEADD(year, -1, @trdate2)))*10000+101 as char) as date)
		set @type_invent_code = '03'
		
		set @tryear = :tryear
		set @tryear2 = :tryear2
		set @type_invent_code = :type_invent_code
		
		
		-- -------------------------------------------------
		-- --------------------------------------------------
		-- --------------------------------------------------
		-- --------------------------------------------------		
		";



		if ($cho == 1) { //  Packaging Waste Report
			$sql31 = "";
			$sql200 = '';
		} else if ($cho == 2) { //  Packaging Waste Rawdata
			$sql31 = "year(a.jobdate) as year,"; // for add column year
			$sql200 = '';
		} else if ($cho == 3) {  //  Packaging Waste Rawdata type 2 ( cho1 + add machname) k.book 7/2/2019		
			$sql31 = "";
			$sql200 = ',a.machname';
		}

		$sql20 = "		
		select a.group_product_desc,a.product_desc"

			. $sql200
			. "-- a.group_product, a.product
		,sum(a.qtyRlse)  as qtyRlse
		,sum(a.Issue_Qty)  as Issue_Qty
		,((sum(a.Issue_Qty)-sum(a.qtyRlse))/sum(a.qtyRlse)) as waste_percent
		
		from (
		";

		$sql30 = "
		
		
			--------------------------------------------------------------------
			-- AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
			-- create report ---------
			--------------------------------------------------------------------
			select  " . $sql31 . "
				a.order_no,a.jobno
				--,a.jobdate				
				, convert(varchar, a.jobdate, 105) as jobdate
				,a.item_number,_item.item_name
				, a.jobqty,a.Rlse_Qty
				,a.component
				,_comp.item_name as component_name		
				,isnull(c.group_product_desc,'(not set)') as group_product_desc		
				,isnull(d.product_desc,'(not set)') as product_desc 
				-- ,_comp.Group_Product, _comp.Product		
				,a.qtyBom	,a.Rlse_Qty*a.qtyBom as qtyRlse	
				,a.Issue_Qty 
				,a.machcode,a.machname
				-- xxxxxxxx
				,a.issue_I1
				,a.issue_IA
				,a.issue_R3
				,a.issue_RA
				-- xxxxxxxx				
			from (
				--------------------------------------------------------------------
				-- AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
				-- create data row ---------
				--------------------------------------------------------------------
				select  a.order_no,e.jobdate,a.jobno,a.item_number, a.jobqty,a.Rlse_Qty
					,c.component ,c.qty as qtyBom
					,d.Issue_Qty
					,f.machcode,f.machname
					-- xxxxxxxx
					,d.issue_I1
					,d.issue_IA
					,d.issue_R3
					,d.issue_RA
					-- xxxxxxxx				 
				from wplandet   a
				left join bom b on a.item_number = b.assembly
				left join bomdet c on  b.assembly = c.assembly 
				left join (
					/* query from product_job_cost (account)*/
					select a.Order_Number,a.Item_Number,a.component
					-- ,sum(a.Issue_Qty) as Issue_Qty
					-- xxxxxxxx
					,sum(isnull(issue_qty,0)-isnull(recv_Qty,0)) as Issue_Qty 					
					,sum(issue_I1) as issue_I1
					,sum(issue_IA) as issue_IA
					,sum(issue_R3) as issue_R3
					,sum(issue_RA) as issue_RA
					-- xxxxxxxx					
					from (
						Select A.VoucherNo,a.Order_Number,A.DocDate,A.DocType,a.RefDoc as Item_Number,B.Item_Number as component
						,B.Ana_No,B.Recv_Qty,B.Issue_Qty,B.UnitPrice,B.SumPrice
						-- xxxxxxxx
						,case when A.DocType='I1' then isnull(b.issue_qty,0)-isnull(b.recv_Qty,0) else 0 end as issue_I1
						,case when A.DocType='IA' then isnull(b.issue_qty,0)-isnull(b.recv_Qty,0) else 0 end as issue_IA
						,case when A.DocType='R3' then isnull(b.issue_qty,0)-isnull(b.recv_Qty,0) else 0 end as issue_R3
						,case when A.DocType='RA' then isnull(b.issue_qty,0)-isnull(b.recv_Qty,0) else 0 end as issue_RA
						-- xxxxxxxx						
						From StHead A 
						left join StCard B 
							on A.CompanyCode=B.CompanyCode 
							and A.DocType=B.DocType
							And A.VoucherNo=B.VoucherNo		
						--inner join wplan e on a.JobNo=e.JobNo and (e.jobdate between @trdate and @trdate2)
						inner join wplan e on a.JobNo=e.JobNo and (year(e.jobdate) between @tryear and @tryear2)
						Where (A.DocType in ('R3','RA','I1','IA'))
						
						
					) a 
					group by a.Order_Number,a.Item_Number,a.component
				)d on   a.Order_No=d.Order_Number and a.Item_Number = d.Item_Number and c.component=d.component		
				--inner join wplan e on a.JobNo=e.JobNo and (e.jobdate between @trdate and @trdate2)	
				inner join wplan e on a.JobNo=e.JobNo and (year(e.jobdate) between @tryear and @tryear2)
				left join machine f on a.machcode=f.machcode
				where d.Issue_Qty <> 0 -- ไม่นับรายการ ที่ไม่มีการเบิกเลย
				and a.JobStatus='C' 
				--------------------------------------------------------------------
				-- BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
				-- create data row ---------
				--------------------------------------------------------------------
			) a 
			left join item _comp on a.component = _comp.item_number
			left join item _item on a.item_number = _item.item_number
			left join gproduct c on _comp.type_invent_code=c.type_invent_code and _comp.Group_Product=c.Group_Product
			left join product d  on _comp.type_invent_code=d.type_invent_code and _comp.Group_Product=d.Group_Product and _comp.Product=d.Product 
			---------------------------------------------------------------------
			-- Type_Invent_Code='01'  Finish Good 			-> Packaging
			-- Type_Invent_Code='03'  Semi Finished Goods 	-> Raw Materials
			---------------------------------------------------------------------
			where _item.Type_Invent_Code = @type_invent_code
			--------------------------------------------------------------------
			-- BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
			-- create report ---------
			--------------------------------------------------------------------
		
		
		";


		$sql21 = "
		)a
		group by a.group_product_desc,a.product_desc"
			. $sql200
			. "-- ,a.group_product, a.product
		order by a.group_product_desc,a.product_desc		
		";

		if ($cho == 1) { //  Packaging Waste Report
			$sql = $sql10 . $sql20 . $sql30 . $sql21;
		} else if ($cho == 2) { //  Packaging Waste Rawdata
			$sql = $sql10 . $sql30;
		} else if ($cho == 3) {  //  Packaging Waste Rawdata type 2 ( cho1 + add machname) k.book 7/2/2019
			$sql = $sql10 . $sql20 . $sql30 . $sql21;
		}



		$myfile = fopen("1.sql", "w") or die("Unable to open file!");

		fwrite($myfile, $sql);
		fclose($myfile);



		return $sql;
	}
	//-------------------------------------------------------------------------------------------------------------------------
	public function actionIndex()
	//-------------------------------------------------------------------------------------------------------------------------
	{
		$SelectForm = new SelectForm();
		if (isset(Yii::$app->request->queryParams['SelectForm'])) {
			$SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year'];
			$SelectForm->year2      = Yii::$app->request->queryParams['SelectForm']['year2'];
		} else {
			$SelectForm->year   = date("Y") - 1;
			$SelectForm->year2  = date("Y");
		}

		$sql = $this->genSql(1);

		// $fp = fopen('1.TXT', 'w');
		// fwrite($fp, $sql);
		// fclose($fp);

		$type_invent_code = (Yii::$app->controller->id == 'rawmaterial-waste' ? '03' : '01');

		$connection = \Yii::$app->db;
		$command = $connection->createCommand($sql);
		$command->bindParam(":tryear", $SelectForm->year);
		$command->bindParam(":tryear2", $SelectForm->year2);
		$command->bindParam(":type_invent_code", $type_invent_code);


		$rows = $command->queryAll();
		$dataProvider = new ArrayDataProvider([
			'allModels' => $rows,
			'pagination' => [
				'pageSize' => 50,
			],
		]);




		return $this->render($this->viewpart . 'index', [
			'dataProvider' => $dataProvider,
			'rows' => $rows,
			'SelectForm'    =>  $SelectForm,
		]);
	}
	// ------------------------------------------------------------------------
	private function waste2xls($year, $year2, $cho)
	// ------------------------------------------------------------------------
	{
		$sql = $this->genSql($cho);
		$connection = \Yii::$app->db;
		$command = $connection->createCommand($sql);


		$type_invent_code = (Yii::$app->controller->id == 'rawmaterial-waste' ? '03' : '01');

		$connection = \Yii::$app->db;
		$command = $connection->createCommand($sql);
		$command->bindParam(":tryear", $year);
		$command->bindParam(":tryear2", $year2);
		$command->bindParam(":type_invent_code", $type_invent_code);


		$rows = $command->queryAll();


		$filename = (Yii::$app->controller->id == 'rawmaterial-waste' ? 'rawmaterialWaste' : 'packagingWaste-')
			. $year . ($year == $year2 ? '' : '-' . $year2)  . '.xls';

		$options = [];
		if ($cho == 3) {
			$options = [
				'columns' => [
					'Issue_Qty' => [
						'NumberFormat' => '#,##0.00'
					],
					'qtyRlse' => [
						'NumberFormat' => '#,##0.00'
					],
					'waste_percent' => [
						'NumberFormat' => '0.00%'
					],
				]
			];
		}

		XExport::x2xls($rows, $filename, $options);

		return $this->redirect($filename);
	}
	// ------------------------------------------------------------------------
	public function actionWaste2xls($year, $year2)
	// ------------------------------------------------------------------------
	{
		$this->waste2xls($year, $year2, 2);
	}
	// ------------------------------------------------------------------------
	public function actionWaste2xlstype2($year, $year2)
	// ------------------------------------------------------------------------
	{
		$this->waste2xls($year, $year2, 3);
	}
}
