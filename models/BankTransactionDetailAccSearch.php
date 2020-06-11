<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BankTransactionDetailAcc;

/**
 * BankTransactionDetailAccSearch represents the model behind the search form of `app\models\BankTransactionDetailAcc`.
 */
class BankTransactionDetailAccSearch extends BankTransactionDetailAcc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'BankTranType', 'VoucherNo', 'AccountCode', 'CsCode', 'AccountDesc'], 'safe'],
            [['Amount'], 'number'],
            [['seq_number'], 'integer'],
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
        $query = BankTransactionDetailAcc::find();

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
            'Amount' => $this->Amount,
            'seq_number' => $this->seq_number,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'BankTranType', $this->BankTranType])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'AccountCode', $this->AccountCode])
            ->andFilterWhere(['like', 'CsCode', $this->CsCode])
            ->andFilterWhere(['like', 'AccountDesc', $this->AccountDesc]);

        return $dataProvider;
    }
}
