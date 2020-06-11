<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SaleDet;

/**
 * SaleDetearch represents the model behind the search form of `app\models\SaleDet`.
 */
class SaleDetSearch extends SaleDet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'Sale_Number', 'Item_Number', 'Due_Date', 'SaleDet_Desc', 'Uom', 'Promise_Delivery_Date', 'Inform_Date', 'Production_Date_Complete', 'Order_Status', 'Balance_Date', 'Remark'], 'safe'],
            [['Seq_Number', 'Sale_Close'], 'integer'],
            [['Order_Qty', 'Rlse_Qty', 'Price', 'Inv_Qty', 'Disc_Percent', 'Disc_Cash', 'Confirm_Price'], 'number'],
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
        $query = SaleDet::find();

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
            'Due_Date' => $this->Due_Date,
            'Order_Qty' => $this->Order_Qty,
            'Rlse_Qty' => $this->Rlse_Qty,
            'Price' => $this->Price,
            'Sale_Close' => $this->Sale_Close,
            'Promise_Delivery_Date' => $this->Promise_Delivery_Date,
            'Inform_Date' => $this->Inform_Date,
            'Production_Date_Complete' => $this->Production_Date_Complete,
            'Balance_Date' => $this->Balance_Date,
            'Inv_Qty' => $this->Inv_Qty,
            'Disc_Percent' => $this->Disc_Percent,
            'Disc_Cash' => $this->Disc_Cash,
            'Confirm_Price' => $this->Confirm_Price,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'Sale_Number', $this->Sale_Number])
            ->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'SaleDet_Desc', $this->SaleDet_Desc])
            ->andFilterWhere(['like', 'Uom', $this->Uom])
            ->andFilterWhere(['like', 'Order_Status', $this->Order_Status])
            ->andFilterWhere(['like', 'Remark', $this->Remark]);

        return $dataProvider;
    }
}
