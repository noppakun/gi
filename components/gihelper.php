<?php
namespace app\components;


class gihelper{
	public static function comp_name() {
		$company = \app\models\Company::findOne(['CompanyCode'=>\yii::$app->params['comp_code']]);
        return $company->CompanyName;
     }	     
     
}

?>