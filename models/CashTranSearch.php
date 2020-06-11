<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CashTran;

/**
 * CashTranSearch represents the model behind the search form about `app\models\CashTran`.
 */
class CashTranSearch extends CashTran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'Type', 'VoucherNo', 'DocNo', 'BillNo', 'DocType', 'DocDate', 'Accnum'], 'safe'],
            [['Amount', 'PayAmount', 'BalanceAmount'], 'number'],
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
        $query = CashTran::find();

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
            'Amount' => $this->Amount,
            'PayAmount' => $this->PayAmount,
            'BalanceAmount' => $this->BalanceAmount,
            'DocDate' => $this->DocDate,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'Type', $this->Type])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'DocNo', $this->DocNo])
            ->andFilterWhere(['like', 'BillNo', $this->BillNo])
            ->andFilterWhere(['like', 'DocType', $this->DocType])
            ->andFilterWhere(['like', 'Accnum', $this->Accnum]);
            

        return $dataProvider;
    }
}
