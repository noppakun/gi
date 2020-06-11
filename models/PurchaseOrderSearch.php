<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PurchaseOrder;

/**
 * PurchaseOrderSearch represents the model behind the search form about `app\models\PurchaseOrder`.
 */
class PurchaseOrderSearch extends PurchaseOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'Order_Number', 'DeptCode', 'Supp_Number', 'Pr_Number', 'Shipto_Addr1', 'Shipto_Addr2', 'Currency_Type', 'Remark1', 'Remark2', 'Remark3', 'Remarks', 'Order_date', 'Buyers', 'Terms', 'Close_Date', 'Revision_Date', 'Vat_Type', 'ForWork', 'DivisionCode', 'ShipMent', 'UserName', 'LastUpdate', 'UserName_Approve', 'DateTime_Approve'], 'safe'],
            [['Po_Issue', 'Open_Close', 'Revision_No', 'PO_Approve'], 'integer'],
            [['Service', 'Insurance', 'Carriage', 'Vat_Percent', 'Vat_Amt', 'Disc_Percent', 'Disc_Cash', 'LimitOverOrderRate', 'currency_Rate', 'Amount', 'TotalAmount'], 'number'],
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
        $query = PurchaseOrder::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Order_date' => $this->Order_date,
            'Po_Issue' => $this->Po_Issue,
            'Open_Close' => $this->Open_Close,
            'Close_Date' => $this->Close_Date,
            'Service' => $this->Service,
            'Insurance' => $this->Insurance,
            'Carriage' => $this->Carriage,
            'Vat_Percent' => $this->Vat_Percent,
            'Vat_Amt' => $this->Vat_Amt,
            'Disc_Percent' => $this->Disc_Percent,
            'Disc_Cash' => $this->Disc_Cash,
            'Revision_No' => $this->Revision_No,
            'Revision_Date' => $this->Revision_Date,
            'LimitOverOrderRate' => $this->LimitOverOrderRate,
            'currency_Rate' => $this->currency_Rate,
            'Amount' => $this->Amount,
            'TotalAmount' => $this->TotalAmount,
            'LastUpdate' => $this->LastUpdate,
            'PO_Approve' => $this->PO_Approve,
            'DateTime_Approve' => $this->DateTime_Approve,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'Order_Number', $this->Order_Number])
            ->andFilterWhere(['like', 'DeptCode', $this->DeptCode])
            ->andFilterWhere(['like', 'Supp_Number', $this->Supp_Number])
            ->andFilterWhere(['like', 'Pr_Number', $this->Pr_Number])
            ->andFilterWhere(['like', 'Shipto_Addr1', $this->Shipto_Addr1])
            ->andFilterWhere(['like', 'Shipto_Addr2', $this->Shipto_Addr2])
            ->andFilterWhere(['like', 'Currency_Type', $this->Currency_Type])
            ->andFilterWhere(['like', 'Remark1', $this->Remark1])
            ->andFilterWhere(['like', 'Remark2', $this->Remark2])
            ->andFilterWhere(['like', 'Remark3', $this->Remark3])
            ->andFilterWhere(['like', 'Remarks', $this->Remarks])
            ->andFilterWhere(['like', 'Buyers', $this->Buyers])
            ->andFilterWhere(['like', 'Terms', $this->Terms])
            ->andFilterWhere(['like', 'Vat_Type', $this->Vat_Type])
            ->andFilterWhere(['like', 'ForWork', $this->ForWork])
            ->andFilterWhere(['like', 'DivisionCode', $this->DivisionCode])
            ->andFilterWhere(['like', 'ShipMent', $this->ShipMent])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'UserName_Approve', $this->UserName_Approve]);

        return $dataProvider;
    }
}
