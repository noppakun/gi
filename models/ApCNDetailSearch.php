<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ApCNDetail;

/**
 * ApCNDetailSearch represents the model behind the search form of `app\models\ApCNDetail`.
 */
class ApCNDetailSearch extends ApCNDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'ApCN_Number', 'Item_Number', 'ApCNDet_Desc', 'Uom', 'AccountCode'], 'safe'],
            [['Seq_Number', 'Type_Desc'], 'integer'],
            [['Order_Qty', 'Price', 'Disc_Percent', 'Disc_Cash', 'SumPrice', 'Voucher_SumPrice'], 'number'],
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
        $query = ApCNDetail::find();

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
            'Order_Qty' => $this->Order_Qty,
            'Price' => $this->Price,
            'Disc_Percent' => $this->Disc_Percent,
            'Disc_Cash' => $this->Disc_Cash,
            'SumPrice' => $this->SumPrice,
            'Type_Desc' => $this->Type_Desc,
            'Voucher_SumPrice' => $this->Voucher_SumPrice,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'ApCN_Number', $this->ApCN_Number])
            ->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'ApCNDet_Desc', $this->ApCNDet_Desc])
            ->andFilterWhere(['like', 'Uom', $this->Uom])
            ->andFilterWhere(['like', 'AccountCode', $this->AccountCode]);

        return $dataProvider;
    }
}
