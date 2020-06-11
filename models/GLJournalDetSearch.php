<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GLJournalDet;

/**
 * GLJournalDetSearch represents the model behind the search form of `app\models\GLJournalDet`.
 */
class GLJournalDetSearch extends GLJournalDet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'GLBookCode', 'VoucherNo', 'AccNum', 'Description', 'TranType', 'UserName', 'UpdateTime', 'CsCode'], 'safe'],
            [['Seq_Number'], 'integer'],
            [['Amount', 'DebitAmount', 'CreditAmount'], 'number'],
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
        $query = GLJournalDet::find();

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
            'Seq_Number' => $this->Seq_Number,
            'Amount' => $this->Amount,
            'UpdateTime' => $this->UpdateTime,
            'DebitAmount' => $this->DebitAmount,
            'CreditAmount' => $this->CreditAmount,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'GLBookCode', $this->GLBookCode])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'AccNum', $this->AccNum])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'TranType', $this->TranType])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'CsCode', $this->CsCode]);

        return $dataProvider;
    }
}
