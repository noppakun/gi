<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ItemBatch;

/**
 * ItemBatchSearch represents the model behind the search form of `app\models\ItemBatch`.
 */
class ItemBatchSearch extends ItemBatch
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Item_number', 'Batch_Date', 'DocType_Recv', 'VoucherNo_Recv', 'WhCode', 'Loc_number', 'Ana_No', 'DocType_Issue', 'Voucherno_Issue'], 'safe'],
            [['Batch'], 'integer'],
            [['Ana_Qty', 'Ori_Qty', 'QOh', 'Cost'], 'number'],
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
        $query = ItemBatch::find();

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
            'Batch_Date' => $this->Batch_Date,
            'Batch' => $this->Batch,
            'Ana_Qty' => $this->Ana_Qty,
            'Ori_Qty' => $this->Ori_Qty,
            'QOh' => $this->QOh,
            'Cost' => $this->Cost,
        ]);

        $query->andFilterWhere(['like', 'Item_number', $this->Item_number])
            ->andFilterWhere(['like', 'DocType_Recv', $this->DocType_Recv])
            ->andFilterWhere(['like', 'VoucherNo_Recv', $this->VoucherNo_Recv])
            ->andFilterWhere(['like', 'WhCode', $this->WhCode])
            ->andFilterWhere(['like', 'Loc_number', $this->Loc_number])
            ->andFilterWhere(['like', 'Ana_No', $this->Ana_No])
            ->andFilterWhere(['like', 'DocType_Issue', $this->DocType_Issue])
            ->andFilterWhere(['like', 'Voucherno_Issue', $this->Voucherno_Issue]);

        return $dataProvider;
    }
}
