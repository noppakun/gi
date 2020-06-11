<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\XPif;

/**
 * XPifSearch represents the model behind the search form of `app\models\XPif`.
 */
class XPifSearch extends XPif
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['pif_id', 'pif_name', 'description','items_ref'], 'safe'],
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
    public function search($params,$approve=false)
    {
        $query = XPif::find();

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
        if ($approve){
            $query->andWhere(['not', ['approve_datetime' => null]]);
        }else{
            $query->andWhere(['approve_datetime' => null]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'pif_id', $this->pif_id])
            ->andFilterWhere(['like', 'pif_name', $this->pif_name])
            ->andFilterWhere(['like', 'items_ref', $this->items_ref])
            ->andFilterWhere(['like', 'description', $this->description]);
         

        return $dataProvider;
    }
}
