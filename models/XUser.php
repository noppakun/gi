<?php



namespace app\models;

//use dektrium\user\models\User as BaseUser;

//class XUser extends BaseUser
class XUser extends \dektrium\user\models\User
{
    /*
    public function register()
    {
        // do your magic
    }
    */
    public function getXEmployeeExt()
    {
        return $this->hasOne(XEmployeeExt::className(), ['gi_username' => 'username']);
    }
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['EmployeeCode' => 'employee_code'])
            ->via('xEmployeeExt');
    }

    public static function tableName()
    {
        return '{{%x_user}}';
    }
}
