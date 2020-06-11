<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DeleteLog;

/**
 * DeleteLogSearch represents the model behind the search form about `app\models\DeleteLog`.
 */
class DeleteLogSearch extends DeleteLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Delete_DESC', 'UserName', 'Item_Number', 'DocNo', 'Delete_Date', 'Ana_No'], 'safe'],
            [['Qty'], 'number'],
            [['id'], 'integer'],
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
        $query = DeleteLog::find();

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
            'Qty' => $this->Qty,
            'Delete_Date' => $this->Delete_Date,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'Delete_DESC', $this->Delete_DESC])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'DocNo', $this->DocNo])
            ->andFilterWhere(['like', 'Ana_No', $this->Ana_No]);

        return $dataProvider;
    }
}
