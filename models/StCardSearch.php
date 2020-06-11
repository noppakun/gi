<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StCard;

/**
 * StcardSearch represents the model behind the search form about `app\models\Stcard`.
 */
class StCardSearch extends StCard
{
    public $DocTypeDesc;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'DocType', 'VoucherNo', 'Item_Number', 'WhCode', 'Location', 'Ana_No', 'Item_Desc', 'AccountCode', 'CsCode', 'Status', 'TimeRecord', 'UserName', 'WorkStart', 'WorkStop', 'QA_StartDateTime', 'QA_StopDateTime', 'QA_MachCode', 'QA_ApvDate', 'MachCode', 'Item_Uom', 'WantQCDate', 'EmployeeCode', 'KpiDte2', 'KpiDte1'], 'safe'],
            [['Recv_Qty', 'Issue_Qty', 'UnitPrice', 'SumPrice', 'Tare_Weight'], 'number'],
            [['Batch', 'Checker_Status'], 'integer'],
            [['DocTypeDesc'], 'safe'],

            
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
        $query = StCard::find();
        $query->joinWith(['docType_ref']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['DocTypeDesc'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['doctype.DocTypeDesc' => SORT_ASC],
            'desc' => ['doctype.DocTypeDesc' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Recv_Qty' => $this->Recv_Qty,
            'Issue_Qty' => $this->Issue_Qty,
            'UnitPrice' => $this->UnitPrice,
            'SumPrice' => $this->SumPrice,
            'Batch' => $this->Batch,
            'TimeRecord' => $this->TimeRecord,
            //'WorkStart' => $this->WorkStart,
            'WorkStop' => $this->WorkStop,
            'QA_StartDateTime' => $this->QA_StartDateTime,
            'QA_StopDateTime' => $this->QA_StopDateTime,
            'QA_ApvDate' => $this->QA_ApvDate,
            'WantQCDate' => $this->WantQCDate,
            'Checker_Status' => $this->Checker_Status,
            'Tare_Weight' => $this->Tare_Weight,
            'KpiDte2' => $this->KpiDte2,
            'KpiDte1' => $this->KpiDte1,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', "CONVERT(varchar(10), WorkStart, 105)+' '+CONVERT(varchar(10), WorkStart, 108)", $this->WorkStart])           
            ->andFilterWhere(['like', 'stcard.DocType', $this->DocType])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'WhCode', $this->WhCode])
            ->andFilterWhere(['like', 'Location', $this->Location])
            ->andFilterWhere(['like', 'Ana_No', $this->Ana_No])
            ->andFilterWhere(['like', 'Item_Desc', $this->Item_Desc])
            ->andFilterWhere(['like', 'AccountCode', $this->AccountCode])
            ->andFilterWhere(['like', 'CsCode', $this->CsCode])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'QA_MachCode', $this->QA_MachCode])
            ->andFilterWhere(['like', 'MachCode', $this->MachCode])
            ->andFilterWhere(['like', 'Item_Uom', $this->Item_Uom])
            ->andFilterWhere(['like', 'EmployeeCode', $this->EmployeeCode])
            ->andFilterWhere(['like', 'doctype.DocTypeDesc', $this->DocTypeDesc]);

        return $dataProvider;
    }
}
