<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ApCN;

/**
 * ApCNSearch represents the model behind the search form of `app\models\ApCN`.
 */
class ApCNSearch extends ApCN
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'ApCN_Number', 'ApCN_Date', 'DocType', 'VoucherNo', 'DocDate', 'Buyers', 'DivisionCode', 'DeptCode', 'Remark1', 'Remark2', 'Remark3', 'Adjust_Date', 'Supp_Number', 'BranchCode', 'AccountCode_Tax'], 'safe'],
            [['Voucher_TotalAmount', 'Voucher_Amount', 'Vat_Percent', 'Vat_Amount', 'Disc_Cash', 'Disc_Percent', 'Disc_Special', 'Disc_Money', 'Amount', 'TotalAmount', 'PaidAmount'], 'number'],
            [['Adjust_Many', 'ApCN_Issue', 'Open_Close'], 'integer'],
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
        $query = ApCN::find();

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
            'ApCN_Date' => $this->ApCN_Date,
            'DocDate' => $this->DocDate,
            'Voucher_TotalAmount' => $this->Voucher_TotalAmount,
            'Voucher_Amount' => $this->Voucher_Amount,
            'Vat_Percent' => $this->Vat_Percent,
            'Vat_Amount' => $this->Vat_Amount,
            'Adjust_Date' => $this->Adjust_Date,
            'Adjust_Many' => $this->Adjust_Many,
            'ApCN_Issue' => $this->ApCN_Issue,
            'Open_Close' => $this->Open_Close,
            'Disc_Cash' => $this->Disc_Cash,
            'Disc_Percent' => $this->Disc_Percent,
            'Disc_Special' => $this->Disc_Special,
            'Disc_Money' => $this->Disc_Money,
            'Amount' => $this->Amount,
            'TotalAmount' => $this->TotalAmount,
            'PaidAmount' => $this->PaidAmount,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'ApCN_Number', $this->ApCN_Number])
            ->andFilterWhere(['like', 'DocType', $this->DocType])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'Buyers', $this->Buyers])
            ->andFilterWhere(['like', 'DivisionCode', $this->DivisionCode])
            ->andFilterWhere(['like', 'DeptCode', $this->DeptCode])
            ->andFilterWhere(['like', 'Remark1', $this->Remark1])
            ->andFilterWhere(['like', 'Remark2', $this->Remark2])
            ->andFilterWhere(['like', 'Remark3', $this->Remark3])
            ->andFilterWhere(['like', 'Supp_Number', $this->Supp_Number])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'AccountCode_Tax', $this->AccountCode_Tax]);

        return $dataProvider;
    }
}
