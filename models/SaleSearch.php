<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sale;

/**
 * SaleSearch represents the model behind the search form of `app\models\Sale`.
 */
class SaleSearch extends Sale
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'Sale_Number', 'Cust_No', 'Sale_Date', 'Rlse_Date', 'Cust_PO_No', 'Cust_PO_Date', 'SalesmanCode', 'Terms', 'Shipto_Addr1', 'Shipto_Addr2', 'Shipto_Addr3', 'Shipto_Addr4', 'UserName', 'LastUpdate', 'Remark1', 'Remark2', 'Remark3', 'BranchCode', 'Confirm_Terms', 'Confirm_Remark', 'Desc_Disc_Other', 'Vat_Type'], 'safe'],
            [['Disc_Cash', 'Disc_Percent', 'Disc_Special', 'Disc_Money', 'Disc_Other', 'Vat_Percent', 'Vat_Amount', 'Amount', 'TotalAmount'], 'number'],
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
        $query = Sale::find();

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
            'Sale_Date' => $this->Sale_Date,
            'Rlse_Date' => $this->Rlse_Date,
            'Cust_PO_Date' => $this->Cust_PO_Date,
            'LastUpdate' => $this->LastUpdate,
            'Disc_Cash' => $this->Disc_Cash,
            'Disc_Percent' => $this->Disc_Percent,
            'Disc_Special' => $this->Disc_Special,
            'Disc_Money' => $this->Disc_Money,
            'Disc_Other' => $this->Disc_Other,
            'Vat_Percent' => $this->Vat_Percent,
            'Vat_Amount' => $this->Vat_Amount,
            'Amount' => $this->Amount,
            'TotalAmount' => $this->TotalAmount,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'Sale_Number', $this->Sale_Number])
            ->andFilterWhere(['like', 'Cust_No', $this->Cust_No])
            ->andFilterWhere(['like', 'Cust_PO_No', $this->Cust_PO_No])
            ->andFilterWhere(['like', 'SalesmanCode', $this->SalesmanCode])
            ->andFilterWhere(['like', 'Terms', $this->Terms])
            ->andFilterWhere(['like', 'Shipto_Addr1', $this->Shipto_Addr1])
            ->andFilterWhere(['like', 'Shipto_Addr2', $this->Shipto_Addr2])
            ->andFilterWhere(['like', 'Shipto_Addr3', $this->Shipto_Addr3])
            ->andFilterWhere(['like', 'Shipto_Addr4', $this->Shipto_Addr4])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'Remark1', $this->Remark1])
            ->andFilterWhere(['like', 'Remark2', $this->Remark2])
            ->andFilterWhere(['like', 'Remark3', $this->Remark3])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'Confirm_Terms', $this->Confirm_Terms])
            ->andFilterWhere(['like', 'Confirm_Remark', $this->Confirm_Remark])
            ->andFilterWhere(['like', 'Desc_Disc_Other', $this->Desc_Disc_Other])
            ->andFilterWhere(['like', 'Vat_Type', $this->Vat_Type]);

        return $dataProvider;
    }
}
