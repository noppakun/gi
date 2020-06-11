<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecvProductRecord;

/**
 * RecvProductRecordSearch represents the model behind the search form about `app\models\RecvProductRecord`.
 */
class RecvProductRecordSearch extends RecvProductRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Order_Number', 'JobNo', 'Item_Number', 'VoucherNo', 'WhCode', 'Location', 'Ana_no', 'Acc_Date', 'Item_Type', 'Status', 'UserName', 'Fill_Date'], 'safe'],
            [['Recv_Qty', 'Acc_Qty', 'Rej_Qty'], 'number'],
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
        $query = RecvProductRecord::find();

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
            'Recv_Qty' => $this->Recv_Qty,
            'Acc_Qty' => $this->Acc_Qty,
            'Rej_Qty' => $this->Rej_Qty,
            'Acc_Date' => $this->Acc_Date,
            'Fill_Date' => $this->Fill_Date,
        ]);

        $query->andFilterWhere(['like', 'Order_Number', $this->Order_Number])
            ->andFilterWhere(['like', 'JobNo', $this->JobNo])
            ->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'WhCode', $this->WhCode])
            ->andFilterWhere(['like', 'Location', $this->Location])
            ->andFilterWhere(['like', 'Ana_no', $this->Ana_no])
            ->andFilterWhere(['like', 'Item_Type', $this->Item_Type])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'UserName', $this->UserName]);

        return $dataProvider;
    }
}
