<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\XBooking;

/**
 * XBookingSearch represents the model behind the search form of `app\models\XBooking`.
 */
class XBookingSearch extends XBooking
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_no', 'doc_date', 'title', 'dt_start', 'dt_end', 'remark', 'username', 'status'], 'safe'],
            [['track_id'], 'integer'],
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
        $query = XBooking::find()->orderBy(['dt_start' => SORT_ASC]);    
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
            'doc_date' => $this->doc_date,
            'track_id' => $this->track_id,
            'dt_start' => $this->dt_start,
            'dt_end' => $this->dt_end,
        ]);

        $query->andFilterWhere(['like', 'doc_no', $this->doc_no])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
