<?php

namespace app\components;

use Yii;
use yii\base\Component;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class XExport extends Component
{

	/*
		22/10/2018
			- add option noExportColumns
			  exp xpdr/actionTospreadsheet        
				$options = [
            		'noExportColumns' => [20, 21, 22],
					//other_detail_picture, other_detail_sample, other_detail_other,
				]
		17/10/2018
			- default Font Arial size 12 				
			- column auto size
		7/2/2019
			- add  column format in options parameter
				exp.  packagingwaste/waste2xls
					$options = [
						'columns'=>[        
                			'Sale_Date'=>[
                    			'DateFormat'=>'dd/mm/yyyy'
                			],				
							'Issue_Qty'=>[
								'NumberFormat'=>'#,##0.00'
							],
							'qtyRlse'=>[
								'NumberFormat'=>'#,##0.00'
							],
							'waste_percent'=>[
								'NumberFormat'=>'0.00%'
							],
						]
					];			
	***************************************************************************************
	 * create at : 5/9/2018
	 * ********************
		use app\components\XExport;			
		$rows = $command->queryAll();  			
		XExport::x2xls($rows,$filename [,$options]);					
		15/3/2019                    			
			- add 'DateFormat'=>'dd-mm-yyyy'
			$options = [
				'columns'=>[        
					'Sale_Date'=>[
						'DateFormat'=>'dd-mm-yyyy'
					],					
		---------------------------------------------------	

			
	 ****************************************************************************************/


	public static function  X2xls($rows, $filename, $options = null)
	// ------------------------------------------------------------------------
	{
		// ===================================================================================================================		

		$startRow1 = 2;
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(12);

		$sheet = $spreadsheet->getActiveSheet();

		// -- set header
		$noExportColumns = isset($options["noExportColumns"]) ? $options["noExportColumns"] : [];
		$i = 0;
		$baseColumn = 0;
		foreach ($rows[0] as $fieldname => $data) {


			if (!in_array($baseColumn, $noExportColumns)) {
				// get column format A,B,AA,AB,...
				$col = (floor($i / 26) > 0 ? chr(65 + floor($i / 26) - 1) : '')
					. chr(65 + ($i % 26));
				$lb = isset($options["columns"][$fieldname]['Label']) ? $options["columns"][$fieldname]['Label'] : ucwords($fieldname, '_');

				//$sheet->setCellValue($col.($startRow1-1), $fieldname);
				$sheet->setCellValue($col . ($startRow1 - 1), $lb);

				//$maxWidth = max(array_map('strlen', array_map('trim', array_column($rows, $fieldname))));
				$sheet->getColumnDimension($col)->setAutoSize(true);
				$i++;
			}
			$baseColumn++;

			
		}

		// -- set data
		// --------------   row loop ---------
		foreach ($rows as $key => $row) {
			$i = 0;
			$baseColumn = 0;
			// ---------- column loop ---------------
			foreach ($rows[0] as $fieldname => $data) {
				if (!in_array($baseColumn, $noExportColumns)) {
					$col = (floor($i / 26) > 0 ? chr(65 + floor($i / 26) - 1) : '')
						. chr(65 + ($i % 26));
					$_cell = $col . ($startRow1 + $key);
					$sheet->setCellValue($_cell, $row[$fieldname]);
					if (isset($options["columns"][$fieldname]['NumberFormat'])) {
						$sheet->getStyle($_cell)->getNumberFormat()->setFormatCode($options["columns"][$fieldname]['NumberFormat']);
					} elseif (isset($options["columns"][$fieldname]['DateFormat'])) {
						if ($row[$fieldname] !== null) {
							$value = \app\components\XLib::dateConv($row[$fieldname], 'b');
							$excelDateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($value);
							$sheet->setCellValue($_cell, $excelDateValue);
							$sheet->getStyle($_cell)->getNumberFormat()->setFormatCode($options["columns"][$fieldname]['DateFormat']);
						}
					}
					$i++;
				}
				$baseColumn++;
			}
		}

		$writer = new Xls($spreadsheet);


		$writer->save($filename);

		// ===============================================================================================	
	}
}
