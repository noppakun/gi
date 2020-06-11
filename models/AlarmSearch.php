<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Alarm;

/**
 * AlarmSearch represents the model behind the search form about `app\models\Alarm`.
 */
class AlarmSearch extends Alarm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hour', 'minute', 'period', 'active', 'inout'], 'integer'],
            [['note'], 'safe'],
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
        $query = Alarm::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'hour' => $this->hour,
            'minute' => $this->minute,
            'period' => $this->period,
            'active' => $this->active,
            'inout' => $this->inout,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
