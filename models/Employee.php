<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Employee".
 *
 * @property string $EmployeeCode
 * @property string $TitleThai
 * @property string $FirstName_Thai
 * @property string $LastName_Thai
 * @property string $TitleEng
 * @property string $FirstName_Eng
 * @property string $LastName_Eng
 * @property int $EmployeeStatus
 * @property string $Birthday
 * @property int $Age
 * @property string $Sex
 * @property string $Origin
 * @property string $Nation
 * @property string $Religion
 * @property string $CommandeerStatus
 * @property int $Height
 * @property string $Weight
 * @property string $CompanyCode
 * @property string $DivisionCode
 * @property string $DeptCode
 * @property string $SectionCode
 * @property string $EmployeePosition
 * @property string $DateToStart
 * @property string $DateToEnd
 * @property string $Resign
 * @property string $DateToTest
 * @property string $Salary
 * @property string $DayIncome
 * @property string $Address
 * @property string $Province
 * @property string $ZipCode
 * @property string $Telephone
 * @property string $Address_Now
 * @property string $Province_Now
 * @property string $ZipCode_Now
 * @property string $Telephone_Now
 * @property string $MarryStatus
 * @property string $CoupleName
 * @property string $CoupleWorkAddress
 * @property string $CoupleWorkProvince
 * @property string $CoupleWorkZipCode
 * @property string $CoupleWorkTelephone
 * @property int $ManyChild
 * @property string $FatherName
 * @property int $FatherAge
 * @property string $MatherName
 * @property int $MatherAge
 * @property int $ManyRelation
 * @property int $ManyBrother
 * @property int $ManySister
 * @property int $ManyYoungerBrother
 * @property int $ManyYoungerSister
 * @property int $LineRelation
 * @property string $Qualification
 * @property string $Field
 * @property string $Institue
 * @property string $GPA
 * @property string $OldCompany
 * @property string $OldPosition
 * @property string $OldDatetoStart
 * @property string $OldDatetoEnd
 * @property int $OldDay
 * @property int $OldMonth
 * @property int $OldYear
 * @property string $IDCode
 * @property string $IDAmphur
 * @property string $IDProvince
 * @property string $IDDatetoEnd
 * @property string $TaxCode
 * @property string $SocialCode
 * @property string $AccountNo
 * @property string $Bank
 * @property string $Branch
 * @property resource $Photo
 * @property int $UseTimeAttendance
 * @property string $SubSectionCode
 * @property string $ShoeNo
 * @property string $ShoeColor
 * @property resource $MapPhoto
 * @property string $EarnType
 * @property string $EmployeeJobFunction
 * @property string $BranchCode
 * @property string $EmployeeCodeExternal
 * @property string $BloodGroup
 * @property string $UserName
 * @property string $LastUpdate
 * @property int $FatherLife
 * @property int $MotherLife
 * @property string $AfterTestDesc
 */
class Employee extends \yii\db\ActiveRecord
{
    
    public function getDepart()
    {        
        return $this->hasOne(Depart::className(), ['DeptCode' => 'DeptCode']);         
    }

