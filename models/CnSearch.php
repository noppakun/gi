<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cn;

/**
 * CnSearch represents the model behind the search form about `app\models\Cn`.
 */
class CnSearch extends Cn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'CN_Number', 'CN_Date', 'Inv_Number', 'Inv_Date', 'SalesmanCode', 'DivisionCode', 'DeptCode', 'Remark1', 'Remark2', 'Remark3', 'Adjust_Date', 'Cust_No', 'BranchCode', 'Vat_type'], 'safe'],
            [['Inv_TotalAmount', 'Inv_Amount', 'Vat_Percent', 'Vat_Amount', 'Disc_Cash', 'Disc_Percent', 'Disc_Special', 'Disc_Money', 'Amount', 'TotalAmount', 'PaidAmount'], 'number'],
            [['Adjust_Many', 'CN_Issue', 'Open_Close'], 'integer'],
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
        $query = Cn::find();

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
            'CN_Date' => $this->CN_Date,
            'Inv_Date' => $this->Inv_Date,
            'Inv_TotalAmount' => $this->Inv_TotalAmount,
            'Inv_Amount' => $this->Inv_Amount,
            'Vat_Percent' => $this->Vat_Percent,
            'Vat_Amount' => $this->Vat_Amount,
            'Adjust_Date' => $this->Adjust_Date,
            'Adjust_Many' => $this->Adjust_Many,
            'CN_Issue' => $this->CN_Issue,
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
            ->andFilterWhere(['like', 'CN_Number', $this->CN_Number])
            ->andFilterWhere(['like', 'Inv_Number', $this->Inv_Number])
            ->andFilterWhere(['like', 'SalesmanCode', $this->SalesmanCode])
            ->andFilterWhere(['like', 'DivisionCode', $this->DivisionCode])
            ->andFilterWhere(['like', 'DeptCode', $this->DeptCode])
            ->andFilterWhere(['like', 'Remark1', $this->Remark1])
            ->andFilterWhere(['like', 'Remark2', $this->Remark2])
            ->andFilterWhere(['like', 'Remark3', $this->Remark3])
            ->andFilterWhere(['like', 'Cust_No', $this->Cust_No])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'Vat_type', $this->Vat_type]);

        return $dataProvider;
    }
}
