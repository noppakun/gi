<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TypeInvent;

/**
 * TypeInventSearch represents the model behind the search form about `app\models\TypeInvent`.
 */
class TypeInventSearch extends TypeInvent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Type_Invent_Code', 'Type_Invent_Desc', 'Type_Invent'], 'safe'],
            [['RunningAna_no'], 'integer'],
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
        $query = TypeInvent::find();

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
            'RunningAna_no' => $this->RunningAna_no,
        ]);

        $query->andFilterWhere(['like', 'Type_Invent_Code', $this->Type_Invent_Code])
            ->andFilterWhere(['like', 'Type_Invent_Desc', $this->Type_Invent_Desc])
            ->andFilterWhere(['like', 'Type_Invent', $this->Type_Invent]);

        return $dataProvider;
    }
}
