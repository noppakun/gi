<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pr;

/**
 * PrSearch represents the model behind the search form about `app\models\Pr`.
 */
class PrSearch extends Pr
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Companycode', 'PR_Number', 'Supp_Number', 'Quote', 'Shipto_Addr1', 'Shipto_Addr2', 'Currency_Type', 'Remarks', 'Remarks2', 'Remarks3', 'Order_Date', 'Buyers', 'Terms', 'DeptCode', 'DivisionCode', 'UserName', 'LastUpdate'], 'safe'],
            [['PO_Issue', 'Open_Close'], 'integer'],
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
        $query = Pr::find();

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
            'Order_Date' => $this->Order_Date,
            'PO_Issue' => $this->PO_Issue,
            'Open_Close' => $this->Open_Close,
            'LastUpdate' => $this->LastUpdate,
        ]);

        $query->andFilterWhere(['like', 'Companycode', $this->Companycode])
            ->andFilterWhere(['like', 'PR_Number', $this->PR_Number])
            ->andFilterWhere(['like', 'Supp_Number', $this->Supp_Number])
            ->andFilterWhere(['like', 'Quote', $this->Quote])
            ->andFilterWhere(['like', 'Shipto_Addr1', $this->Shipto_Addr1])
            ->andFilterWhere(['like', 'Shipto_Addr2', $this->Shipto_Addr2])
            ->andFilterWhere(['like', 'Currency_Type', $this->Currency_Type])
            ->andFilterWhere(['like', 'Remarks', $this->Remarks])
            ->andFilterWhere(['like', 'Remarks2', $this->Remarks2])
            ->andFilterWhere(['like', 'Remarks3', $this->Remarks3])
            ->andFilterWhere(['like', 'Buyers', $this->Buyers])
            ->andFilterWhere(['like', 'Terms', $this->Terms])
            ->andFilterWhere(['like', 'DeptCode', $this->DeptCode])
            ->andFilterWhere(['like', 'DivisionCode', $this->DivisionCode])
            ->andFilterWhere(['like', 'UserName', $this->UserName]);

        return $dataProvider;
    }
}
