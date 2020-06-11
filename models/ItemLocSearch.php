<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ItemLoc;

/**
 * ItemLocSearch represents the model behind the search form about `app\models\ItemLoc`.
 */
class ItemLocSearch extends ItemLoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Item_Number', 'WhCode', 'Location_number', 'Ana_No', 'Mfg_Date', 'Exp_Date', 'Status', 'Bin', 'Remark', 'Remark_General', 'LastTest_Date', 'EffectiveDate', 'LastUpdateBin', 'ReportNo'], 'safe'],
            [['Ana_Qty', 'Issue', 'Receipt', 'UnitPrice', 'SumPrice', 'Quarantine', 'SaleReserved', 'Waste_Qty', 'Defective_Qty', 'Good_Qty', 'NotIssueQty', 'St_qty'], 'number'],
            [['loc_typ'], 'integer'],
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
        $query = ItemLoc::find();

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
            'Ana_Qty' => $this->Ana_Qty,
            'Mfg_Date' => $this->Mfg_Date,
            'Exp_Date' => $this->Exp_Date,
            'Issue' => $this->Issue,
            'Receipt' => $this->Receipt,
            'UnitPrice' => $this->UnitPrice,
            'SumPrice' => $this->SumPrice,
            'Quarantine' => $this->Quarantine,
            'LastTest_Date' => $this->LastTest_Date,
            'SaleReserved' => $this->SaleReserved,
            'EffectiveDate' => $this->EffectiveDate,
            'Waste_Qty' => $this->Waste_Qty,
            'Defective_Qty' => $this->Defective_Qty,
            'Good_Qty' => $this->Good_Qty,
            'LastUpdateBin' => $this->LastUpdateBin,
            'NotIssueQty' => $this->NotIssueQty,
            'loc_typ' => $this->loc_typ,
            'St_qty' => $this->St_qty,
        ]);

        $query->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'WhCode', $this->WhCode])
            ->andFilterWhere(['like', 'Location_number', $this->Location_number])
            ->andFilterWhere(['like', 'Ana_No', $this->Ana_No])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'Bin', $this->Bin])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'Remark_General', $this->Remark_General])
            ->andFilterWhere(['like', 'ReportNo', $this->ReportNo]);

        return $dataProvider;
    }
    public function onhandSearchByItem($item_number,$wh_code){

        $query = ItemLoc::find();
        $query->andFilterWhere([
                    'item_number' => $item_number,
                    'whcode'=>$wh_code,
                    //'status'=>'Y'
                    ])
                ->andFilterWhere(['<>', 'Ana_Qty', 0]);
                

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

 

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
 

        return $dataProvider;
            
    }
}
