<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\XEmployeeExt;

/**
 * XEmployeeExtSearch represents the model behind the search form of `app\models\XEmployeeExt`.
 */
class XEmployeeExtSearch extends XEmployeeExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['employee_code', 'iptoken', 'gi_username','deptcode_ext'], 'safe'],
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
        $query = XEmployeeExt::find();
        

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
        ]);

        $query->andFilterWhere(['like', 'employee_code', $this->employee_code])
            ->andFilterWhere(['like', 'iptoken', $this->iptoken])
            ->andFilterWhere(['like', 'gi_username', $this->gi_username])
            ->andFilterWhere(['like', 'deptcode_ext', $this->deptcode_ext]);

        return $dataProvider;
    }
}
