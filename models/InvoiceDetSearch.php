<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InvoiceDet;

/**
 * InvoiceDetSearch represents the model behind the search form about `app\models\InvoiceDet`.
 */
class InvoiceDetSearch extends InvoiceDet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'Inv_Number', 'Item_Number', 'InvDet_Desc', 'Uom', 'Batch_No', 'WhCode', 'Location'], 'safe'],
            [['Seq_Number', 'Type_Desc', 'IssueStatus', 'DescStatus'], 'integer'],
            [['Order_Qty', 'Price', 'Disc_Percent', 'Disc_Cash'], 'number'],
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
        $query = InvoiceDet::find();

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
            'Type_Desc' => $this->Type_Desc,
            'IssueStatus' => $this->IssueStatus,
            'DescStatus' => $this->DescStatus,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'Inv_Number', $this->Inv_Number])
            ->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'InvDet_Desc', $this->InvDet_Desc])
            ->andFilterWhere(['like', 'Uom', $this->Uom])
            ->andFilterWhere(['like', 'Batch_No', $this->Batch_No])
            ->andFilterWhere(['like', 'WhCode', $this->WhCode])
            ->andFilterWhere(['like', 'Location', $this->Location]);

        return $dataProvider;
    }
}
