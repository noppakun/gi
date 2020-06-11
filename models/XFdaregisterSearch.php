<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\XFdaregister;

/**
 * XFdaregisterSearch represents the model behind the search form of `app\models\XFdaregister`.
 */
class XFdaregisterSearch extends XFdaregister
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['regno', 'regname', 'recdate', 'expdate', 'canceldate','lastnotifydate'], 'safe'],
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
        $query = XFdaregister::find()->orderBy([
            'canceldate' => SORT_ASC,
            'expdate' => SORT_ASC,
            //--'expdate' => SORT_ASC,
            //'id'=>SORT_ASC
        ]);
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
            'id' => $this->id,
            /*
            'recdate' => $this->recdate,
            'expdate' => $this->expdate,
            'canceldate' => $this->canceldate,
            */
        ]);

        $query->andFilterWhere(['like', 'regno', $this->regno])
            ->andFilterWhere(['like', 'regname', $this->regname])
            ->andFilterWhere(['like', 'CONVERT(varchar(10), recdate, 105)', $this->recdate])
            ->andFilterWhere(['like', 'CONVERT(varchar(10), expdate, 105)', $this->expdate])
            ->andFilterWhere(['like', 'CONVERT(varchar(10), canceldate, 105)', $this->canceldate]);

        return $dataProvider;
    }
}
