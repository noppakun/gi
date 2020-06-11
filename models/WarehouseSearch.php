<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Warehouse;

/**
 * WarehouseSearch represents the model behind the search form about `app\models\Warehouse`.
 */
class WarehouseSearch extends Warehouse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['WhCode', 'WhName', 'Address1', 'Address2', 'Address3', 'Address4', 'Phone', 'Fax', 'Person_Incharge', 'Remarks'], 'safe'],
            [['NotActive'], 'integer'],
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
        $query = Warehouse::find();

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
            'NotActive' => $this->NotActive,
        ]);

        $query->andFilterWhere(['like', 'WhCode', $this->WhCode])
            ->andFilterWhere(['like', 'WhName', $this->WhName])
            ->andFilterWhere(['like', 'Address1', $this->Address1])
            ->andFilterWhere(['like', 'Address2', $this->Address2])
            ->andFilterWhere(['like', 'Address3', $this->Address3])
            ->andFilterWhere(['like', 'Address4', $this->Address4])
            ->andFilterWhere(['like', 'Phone', $this->Phone])
            ->andFilterWhere(['like', 'Fax', $this->Fax])
            ->andFilterWhere(['like', 'Person_Incharge', $this->Person_Incharge])
            ->andFilterWhere(['like', 'Remarks', $this->Remarks]);

        return $dataProvider;
    }
}
