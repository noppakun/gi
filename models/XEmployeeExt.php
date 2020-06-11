<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_employee_ext".
 *
 * @property int $id
 * @property string $employee_code
 * @property string $iptoken
 * @property string $gi_username
 * @property string $deptcode_ext
 * @property string deptcode_pr_review
 */
class XEmployeeExt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_employee_ext';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['employee_code'], 'required'],
            [['employee_code', 'iptoken', 'gi_username','deptcode_ext','deptcode_pr_review'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_code' => 'Employee Code',
            'iptoken' => 'Iptoken',
            'gi_username' => 'Gi Username',
            'deptcode_ext'=>'แสดงข้อมูล TIME แผนก (001,002,...)',
            'deptcode_pr_review'=>'สิทธิ์ review pr แผนก (001,002,...)',
        ];
    }
}
