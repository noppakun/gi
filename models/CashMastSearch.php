<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CashMast;

/**
 * CashmastSearch represents the model behind the search form about `app\models\CashMast`.
 */
class CashMastSearch extends CashMast
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'Type', 'VoucherNo', 'VoucherDate', 'Supp_Number', 'Cust_No', 'Remark', 'GIncome_Code', 'GExpend_Code', 'Income_Code', 'Expend_Code', 'CsCode', 'BranchCode', 'Inv_Number', 'Inv_date', 'Accnum', 'Accountcode_Discount', 'Accountcode_Discount_Reverse', 'UserName', 'LastUpdate', 'AccountCode_Lostliabilities', 'Account_PaymentWithHoldingTax', 'VoucherNoRef'], 'safe'],
            [['Discount', 'PaymentWithHoldingTax', 'TotalAmount', 'ChqTotalAmount', 'Discount_Reverse', 'Discount_Lostliabilities', 'VatAmt'], 'number'],
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
        $query = CashMast::find();

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
            'VoucherDate' => $this->VoucherDate,
            'Discount' => $this->Discount,
            'PaymentWithHoldingTax' => $this->PaymentWithHoldingTax,
            'TotalAmount' => $this->TotalAmount,
            'ChqTotalAmount' => $this->ChqTotalAmount,
            'Discount_Reverse' => $this->Discount_Reverse,
            'Inv_date' => $this->Inv_date,
            'LastUpdate' => $this->LastUpdate,
            'Discount_Lostliabilities' => $this->Discount_Lostliabilities,
            'VatAmt' => $this->VatAmt,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'Type', $this->Type])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'Supp_Number', $this->Supp_Number])
            ->andFilterWhere(['like', 'Cust_No', $this->Cust_No])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'GIncome_Code', $this->GIncome_Code])
            ->andFilterWhere(['like', 'GExpend_Code', $this->GExpend_Code])
            ->andFilterWhere(['like', 'Income_Code', $this->Income_Code])
            ->andFilterWhere(['like', 'Expend_Code', $this->Expend_Code])
            ->andFilterWhere(['like', 'CsCode', $this->CsCode])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'Inv_Number', $this->Inv_Number])
            ->andFilterWhere(['like', 'Accnum', $this->Accnum])
            ->andFilterWhere(['like', 'Accountcode_Discount', $this->Accountcode_Discount])
            ->andFilterWhere(['like', 'Accountcode_Discount_Reverse', $this->Accountcode_Discount_Reverse])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'AccountCode_Lostliabilities', $this->AccountCode_Lostliabilities])
            ->andFilterWhere(['like', 'Account_PaymentWithHoldingTax', $this->Account_PaymentWithHoldingTax])
            ->andFilterWhere(['like', 'VoucherNoRef', $this->VoucherNoRef]);

        return $dataProvider;
    }
}
