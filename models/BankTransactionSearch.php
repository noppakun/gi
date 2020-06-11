<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BankTransaction;

/**
 * BankTransactionSearch represents the model behind the search form about `app\models\BankTransaction`.
 */
class BankTransactionSearch extends BankTransaction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'BankTranType', 'VoucherNo', 'BankCode', 'TranDate', 'RefDoc', 'Remark', 'ChqNo', 'BankCode2', 'Supp_Number', 'Supp_Name', 'GIncome_Code', 'Income_Code', 'GExpend_Code', 'Expend_Code', 'TranDate2', 'BranchCode', 'expend_Accountcode', 'Account_PaymentWithHoldingTax', 'Income_AccountCode', 'AccountCode_Tax', 'VoucherNoRef', 'Inv_Number', 'Inv_date', 'TransferStatus', 'TaxID'], 'safe'],
            [['Amount', 'Charge', 'VatAmt', 'NetAmt', 'PaymentWithHoldingTax'], 'number'],
            [['BranchNo'], 'integer'],
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
        $query = BankTransaction::find();

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
            'TranDate' => $this->TranDate,
            'Amount' => $this->Amount,
            'Charge' => $this->Charge,
            'VatAmt' => $this->VatAmt,
            'NetAmt' => $this->NetAmt,
            'TranDate2' => $this->TranDate2,
            'PaymentWithHoldingTax' => $this->PaymentWithHoldingTax,
            'Inv_date' => $this->Inv_date,
            'BranchNo' => $this->BranchNo,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'BankTranType', $this->BankTranType])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'BankCode', $this->BankCode])
            ->andFilterWhere(['like', 'RefDoc', $this->RefDoc])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'ChqNo', $this->ChqNo])
            ->andFilterWhere(['like', 'BankCode2', $this->BankCode2])
            ->andFilterWhere(['like', 'Supp_Number', $this->Supp_Number])
            ->andFilterWhere(['like', 'Supp_Name', $this->Supp_Name])
            ->andFilterWhere(['like', 'GIncome_Code', $this->GIncome_Code])
            ->andFilterWhere(['like', 'Income_Code', $this->Income_Code])
            ->andFilterWhere(['like', 'GExpend_Code', $this->GExpend_Code])
            ->andFilterWhere(['like', 'Expend_Code', $this->Expend_Code])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'expend_Accountcode', $this->expend_Accountcode])
            ->andFilterWhere(['like', 'Account_PaymentWithHoldingTax', $this->Account_PaymentWithHoldingTax])
            ->andFilterWhere(['like', 'Income_AccountCode', $this->Income_AccountCode])
            ->andFilterWhere(['like', 'AccountCode_Tax', $this->AccountCode_Tax])
            ->andFilterWhere(['like', 'VoucherNoRef', $this->VoucherNoRef])
            ->andFilterWhere(['like', 'Inv_Number', $this->Inv_Number])
            ->andFilterWhere(['like', 'TransferStatus', $this->TransferStatus])
            ->andFilterWhere(['like', 'TaxID', $this->TaxID]);

        return $dataProvider;
    }
}
