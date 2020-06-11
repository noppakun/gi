<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dock;

/**
 * DockSearch represents the model behind the search form about `app\models\Dock`.
 */
class DockSearch extends Dock
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Dock_Number', 'Seq_Number'], 'integer'],
            [['CompanyCode', 'VoucherNo', 'Do_Number', 'Order_Number', 'Item_Number', 'Vessel', 'Awb', 'Inv', 'Inv_Date', 'Mfg_date', 'Exp_Date', 'Due_Date', 'Recd_Date', 'Acc_Date', 'WhCode', 'Loc_Number', 'Ana_No', 'Uom', 'Supplier_Lot', 'Remark', 'PackDetail', 'Dock_Print', 'Dock_Status', 'UserName', 'Remark_Approve', 'QA_StartDateTime', 'QA_StopDateTime', 'QA_MachCode', 'EffectiveDate', 'RecvDocDate', 'BranchCode', 'SpecNo', 'UserName_Approve', 'Score', 'Score_PH', 'Kpidte1', 'KpiDte2'], 'safe'],
            [['Recd_Qty', 'Acc_Qty', 'Rej_Qty', 'UnitPrice', 'SumPrice'], 'number'],
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
        $query = Dock::find();

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
            'Dock_Number' => $this->Dock_Number,
            'Inv_Date' => $this->Inv_Date,
            'Recd_Qty' => $this->Recd_Qty,
            'Acc_Qty' => $this->Acc_Qty,
            'Mfg_date' => $this->Mfg_date,
            'Exp_Date' => $this->Exp_Date,
            'Rej_Qty' => $this->Rej_Qty,
            'Due_Date' => $this->Due_Date,
            'Recd_Date' => $this->Recd_Date,
            'Acc_Date' => $this->Acc_Date,
            'UnitPrice' => $this->UnitPrice,
            'SumPrice' => $this->SumPrice,
            'Seq_Number' => $this->Seq_Number,
            'QA_StartDateTime' => $this->QA_StartDateTime,
            'QA_StopDateTime' => $this->QA_StopDateTime,
            'EffectiveDate' => $this->EffectiveDate,
            'RecvDocDate' => $this->RecvDocDate,
            'Kpidte1' => $this->Kpidte1,
            'KpiDte2' => $this->KpiDte2,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'Do_Number', $this->Do_Number])
            ->andFilterWhere(['like', 'Order_Number', $this->Order_Number])
            ->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'Vessel', $this->Vessel])
            ->andFilterWhere(['like', 'Awb', $this->Awb])
            ->andFilterWhere(['like', 'Inv', $this->Inv])
            ->andFilterWhere(['like', 'WhCode', $this->WhCode])
            ->andFilterWhere(['like', 'Loc_Number', $this->Loc_Number])
            ->andFilterWhere(['like', 'Ana_No', $this->Ana_No])
            ->andFilterWhere(['like', 'Uom', $this->Uom])
            ->andFilterWhere(['like', 'Supplier_Lot', $this->Supplier_Lot])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'PackDetail', $this->PackDetail])
            ->andFilterWhere(['like', 'Dock_Print', $this->Dock_Print])
            ->andFilterWhere(['like', 'Dock_Status', $this->Dock_Status])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'Remark_Approve', $this->Remark_Approve])
            ->andFilterWhere(['like', 'QA_MachCode', $this->QA_MachCode])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'SpecNo', $this->SpecNo])
            ->andFilterWhere(['like', 'UserName_Approve', $this->UserName_Approve])
            ->andFilterWhere(['like', 'Score', $this->Score])
            ->andFilterWhere(['like', 'Score_PH', $this->Score_PH]);

        return $dataProvider;
    }
}
