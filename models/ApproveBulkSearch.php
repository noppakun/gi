<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ApproveBulk;

/**
 * ApproveBulkSearch represents the model behind the search form of `app\models\ApproveBulk`.
 */
class ApproveBulkSearch extends ApproveBulk
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Docno'], 'integer'],
            [['Item_Number', 'FormulaNo', 'SpecNo', 'Ana_No', 'BatchNo', 'Uom', 'Mfg_Date', 'Exp_Date', 'Ana_Date', 'RegNo', 'Results', 'Remarks', 'Jobno', 'UserName', 'QA_ReceiveDate', 'QA_DeterDate', 'QA_ReleaseNo', 'QA_AnalysisDate'], 'safe'],
            [['BatchSize'], 'number'],
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
        $query = ApproveBulk::find();

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
            'Docno' => $this->Docno,
            'BatchSize' => $this->BatchSize,
            'Mfg_Date' => $this->Mfg_Date,
            'Exp_Date' => $this->Exp_Date,
            'Ana_Date' => $this->Ana_Date,
            'QA_ReceiveDate' => $this->QA_ReceiveDate,
            'QA_DeterDate' => $this->QA_DeterDate,
            'QA_AnalysisDate' => $this->QA_AnalysisDate,
        ]);

        $query->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'FormulaNo', $this->FormulaNo])
            ->andFilterWhere(['like', 'SpecNo', $this->SpecNo])
            ->andFilterWhere(['like', 'Ana_No', $this->Ana_No])
            ->andFilterWhere(['like', 'BatchNo', $this->BatchNo])
            ->andFilterWhere(['like', 'Uom', $this->Uom])
            ->andFilterWhere(['like', 'RegNo', $this->RegNo])
            ->andFilterWhere(['like', 'Results', $this->Results])
            ->andFilterWhere(['like', 'Remarks', $this->Remarks])
            ->andFilterWhere(['like', 'Jobno', $this->Jobno])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'QA_ReleaseNo', $this->QA_ReleaseNo]);

        return $dataProvider;
    }
}
