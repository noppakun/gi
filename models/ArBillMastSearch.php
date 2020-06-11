<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ArBillMast;

/**
 * ArBillMastSearch represents the model behind the search form of `app\models\ArBillMast`.
 */
class ArBillMastSearch extends ArBillMast
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'ArBillNo', 'ArBillDate', 'Cust_No', 'ArDocDate', 'ArRemark', 'ArDueDate', 'CreditTerm', 'UserName', 'LastUpdate'], 'safe'],
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
        $query = ArBillMast::find();

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
            'ArBillDate' => $this->ArBillDate,
            'ArDocDate' => $this->ArDocDate,
            'ArDueDate' => $this->ArDueDate,
            'LastUpdate' => $this->LastUpdate,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'ArBillNo', $this->ArBillNo])
            ->andFilterWhere(['like', 'Cust_No', $this->Cust_No])
            ->andFilterWhere(['like', 'ArRemark', $this->ArRemark])
            ->andFilterWhere(['like', 'CreditTerm', $this->CreditTerm])
            ->andFilterWhere(['like', 'UserName', $this->UserName]);

        return $dataProvider;
    }
}
