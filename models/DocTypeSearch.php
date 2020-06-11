<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DocType;

/**
 * DocTypeSearch represents the model behind the search form of `app\models\DocType`.
 */
class DocTypeSearch extends DocType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DocType', 'DocTypeDesc', 'ReportDesc'], 'safe'],
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
        $query = DocType::find();

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
        $query->andFilterWhere(['like', 'DocType', $this->DocType])
            ->andFilterWhere(['like', 'DocTypeDesc', $this->DocTypeDesc])
            ->andFilterWhere(['like', 'ReportDesc', $this->ReportDesc]);

        return $dataProvider;
    }
}
