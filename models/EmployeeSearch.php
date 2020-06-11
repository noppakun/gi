<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employee;

/**
 * EmployeeSearch represents the model behind the search form of `app\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EmployeeCode', 'TitleThai', 'FirstName_Thai', 'LastName_Thai', 'TitleEng', 'FirstName_Eng', 'LastName_Eng', 'Birthday', 'Sex', 'Origin', 'Nation', 'Religion', 'CommandeerStatus', 'CompanyCode', 'DivisionCode', 'DeptCode', 'SectionCode', 'EmployeePosition', 'DateToStart', 'DateToEnd', 'Resign', 'DateToTest', 'Address', 'Province', 'ZipCode', 'Telephone', 'Address_Now', 'Province_Now', 'ZipCode_Now', 'Telephone_Now', 'MarryStatus', 'CoupleName', 'CoupleWorkAddress', 'CoupleWorkProvince', 'CoupleWorkZipCode', 'CoupleWorkTelephone', 'FatherName', 'MatherName', 'Qualification', 'Field', 'Institue', 'OldCompany', 'OldPosition', 'OldDatetoStart', 'OldDatetoEnd', 'IDCode', 'IDAmphur', 'IDProvince', 'IDDatetoEnd', 'TaxCode', 'SocialCode', 'AccountNo', 'Bank', 'Branch', 'Photo', 'SubSectionCode', 'ShoeNo', 'ShoeColor', 'MapPhoto', 'EarnType', 'EmployeeJobFunction', 'BranchCode', 'EmployeeCodeExternal', 'BloodGroup', 'UserName', 'LastUpdate', 'AfterTestDesc'], 'safe'],
            [['EmployeeStatus', 'Age', 'Height', 'ManyChild', 'FatherAge', 'MatherAge', 'ManyRelation', 'ManyBrother', 'ManySister', 'ManyYoungerBrother', 'ManyYoungerSister', 'LineRelation', 'OldDay', 'OldMonth', 'OldYear', 'UseTimeAttendance', 'FatherLife', 'MotherLife'], 'integer'],
            [['Weight', 'Salary', 'DayIncome', 'GPA'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
 
        $query = Employee::find();
 
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        // grid filtering conditions
        $query->andFilterWhere([
            'EmployeeStatus' => $this->EmployeeStatus,
            'Birthday' => $this->Birthday,
            'Age' => $this->Age,
            'Height' => $this->Height,
            'Weight' => $this->Weight,
            'DateToStart' => $this->DateToStart,
            'DateToEnd' => $this->DateToEnd,
            'DateToTest' => $this->DateToTest,
            'Salary' => $this->Salary,
            'DayIncome' => $this->DayIncome,
            'ManyChild' => $this->ManyChild,
            'FatherAge' => $this->FatherAge,
            'MatherAge' => $this->MatherAge,
            'ManyRelation' => $this->ManyRelation,
            'ManyBrother' => $this->ManyBrother,
            'ManySister' => $this->ManySister,
            'ManyYoungerBrother' => $this->ManyYoungerBrother,
            'ManyYoungerSister' => $this->ManyYoungerSister,
            'LineRelation' => $this->LineRelation,
            'GPA' => $this->GPA,
            'OldDatetoStart' => $this->OldDatetoStart,
            'OldDatetoEnd' => $this->OldDatetoEnd,
            'OldDay' => $this->OldDay,
            'OldMonth' => $this->OldMonth,
            'OldYear' => $this->OldYear,
            'IDDatetoEnd' => $this->IDDatetoEnd,
            'UseTimeAttendance' => $this->UseTimeAttendance,
            'LastUpdate' => $this->LastUpdate,
            'FatherLife' => $this->FatherLife,
            'MotherLife' => $this->MotherLife,
        ]);

        $query->andFilterWhere(['like', 'EmployeeCode', $this->EmployeeCode])
            ->andFilterWhere(['like', 'TitleThai', $this->TitleThai])
            ->andFilterWhere(['like', 'FirstName_Thai', $this->FirstName_Thai])
            ->andFilterWhere(['like', 'LastName_Thai', $this->LastName_Thai])
            ->andFilterWhere(['like', 'TitleEng', $this->TitleEng])
            ->andFilterWhere(['like', 'FirstName_Eng', $this->FirstName_Eng])
            ->andFilterWhere(['like', 'LastName_Eng', $this->LastName_Eng])
            ->andFilterWhere(['like', 'Sex', $this->Sex])
            ->andFilterWhere(['like', 'Origin', $this->Origin])
            ->andFilterWhere(['like', 'Nation', $this->Nation])
            ->andFilterWhere(['like', 'Religion', $this->Religion])
            ->andFilterWhere(['like', 'CommandeerStatus', $this->CommandeerStatus])
            ->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'DivisionCode', $this->DivisionCode])
            ->andFilterWhere(['like', 'DeptCode', $this->DeptCode])
            ->andFilterWhere(['like', 'SectionCode', $this->SectionCode])
            ->andFilterWhere(['like', 'EmployeePosition', $this->EmployeePosition])
            ->andFilterWhere(['like', 'Resign', $this->Resign])
            ->andFilterWhere(['like', 'Address', $this->Address])
            ->andFilterWhere(['like', 'Province', $this->Province])
            ->andFilterWhere(['like', 'ZipCode', $this->ZipCode])
            ->andFilterWhere(['like', 'Telephone', $this->Telephone])
            ->andFilterWhere(['like', 'Address_Now', $this->Address_Now])
            ->andFilterWhere(['like', 'Province_Now', $this->Province_Now])
            ->andFilterWhere(['like', 'ZipCode_Now', $this->ZipCode_Now])
            ->andFilterWhere(['like', 'Telephone_Now', $this->Telephone_Now])
            ->andFilterWhere(['like', 'MarryStatus', $this->MarryStatus])
            ->andFilterWhere(['like', 'CoupleName', $this->CoupleName])
            ->andFilterWhere(['like', 'CoupleWorkAddress', $this->CoupleWorkAddress])
            ->andFilterWhere(['like', 'CoupleWorkProvince', $this->CoupleWorkProvince])
            ->andFilterWhere(['like', 'CoupleWorkZipCode', $this->CoupleWorkZipCode])
            ->andFilterWhere(['like', 'CoupleWorkTelephone', $this->CoupleWorkTelephone])
            ->andFilterWhere(['like', 'FatherName', $this->FatherName])
            ->andFilterWhere(['like', 'MatherName', $this->MatherName])
            ->andFilterWhere(['like', 'Qualification', $this->Qualification])
            ->andFilterWhere(['like', 'Field', $this->Field])
            ->andFilterWhere(['like', 'Institue', $this->Institue])
            ->andFilterWhere(['like', 'OldCompany', $this->OldCompany])
            ->andFilterWhere(['like', 'OldPosition', $this->OldPosition])
            ->andFilterWhere(['like', 'IDCode', $this->IDCode])
            ->andFilterWhere(['like', 'IDAmphur', $this->IDAmphur])
            ->andFilterWhere(['like', 'IDProvince', $this->IDProvince])
            ->andFilterWhere(['like', 'TaxCode', $this->TaxCode])
            ->andFilterWhere(['like', 'SocialCode', $this->SocialCode])
            ->andFilterWhere(['like', 'AccountNo', $this->AccountNo])
            ->andFilterWhere(['like', 'Bank', $this->Bank])
            ->andFilterWhere(['like', 'Branch', $this->Branch])
            ->andFilterWhere(['like', 'Photo', $this->Photo])
            ->andFilterWhere(['like', 'SubSectionCode', $this->SubSectionCode])
            ->andFilterWhere(['like', 'ShoeNo', $this->ShoeNo])
            ->andFilterWhere(['like', 'ShoeColor', $this->ShoeColor])
            ->andFilterWhere(['like', 'MapPhoto', $this->MapPhoto])
            ->andFilterWhere(['like', 'EarnType', $this->EarnType])
            ->andFilterWhere(['like', 'EmployeeJobFunction', $this->EmployeeJobFunction])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'EmployeeCodeExternal', $this->EmployeeCodeExternal])
            ->andFilterWhere(['like', 'BloodGroup', $this->BloodGroup])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'AfterTestDesc', $this->AfterTestDesc]);
        // ----------------------------------------------------------------
        // use in TimeattendanceController 
        // ----------------------------------------------------------------
        if (isset($params['TD_OPTION'])) {

            //$sup = $params['TD_OPTION']['supervisor'];

            $DeptCodeList =  $params['TD_OPTION']['DeptCodeList'];
             
            //\app\components\XLib::xprint_r($DeptCodeList);
 
            $query->andWhere(['or', 
                ['IN', 'DeptCode', $DeptCodeList],
                ['IN', "concat(DeptCode,'/',SectionCode)", $DeptCodeList]
            ]);

 
            $query->andFilterWhere([
                'EmployeeStatus' => 0,
            ]);
            $query->orderBy([
                'DeptCode' => SORT_ASC,
                'EmployeeCode' => SORT_ASC,
            ]);
            //\app\components\XLib::xprint_r($DeptCodeList );

            //\app\components\XLib::xprint_r($query->createCommand()->getRawSql());
        }
        return $dataProvider;
    }
}