    public function getEmployeePosition()
    {        
        return $this->hasOne(EmployeePosition::className(), ['EmployeePositionCode' => 'EmployeePosition']);         
    }
        
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EmployeeCode', 'TitleThai', 'FirstName_Thai', 'LastName_Thai', 'EmployeeStatus'], 'required'],
            [['EmployeeCode', 'TitleThai', 'FirstName_Thai', 'LastName_Thai', 'TitleEng', 'FirstName_Eng', 'LastName_Eng', 'Sex', 'Origin', 'Nation', 'Religion', 'CommandeerStatus', 'CompanyCode', 'DivisionCode', 'DeptCode', 'SectionCode', 'EmployeePosition', 'Resign', 'Address', 'Province', 'ZipCode', 'Telephone', 'Address_Now', 'Province_Now', 'ZipCode_Now', 'Telephone_Now', 'MarryStatus', 'CoupleName', 'CoupleWorkAddress', 'CoupleWorkProvince', 'CoupleWorkZipCode', 'CoupleWorkTelephone', 'FatherName', 'MatherName', 'Qualification', 'Field', 'Institue', 'OldCompany', 'OldPosition', 'IDCode', 'IDAmphur', 'IDProvince', 'TaxCode', 'SocialCode', 'AccountNo', 'Bank', 'Branch', 'Photo', 'SubSectionCode', 'ShoeNo', 'ShoeColor', 'MapPhoto', 'EarnType', 'EmployeeJobFunction', 'BranchCode', 'EmployeeCodeExternal', 'BloodGroup', 'UserName', 'AfterTestDesc'], 'string'],
            [['EmployeeStatus', 'Age', 'Height', 'ManyChild', 'FatherAge', 'MatherAge', 'ManyRelation', 'ManyBrother', 'ManySister', 'ManyYoungerBrother', 'ManyYoungerSister', 'LineRelation', 'OldDay', 'OldMonth', 'OldYear', 'UseTimeAttendance', 'FatherLife', 'MotherLife'], 'integer'],
            [['Birthday', 'DateToStart', 'DateToEnd', 'DateToTest', 'OldDatetoStart', 'OldDatetoEnd', 'IDDatetoEnd', 'LastUpdate'], 'safe'],
            [['Weight', 'Salary', 'DayIncome', 'GPA'], 'number'],
            [['EmployeeCode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'EmployeeCode' => 'รหัสพนักงาน',
            'TitleThai' => 'Title Thai',
            'FirstName_Thai' => 'ซื่อ',
            'LastName_Thai' => 'นามสกุล',
            'TitleEng' => 'Title Eng',
            'FirstName_Eng' => 'First Name  Eng',
            'LastName_Eng' => 'Last Name  Eng',
            'EmployeeStatus' => 'Employee Status',
            'Birthday' => 'Birthday',
            'Age' => 'Age',
            'Sex' => 'Sex',
            'Origin' => 'Origin',
            'Nation' => 'Nation',
            'Religion' => 'Religion',
            'CommandeerStatus' => 'Commandeer Status',
            'Height' => 'Height',
            'Weight' => 'Weight',
            'CompanyCode' => 'Company Code',
            'DivisionCode' => 'Division Code',
            'DeptCode' => 'รหัสแผนก',
            'SectionCode' => 'Section Code',
            'EmployeePosition' => 'Employee Position',
            'DateToStart' => 'Date To Start',
            'DateToEnd' => 'Date To End',
            'Resign' => 'Resign',
            'DateToTest' => 'Date To Test',
            'Salary' => 'Salary',
            'DayIncome' => 'Day Income',
            'Address' => 'Address',
            'Province' => 'Province',
            'ZipCode' => 'Zip Code',
            'Telephone' => 'Telephone',
            'Address_Now' => 'Address  Now',
            'Province_Now' => 'Province  Now',
            'ZipCode_Now' => 'Zip Code  Now',
            'Telephone_Now' => 'Telephone  Now',
            'MarryStatus' => 'Marry Status',
            'CoupleName' => 'Couple Name',
            'CoupleWorkAddress' => 'Couple Work Address',
            'CoupleWorkProvince' => 'Couple Work Province',
            'CoupleWorkZipCode' => 'Couple Work Zip Code',
            'CoupleWorkTelephone' => 'Couple Work Telephone',
            'ManyChild' => 'Many Child',
            'FatherName' => 'Father Name',
            'FatherAge' => 'Father Age',
            'MatherName' => 'Mather Name',
            'MatherAge' => 'Mather Age',
            'ManyRelation' => 'Many Relation',
            'ManyBrother' => 'Many Brother',
            'ManySister' => 'Many Sister',
            'ManyYoungerBrother' => 'Many Younger Brother',
            'ManyYoungerSister' => 'Many Younger Sister',
            'LineRelation' => 'Line Relation',
            'Qualification' => 'Qualification',
            'Field' => 'Field',
            'Institue' => 'Institue',
            'GPA' => 'Gpa',
            'OldCompany' => 'Old Company',
            'OldPosition' => 'Old Position',
            'OldDatetoStart' => 'Old Dateto Start',
            'OldDatetoEnd' => 'Old Dateto End',
            'OldDay' => 'Old Day',
            'OldMonth' => 'Old Month',
            'OldYear' => 'Old Year',
            'IDCode' => 'Idcode',
            'IDAmphur' => 'Idamphur',
            'IDProvince' => 'Idprovince',
            'IDDatetoEnd' => 'Iddateto End',
            'TaxCode' => 'Tax Code',
            'SocialCode' => 'Social Code',
            'AccountNo' => 'Account No',
            'Bank' => 'Bank',
            'Branch' => 'Branch',
            'Photo' => 'Photo',
            'UseTimeAttendance' => 'Use Time Attendance',
            'SubSectionCode' => 'Sub Section Code',
            'ShoeNo' => 'Shoe No',
            'ShoeColor' => 'Shoe Color',
            'MapPhoto' => 'Map Photo',
            'EarnType' => 'Earn Type',
            'EmployeeJobFunction' => 'Employee Job Function',
            'BranchCode' => 'Branch Code',
            'EmployeeCodeExternal' => 'Employee Code External',
            'BloodGroup' => 'Blood Group',
            'UserName' => 'User Name',
            'LastUpdate' => 'Last Update',
            'FatherLife' => 'Father Life',
            'MotherLife' => 'Mother Life',
            'AfterTestDesc' => 'After Test Desc',
        ];
    }
}
