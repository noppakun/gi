<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ArBillTran;

/**
 * ArBillTranSearch represents the model behind the search form of `app\models\ArBillTran`.
 */
class ArBillTranSearch extends ArBillTran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'ArBillNo', 'Inv_Number', 'DocType', 'Inv_Date', 'Due_Date'], 'safe'],
            [['Amount', 'PayAmount'], 'number'],
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
        $query = ArBillTran::find();

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
            'Inv_Date' => $this->Inv_Date,
            'Amount' => $this->Amount,
            'Due_Date' => $this->Due_Date,
            'PayAmount' => $this->PayAmount,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'ArBillNo', $this->ArBillNo])
            ->andFilterWhere(['like', 'Inv_Number', $this->Inv_Number])
            ->andFilterWhere(['like', 'DocType', $this->DocType]);

        return $dataProvider;
    }
}
