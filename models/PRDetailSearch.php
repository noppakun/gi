<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PRDetail;

/**
 * PRDetailSearch represents the model behind the search form of `app\models\PRDetail`.
 */
class PRDetailSearch extends PRDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'PR_Number', 'Item_Number', 'Due_Date', 'Rlse_Date', 'PRDet_Desc', 'Uom', 'score', 'revdte1', 'revdte2'], 'safe'],
            [['Seq_Number', 'Type_Desc', 'PO_Issue'], 'integer'],
            [['Order_Qty', 'Price', 'Rlse_Qty', 'Recd_Qty', 'PO_Qty'], 'number'],
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
        $query = PRDetail::find();

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
            'Rlse_Date' => $this->Rlse_Date,
            'Price' => $this->Price,
            'Rlse_Qty' => $this->Rlse_Qty,
            'Recd_Qty' => $this->Recd_Qty,
            'Type_Desc' => $this->Type_Desc,
            'PO_Qty' => $this->PO_Qty,
            'PO_Issue' => $this->PO_Issue,
            'revdte1' => $this->revdte1,
            'revdte2' => $this->revdte2,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'PR_Number', $this->PR_Number])
            ->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'PRDet_Desc', $this->PRDet_Desc])
            ->andFilterWhere(['like', 'Uom', $this->Uom])
            ->andFilterWhere(['like', 'score', $this->score]);

        return $dataProvider;
    }
}
