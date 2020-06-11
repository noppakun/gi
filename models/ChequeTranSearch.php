<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ChequeTran;

/**
 * ChequeTranSearch represents the model behind the search form about `app\models\ChequeTran`.
 */
class ChequeTranSearch extends ChequeTran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'Type', 'VoucherNo', 'ChqNo', 'ChqStatus', 'ChqDate', 'ChqCode', 'BankCode', 'BankBranch', 'ChqRecvDate', 'ChqPassDate', 'ChqDepositDate', 'Remark', 'DepositSlip_CompanyCode', 'DepositSlip_Type', 'DepositSlip_VoucherNo', 'ChqLocationCode'], 'safe'],
            [['ChqPayAmount', 'Fee'], 'number'],
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
        $query = ChequeTran::find();

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
            'ChqDate' => $this->ChqDate,
            'ChqPayAmount' => $this->ChqPayAmount,
            'ChqRecvDate' => $this->ChqRecvDate,
            'ChqPassDate' => $this->ChqPassDate,
            'ChqDepositDate' => $this->ChqDepositDate,
            'Fee' => $this->Fee,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'Type', $this->Type])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'ChqNo', $this->ChqNo])
            ->andFilterWhere(['like', 'ChqStatus', $this->ChqStatus])
            ->andFilterWhere(['like', 'ChqCode', $this->ChqCode])
            ->andFilterWhere(['like', 'BankCode', $this->BankCode])
            ->andFilterWhere(['like', 'BankBranch', $this->BankBranch])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'DepositSlip_CompanyCode', $this->DepositSlip_CompanyCode])
            ->andFilterWhere(['like', 'DepositSlip_Type', $this->DepositSlip_Type])
            ->andFilterWhere(['like', 'DepositSlip_VoucherNo', $this->DepositSlip_VoucherNo])
            ->andFilterWhere(['like', 'ChqLocationCode', $this->ChqLocationCode]);

        return $dataProvider;
    }
}
