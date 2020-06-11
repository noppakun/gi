<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SpecRaw;

/**
 * SpecRawSearch represents the model behind the search form about `app\models\SpecRaw`.
 */
class SpecRawSearch extends SpecRaw
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Item_Number', 'SpecNo', 'EffectiveDate', 'SpecificationDesc', 'StorageCondition', 'DescForAnalysis', 'DescForCertificate', 'ShortStorageCondition', 'UserName', 'LastUpdate'], 'safe'],
            [['RetestInterval'], 'number'],
            [['SpecCancel', 'ReviseNo'], 'integer'],
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
        $query = SpecRaw::find();

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
            'EffectiveDate' => $this->EffectiveDate,
            'RetestInterval' => $this->RetestInterval,
            'SpecCancel' => $this->SpecCancel,
            'ReviseNo' => $this->ReviseNo,
            'LastUpdate' => $this->LastUpdate,
        ]);

        $query->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'SpecNo', $this->SpecNo])
            ->andFilterWhere(['like', 'SpecificationDesc', $this->SpecificationDesc])
            ->andFilterWhere(['like', 'StorageCondition', $this->StorageCondition])
            ->andFilterWhere(['like', 'DescForAnalysis', $this->DescForAnalysis])
            ->andFilterWhere(['like', 'DescForCertificate', $this->DescForCertificate])
            ->andFilterWhere(['like', 'ShortStorageCondition', $this->ShortStorageCondition])
            ->andFilterWhere(['like', 'UserName', $this->UserName]);

        return $dataProvider;
    }
}
