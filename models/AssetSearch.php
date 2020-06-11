<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Asset;

/**
 * AssetSearch represents the model behind the search form about `app\models\Asset`.
 */
class AssetSearch extends Asset
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AssetCode', 'VoucherNo', 'Recv_Date', 'PONo', 'AccountNo', 'AssetFor', 'InvoiceNo', 'Supp_Number', 'Supp_Name', 'Asset_Category_Code', 'Asset_Type_Code', 'CompanyCode', 'DivisionCode', 'DeptCode', 'SectionCode', 'AssetDate', 'AssetName', 'Model', 'SerialNo', 'AssetUnit', 'Asset_Location_Code', 'Asset_AccountNo', 'WaranteeNo', 'InsuranceCorp', 'InsuranceNo', 'WaranteeStart', 'WaranteeStop', 'Remark', 'Sale_Date', 'Sale_DocNo', 'Sale_Remark', 'CsCode', 'DepreciationMethod', 'DepreciationManualDate', 'Acc_Depreciation', 'Acc_AccumulatedDepreciation', 'CalcDepreciationType', 'AccountCode_Tax', 'BranchCode', 'InvoiceDate', 'Acc_ScrapValue'], 'safe'],
            [['Qty', 'Sale_Status', 'CalcDepreciation', 'AssetLifeYear'], 'integer'],
            [['InsuranceRate', 'Insurance_Life', 'Depreciate', 'CostNovat', 'Vat_Percent', 'Vat', 'Cost', 'Sale_Price', 'PaidAmount', 'DepreciationBF', 'InitialAllowance', 'DepreciationRemain', 'DepreciationManual'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Asset::find();

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
//            'Recv_Date' => $this->Recv_Date,
//            'AssetDate' => $this->AssetDate,
            'Qty' => $this->Qty,
            'InsuranceRate' => $this->InsuranceRate,
            'Insurance_Life' => $this->Insurance_Life,
            'WaranteeStart' => $this->WaranteeStart,
            'WaranteeStop' => $this->WaranteeStop,
            'Depreciate' => $this->Depreciate,
            'CostNovat' => $this->CostNovat,
            'Vat_Percent' => $this->Vat_Percent,
            'Vat' => $this->Vat,
            'Cost' => $this->Cost,
            'Sale_Date' => $this->Sale_Date,
            'Sale_Price' => $this->Sale_Price,
            'Sale_Status' => $this->Sale_Status,
            'PaidAmount' => $this->PaidAmount,
            'DepreciationBF' => $this->DepreciationBF,
            'InitialAllowance' => $this->InitialAllowance,
            'CalcDepreciation' => $this->CalcDepreciation,
            'DepreciationRemain' => $this->DepreciationRemain,
            'DepreciationManual' => $this->DepreciationManual,
            'DepreciationManualDate' => $this->DepreciationManualDate,
            'AssetLifeYear' => $this->AssetLifeYear,
            'InvoiceDate' => $this->InvoiceDate,
        ]);

        $query->andFilterWhere(['like', 'AssetCode', $this->AssetCode])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])

            ->andFilterWhere(['like', 'convert(nvarchar(10), Recv_Date, 103)', $this->Recv_Date])
            ->andFilterWhere(['like', 'convert(nvarchar(10), AssetDate, 103)', $this->AssetDate])

            ->andFilterWhere(['like', 'PONo', $this->PONo])
            ->andFilterWhere(['like', 'AccountNo', $this->AccountNo])
            ->andFilterWhere(['like', 'AssetFor', $this->AssetFor])
            ->andFilterWhere(['like', 'InvoiceNo', $this->InvoiceNo])
            ->andFilterWhere(['like', 'Supp_Number', $this->Supp_Number])
            ->andFilterWhere(['like', 'Supp_Name', $this->Supp_Name])
            ->andFilterWhere(['like', 'Asset_Category_Code', $this->Asset_Category_Code])
            ->andFilterWhere(['like', 'Asset_Type_Code', $this->Asset_Type_Code])
            ->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'DivisionCode', $this->DivisionCode])
            ->andFilterWhere(['like', 'DeptCode', $this->DeptCode])
            ->andFilterWhere(['like', 'SectionCode', $this->SectionCode])
            ->andFilterWhere(['like', 'AssetName', $this->AssetName])
            ->andFilterWhere(['like', 'Model', $this->Model])
            ->andFilterWhere(['like', 'SerialNo', $this->SerialNo])
            ->andFilterWhere(['like', 'AssetUnit', $this->AssetUnit])
            ->andFilterWhere(['like', 'Asset_Location_Code', $this->Asset_Location_Code])
            ->andFilterWhere(['like', 'Asset_AccountNo', $this->Asset_AccountNo])
            ->andFilterWhere(['like', 'WaranteeNo', $this->WaranteeNo])
            ->andFilterWhere(['like', 'InsuranceCorp', $this->InsuranceCorp])
            ->andFilterWhere(['like', 'InsuranceNo', $this->InsuranceNo])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'Sale_DocNo', $this->Sale_DocNo])
            ->andFilterWhere(['like', 'Sale_Remark', $this->Sale_Remark])
            ->andFilterWhere(['like', 'CsCode', $this->CsCode])
            ->andFilterWhere(['like', 'DepreciationMethod', $this->DepreciationMethod])
            ->andFilterWhere(['like', 'Acc_Depreciation', $this->Acc_Depreciation])
            ->andFilterWhere(['like', 'Acc_AccumulatedDepreciation', $this->Acc_AccumulatedDepreciation])
            ->andFilterWhere(['like', 'CalcDepreciationType', $this->CalcDepreciationType])
            ->andFilterWhere(['like', 'AccountCode_Tax', $this->AccountCode_Tax])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'Acc_ScrapValue', $this->Acc_ScrapValue]);

        return $dataProvider;
    }
}
