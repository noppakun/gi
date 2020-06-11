<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Spec;

/**
 * SpecSearch represents the model behind the search form of `app\models\Spec`.
 */
class SpecSearch extends Spec
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Item_Number', 'SpecNo', 'EffectiveDate', 'SamplingMethod', 'Description', 'Material', 'Dimension', 'Package', 'Remark', 'SpecPicture', 'StorageCondition', 'ShortStorageCondition', 'SpecFile', 'DescForAnalysis', 'UserName', 'LastUpdate'], 'safe'],
            [['SpecCancel', 'ReviseNo'], 'integer'],
            [['RetestInterval'], 'number'],
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
        $query = Spec::find();

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
            'SpecCancel' => $this->SpecCancel,
            'RetestInterval' => $this->RetestInterval,
            'ReviseNo' => $this->ReviseNo,
            'LastUpdate' => $this->LastUpdate,
        ]);

        $query->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'SpecNo', $this->SpecNo])
            ->andFilterWhere(['like', 'SamplingMethod', $this->SamplingMethod])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Material', $this->Material])
            ->andFilterWhere(['like', 'Dimension', $this->Dimension])
            ->andFilterWhere(['like', 'Package', $this->Package])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'SpecPicture', $this->SpecPicture])
            ->andFilterWhere(['like', 'StorageCondition', $this->StorageCondition])
            ->andFilterWhere(['like', 'ShortStorageCondition', $this->ShortStorageCondition])
            ->andFilterWhere(['like', 'SpecFile', $this->SpecFile])
            ->andFilterWhere(['like', 'DescForAnalysis', $this->DescForAnalysis])
            ->andFilterWhere(['like', 'UserName', $this->UserName]);

        return $dataProvider;
    }
}
