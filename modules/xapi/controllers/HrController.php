<?php

namespace app\modules\xapi\controllers;

use Yii;


use yii\web\Response;

//use app\components\XExport;

class HrController extends  \yii\web\Controller
{



	// http://gi.greaterman.com/gi/web/index.php?r=xapi/production/prod-yield
	// http://gi.greaterman.com/gi/web/index.php?r=xapi/production/prod-yield
	//------------------------------------------------------------------------------------
	public function actionGettoken($otp = '')
	//------------------------------------------------------------------------------------
	{
		//$otp = find

		/*
			1.USER install app get OTP
			2.IT insert otp to x_employee_ext->iptoken
			3.USER send OTP (api call to gi)
			4.GI receive and find in x_employee_ext
				if found 
					- gen token 
					- replace iptoken (OTP) with token
					- return token to app
				else
					- return error notfound
			5 USER receive token from api call gi 
				set token to SharedPreferences


		 
		*/
		// 
		$emp_x = \app\models\XEmployeeExt::find()
			->where('iptoken = :otp', [':otp' => $otp])
			->one();
		if ($emp_x !== null) {
			$token = md5(uniqid($otp, true));
			$emp_x->iptoken = $token;
			$emp_x->save();


			$emp = \app\models\Employee::find()
				->where('EmployeeCode = :em_code', [':em_code' => ($emp_x->employee_code)])
				->one();

			$ret = [
				'token' => $token,
				'user' => [
					'emcode' => $emp->EmployeeCode,
					'emname' => $emp->FirstName_Thai . ' ' . $emp->LastName_Thai,
				],

			];
		} else {
			$ret = [
				'token' => 'notfound',
				'otp' => $otp
			];
		}

		Yii::$app->response->format = Response::FORMAT_JSON;
		return  $ret;
	}

	//------------------------------------------------------------------------------------
	public function actionTimelog($year = 2019, $month = 5, $token = '')
	//------------------------------------------------------------------------------------
	{
		//$em_code='212042';
		$emp_x = \app\models\XEmployeeExt::find()
			->where('iptoken = :token', [':token' => $token])
			->one();
		if ($emp_x !== null) {
			$em_code = $emp_x->employee_code;
		} else {
			$em_code = 'token not found';
		}
		// test AAAAAAAAAAAAAAAAa
		//$em_code = '110013';
		//$em_code = '212042';
		// BBBBBBBBBBBBBBBBBBBb


		$sql = "exec xeHrTimeLogs :year1,:month1,:em_code";
		$connection = \Yii::$app->erpdb;
		$command = $connection->createCommand($sql);
		$command->bindParam(":year1", $year);
		$command->bindParam(":month1", $month);
		$command->bindParam(":em_code", $em_code);
		$rows =  $command->queryAll();

		$sql2 = "
		declare @month1 int 
		declare @year1 int
		declare @em_code varchar(10)
			
		set @month1 = 4
		set @year1 = 2019
		set @em_code='110013'
	
			set @month1 = :month1
			set @year1 = :year1
			set @em_code = :em_code
	
			
	  
		Select 
			-- B.EmployeeCode,
			cast(b.DateRecord as date)  as cdate 
			,cast (b.TimeRecord AS time) as timerec		
		From  EmployeeTransaction B
		where (year(b.DateRecord)=@year1 and month(b.DateRecord)=@month1)				 
		and b.EmployeeCode=@em_code
		order by b.DateRecord,b.TimeRecord				
					
		";

		$command = $connection->createCommand($sql2);
		$command->bindParam(":year1", $year);
		$command->bindParam(":month1", $month);
		$command->bindParam(":em_code", $em_code);
		$rawrecs =  $command->queryAll();

		foreach ($rows as $key => $row) {
			//$rows[$key]['rawrec'] = ['aa', 'bb', 'cc'];
			$cdate = $row['cdate'];
			//\app\components\XLib::xprint_r($cdate);
			$rows_filter = array_filter($rawrecs, function ($var) use ($cdate) {
				return ($var['cdate'] == $cdate);
			});
			// $rows[$key]['r1'] = substr($rows[$key]['r1'],0,8);
			// $rows[$key]['r2'] = substr($rows[$key]['r2'],0,8);
			// $rows[$key]['r3'] = substr($rows[$key]['r3'],0,8);

			$rows[$key]['rawrec'] = [];
			foreach ($rows_filter as $k => $r) {
				array_push($rows[$key]['rawrec'], $r['timerec']);
				//array_push($rows[$key]['rawrec'], substr($r['timerec'],0,8));
			};

 
		}
 
		$ret = [
			// 'user' => [
			// 	'emcode' => $em_code,
			// 	'emname' => $emp->FirstName_Thai . ' ' . $emp->LastName_Thai,
			// ],
			'rows' => $rows
		];
 
		Yii::$app->response->format = Response::FORMAT_JSON;
		return $ret;
   
	}


 
}
