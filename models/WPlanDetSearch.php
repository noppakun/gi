<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WPlanDet;

/**
 * WPlanDetSearch represents the model behind the search form about `app\models\WPlanDet`.
 */
class WPlanDetSearch extends WPlanDet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JobNo', 'Order_No', 'Item_Number', 'StartDateTime', 'StopDateTime', 'Priority', 'JobStatus', 'Rlse_Date', 'Item_Type', 'ProcessRemark', 'TransferRecord1', 'TransferRecord2', 'TransferRecord3', 'EffectiveDate', 'MachCode', 'ReleasedNo', 'RealStartDateTime', 'RealStopDateTime', 'UserName', 'Certificate', 'Conclusion', 'Remark', 'JobRemark', 'QA_StartDateTime', 'QA_StopDateTime', 'QA_MachCode', 'Formula_No', 'LastUpdateSchedule', 'StopDateTimeIncludeClearDoc', 'Job_QtyFixedCostUom', 'Remark2', 'PrintDocStatus'], 'safe'],
            [['JobQty', 'Rlse_Qty', 'HourPaid', 'ManHour', 'DirectLabor', 'VariableCost', 'FixedCost', 'Job_QtyFixedCost', 'HourPaid_W', 'ManHour_W', 'HourPaid_C', 'ManHour_C'], 'number'],
            [['Operators', 'PrintJob', 'ConfirmSchedule', 'SaveJobProductCost', 'Operators_W', 'Operators_C'], 'integer'],
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
        
        //\app\components\XLib::xprint_r($params);        
        
        
        $query = WPlanDet::find();
        if ( isset($params['BatchPackingRecord'])){
            $query->andFilterWhere([
                'Item_Type' => 'F',  // finish goods (885~)                
                //'JobStatus' =>'C'   // close
            ])            
            ->andFilterWhere(['between', 'year(StartDateTime)', $params['SelectForm']['year'], $params['SelectForm']['year2']]);

            // ->orderBy([
            //     'CONVERT(VARCHAR(10), StartDateTime, 120)' => SORT_DESC,
            //     'Order_No'=>SORT_ASC,
            //     'Item_Number'=>SORT_ASC,
            // ]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['StartDateTime'=> SORT_DESC]]
        ]);
        //\app\components\XLib::xprint_r($params);        
        
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'JobQty' => $this->JobQty,
            // 'StartDateTime' => $this->StartDateTime,
            'StopDateTime' => $this->StopDateTime,
            'Rlse_Qty' => $this->Rlse_Qty,
            'Rlse_Date' => $this->Rlse_Date,
            'EffectiveDate' => $this->EffectiveDate,
            'RealStartDateTime' => $this->RealStartDateTime,
            'RealStopDateTime' => $this->RealStopDateTime,
            'Operators' => $this->Operators,
            'HourPaid' => $this->HourPaid,
            'ManHour' => $this->ManHour,
            'PrintJob' => $this->PrintJob,
            'QA_StartDateTime' => $this->QA_StartDateTime,
            'QA_StopDateTime' => $this->QA_StopDateTime,
            'LastUpdateSchedule' => $this->LastUpdateSchedule,
            'StopDateTimeIncludeClearDoc' => $this->StopDateTimeIncludeClearDoc,
            'DirectLabor' => $this->DirectLabor,
            'VariableCost' => $this->VariableCost,
            'FixedCost' => $this->FixedCost,
            'ConfirmSchedule' => $this->ConfirmSchedule,
            'Job_QtyFixedCost' => $this->Job_QtyFixedCost,
            'SaveJobProductCost' => $this->SaveJobProductCost,
            'Operators_W' => $this->Operators_W,
            'HourPaid_W' => $this->HourPaid_W,
            'ManHour_W' => $this->ManHour_W,
            'Operators_C' => $this->Operators_C,
            'HourPaid_C' => $this->HourPaid_C,
            'ManHour_C' => $this->ManHour_C,
        ]);

        $query
            ->andFilterWhere(['like', 'CONVERT(varchar(10), StartDateTime, 105)', $this->StartDateTime])
            ->andFilterWhere(['like', 'JobNo', $this->JobNo])
            ->andFilterWhere(['like', 'Order_No', $this->Order_No])
            ->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'Priority', $this->Priority])
            ->andFilterWhere(['like', 'JobStatus', $this->JobStatus])
            ->andFilterWhere(['like', 'Item_Type', $this->Item_Type])
            ->andFilterWhere(['like', 'ProcessRemark', $this->ProcessRemark])
            ->andFilterWhere(['like', 'TransferRecord1', $this->TransferRecord1])
            ->andFilterWhere(['like', 'TransferRecord2', $this->TransferRecord2])
            ->andFilterWhere(['like', 'TransferRecord3', $this->TransferRecord3])
            ->andFilterWhere(['like', 'MachCode', $this->MachCode])
            ->andFilterWhere(['like', 'ReleasedNo', $this->ReleasedNo])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'Certificate', $this->Certificate])
            ->andFilterWhere(['like', 'Conclusion', $this->Conclusion])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'JobRemark', $this->JobRemark])
            ->andFilterWhere(['like', 'QA_MachCode', $this->QA_MachCode])
            ->andFilterWhere(['like', 'Formula_No', $this->Formula_No])
            ->andFilterWhere(['like', 'Job_QtyFixedCostUom', $this->Job_QtyFixedCostUom])
            ->andFilterWhere(['like', 'Remark2', $this->Remark2])
            ->andFilterWhere(['like', 'PrintDocStatus', $this->PrintDocStatus]);

        return $dataProvider;
    }
}
