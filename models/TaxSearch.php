<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tax;

/**
 * TaxSearch represents the model behind the search form about `app\models\Tax`.
 */
class TaxSearch extends Tax
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TaxType', 'TaxInv', 'Supp_TaxInv', 'InvDate', 'Period', 'CsCode', 'Remark1', 'Remark2', 'DocType', 'CompanyCode', 'VoucherNo', 'UserName', 'LastUpdate', 'Cust_no', 'supp_number', 'Supp_Name', 'TaxId', 'BranchCode', 'Vat_Ch'], 'safe'],
            [['Late'], 'integer'],
            [['Amount1', 'Vat1', 'Amount2', 'Vat2', 'Amount3'], 'number'],
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
        $query = Tax::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'InvDate' => $this->InvDate,
            'Late' => $this->Late,
            'Amount1' => $this->Amount1,
            'Vat1' => $this->Vat1,
            'Amount2' => $this->Amount2,
            'Vat2' => $this->Vat2,
            'Amount3' => $this->Amount3,
            'LastUpdate' => $this->LastUpdate,
        ]);

        $query->andFilterWhere(['like', 'TaxType', $this->TaxType])
            ->andFilterWhere(['like', 'TaxInv', $this->TaxInv])
            ->andFilterWhere(['like', 'Supp_TaxInv', $this->Supp_TaxInv])
            ->andFilterWhere(['like', 'Period', $this->Period])
            ->andFilterWhere(['like', 'CsCode', $this->CsCode])
            ->andFilterWhere(['like', 'Remark1', $this->Remark1])
            ->andFilterWhere(['like', 'Remark2', $this->Remark2])
            ->andFilterWhere(['like', 'DocType', $this->DocType])
            ->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'Cust_no', $this->Cust_no])
            ->andFilterWhere(['like', 'supp_number', $this->supp_number])
            ->andFilterWhere(['like', 'Supp_Name', $this->Supp_Name])
            ->andFilterWhere(['like', 'TaxId', $this->TaxId])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'Vat_Ch', $this->Vat_Ch]);

        return $dataProvider;
    }
}
