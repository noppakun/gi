<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Company;

/**
 * CompanySearch represents the model behind the search form of `app\models\Company`.
 */
class CompanySearch extends Company
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'CompanyName', 'Addr1', 'Addr2', 'Addr3', 'TelePhone', 'Fax', 'TaxID', 'CompanyEngName', 'AddrE1', 'AddrE2', 'AddrE3', 'StockMethod', 'CompanyLogo', 'PrintInvoiceFormNo', 'PrintPOFormNo', 'PrintARBillFormNo', 'PrintAPBillFormNo', 'PrintCNFormNo', 'PrintSpecFormNo', 'PrintSpecRawFormNo', 'PrintSpecFinishGoodsFormNo', 'PrintSpecIntermediateFormNo', 'PrintSpecBulkFormNo', 'PrintSpecToothBrushFormNo', 'PrintDNRFormNo', 'PrintComplaintFormNo', 'PrintCheckSpecFormNo', 'Acc_Cash', 'Acc_PettyCash', 'Acc_Receivable', 'Acc_PostDateCheque', 'Acc_Inventory', 'Acc_PrepaidIncomeTax', 'Acc_InputTax', 'Acc_InputTaxNotYetDue', 'Acc_DepositPayment', 'Acc_Liabilities', 'Acc_PrepaidCheque', 'Acc_PaymentWithHoldingTax', 'Acc_PaymentWithHoldingTax2', 'Acc_PaymentWithHoldingTax3', 'Acc_PaymentWithHoldingTax4', 'Acc_PaymentWithHoldingTax5', 'Acc_AccuredPaymentWithHoldingTax', 'Acc_OutputTax', 'Acc_OutputTaxNotYetDue', 'Acc_DepositReceived', 'Acc_SaleDebit', 'Acc_SaleCredit', 'Acc_SaleReturn', 'Acc_SaleDiscount', 'Acc_InterestIncome', 'Acc_BankIncome', 'Acc_OtherIncome', 'Acc_CostOfGoodsSold', 'Acc_Purchase', 'Acc_PurchaseReturn', 'Acc_PurchaseDiscount', 'Acc_InterestExpense', 'Acc_BankCharge', 'Acc_LostLiabilities', 'Acc_OtherExpense', 'Acc_RetainedEarning', 'Acc_RegalReserve', 'PrintJobFormNo', 'Acc_InputTaxNotClaim', 'PrintInventoryFormno', 'PrintSaleFormNo', 'PrintCloseJobSheetFormNo', 'PrintAwaitingFormNo', 'PrintPendingFormNo', 'PrintAPCNFormNo', 'PrintTagForSampleFormNo', 'PrintInvoiceDOFormNo', 'PrintQAAnalysisCertFormNo', 'PrintQAAnalysisReportFormNo', 'BranchCode', 'Acc_ReceivableRevenue', 'Acc_AccruedIncome', 'PayForName', 'Acc_AdvancePayment', 'Acc_AdvancePayment_Credit'], 'safe'],
            [['VatPercent', 'LimitOverOrderRate', 'DirectLabor', 'TopMargin_Cheque'], 'number'],
            [['CheckMasterFormula', 'Connect_Sale', 'Connect_GL', 'PrintInvoiceHeader', 'PrintPOHeader', 'PrintCNHeader', 'PrintDateTimeInVoucher', 'CheckSpecQCApproved', 'CheckInvOverridePrice', 'CheckConfirmJob', 'Month_Mfg_Date', 'Month_Exp_Date', 'AutoPaymentCash', 'CheckCostCenter', 'CheckAutoCloseSaleOrder', 'EditInvoiceDays', 'CheckAutoClosePurchaseOrder', 'CheckPrintInvNotAtNow', 'CheckDel_EditInvoice', 'CalcFixedCostByManHour'], 'integer'],
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
        $query = Company::find();
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
     
            'sort' => [
                'defaultOrder' => [
                    'CompanyCode' => SORT_ASC, 
                ]
            ],            
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'VatPercent' => $this->VatPercent,
            'LimitOverOrderRate' => $this->LimitOverOrderRate,
            'CheckMasterFormula' => $this->CheckMasterFormula,
            'Connect_Sale' => $this->Connect_Sale,
            'Connect_GL' => $this->Connect_GL,
            'DirectLabor' => $this->DirectLabor,
            'PrintInvoiceHeader' => $this->PrintInvoiceHeader,
            'PrintPOHeader' => $this->PrintPOHeader,
            'PrintCNHeader' => $this->PrintCNHeader,
            'PrintDateTimeInVoucher' => $this->PrintDateTimeInVoucher,
            'TopMargin_Cheque' => $this->TopMargin_Cheque,
            'CheckSpecQCApproved' => $this->CheckSpecQCApproved,
            'CheckInvOverridePrice' => $this->CheckInvOverridePrice,
            'CheckConfirmJob' => $this->CheckConfirmJob,
            'Month_Mfg_Date' => $this->Month_Mfg_Date,
            'Month_Exp_Date' => $this->Month_Exp_Date,
            'AutoPaymentCash' => $this->AutoPaymentCash,
            'CheckCostCenter' => $this->CheckCostCenter,
            'CheckAutoCloseSaleOrder' => $this->CheckAutoCloseSaleOrder,
            'EditInvoiceDays' => $this->EditInvoiceDays,
            'CheckAutoClosePurchaseOrder' => $this->CheckAutoClosePurchaseOrder,
            'CheckPrintInvNotAtNow' => $this->CheckPrintInvNotAtNow,
            'CheckDel_EditInvoice' => $this->CheckDel_EditInvoice,
            'CalcFixedCostByManHour' => $this->CalcFixedCostByManHour,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'CompanyName', $this->CompanyName])
            ->andFilterWhere(['like', 'Addr1', $this->Addr1])
            ->andFilterWhere(['like', 'Addr2', $this->Addr2])
            ->andFilterWhere(['like', 'Addr3', $this->Addr3])
            ->andFilterWhere(['like', 'TelePhone', $this->TelePhone])
            ->andFilterWhere(['like', 'Fax', $this->Fax])
            ->andFilterWhere(['like', 'TaxID', $this->TaxID])
            ->andFilterWhere(['like', 'CompanyEngName', $this->CompanyEngName])
            ->andFilterWhere(['like', 'AddrE1', $this->AddrE1])
            ->andFilterWhere(['like', 'AddrE2', $this->AddrE2])
            ->andFilterWhere(['like', 'AddrE3', $this->AddrE3])
            ->andFilterWhere(['like', 'StockMethod', $this->StockMethod])
            ->andFilterWhere(['like', 'CompanyLogo', $this->CompanyLogo])
            ->andFilterWhere(['like', 'PrintInvoiceFormNo', $this->PrintInvoiceFormNo])
            ->andFilterWhere(['like', 'PrintPOFormNo', $this->PrintPOFormNo])
            ->andFilterWhere(['like', 'PrintARBillFormNo', $this->PrintARBillFormNo])
            ->andFilterWhere(['like', 'PrintAPBillFormNo', $this->PrintAPBillFormNo])
            ->andFilterWhere(['like', 'PrintCNFormNo', $this->PrintCNFormNo])
            ->andFilterWhere(['like', 'PrintSpecFormNo', $this->PrintSpecFormNo])
            ->andFilterWhere(['like', 'PrintSpecRawFormNo', $this->PrintSpecRawFormNo])
            ->andFilterWhere(['like', 'PrintSpecFinishGoodsFormNo', $this->PrintSpecFinishGoodsFormNo])
            ->andFilterWhere(['like', 'PrintSpecIntermediateFormNo', $this->PrintSpecIntermediateFormNo])
            ->andFilterWhere(['like', 'PrintSpecBulkFormNo', $this->PrintSpecBulkFormNo])
            ->andFilterWhere(['like', 'PrintSpecToothBrushFormNo', $this->PrintSpecToothBrushFormNo])
            ->andFilterWhere(['like', 'PrintDNRFormNo', $this->PrintDNRFormNo])
            ->andFilterWhere(['like', 'PrintComplaintFormNo', $this->PrintComplaintFormNo])
            ->andFilterWhere(['like', 'PrintCheckSpecFormNo', $this->PrintCheckSpecFormNo])
            ->andFilterWhere(['like', 'Acc_Cash', $this->Acc_Cash])
            ->andFilterWhere(['like', 'Acc_PettyCash', $this->Acc_PettyCash])
            ->andFilterWhere(['like', 'Acc_Receivable', $this->Acc_Receivable])
            ->andFilterWhere(['like', 'Acc_PostDateCheque', $this->Acc_PostDateCheque])
            ->andFilterWhere(['like', 'Acc_Inventory', $this->Acc_Inventory])
            ->andFilterWhere(['like', 'Acc_PrepaidIncomeTax', $this->Acc_PrepaidIncomeTax])
            ->andFilterWhere(['like', 'Acc_InputTax', $this->Acc_InputTax])
            ->andFilterWhere(['like', 'Acc_InputTaxNotYetDue', $this->Acc_InputTaxNotYetDue])
            ->andFilterWhere(['like', 'Acc_DepositPayment', $this->Acc_DepositPayment])
            ->andFilterWhere(['like', 'Acc_Liabilities', $this->Acc_Liabilities])
            ->andFilterWhere(['like', 'Acc_PrepaidCheque', $this->Acc_PrepaidCheque])
            ->andFilterWhere(['like', 'Acc_PaymentWithHoldingTax', $this->Acc_PaymentWithHoldingTax])
            ->andFilterWhere(['like', 'Acc_PaymentWithHoldingTax2', $this->Acc_PaymentWithHoldingTax2])
            ->andFilterWhere(['like', 'Acc_PaymentWithHoldingTax3', $this->Acc_PaymentWithHoldingTax3])
            ->andFilterWhere(['like', 'Acc_PaymentWithHoldingTax4', $this->Acc_PaymentWithHoldingTax4])
            ->andFilterWhere(['like', 'Acc_PaymentWithHoldingTax5', $this->Acc_PaymentWithHoldingTax5])
            ->andFilterWhere(['like', 'Acc_AccuredPaymentWithHoldingTax', $this->Acc_AccuredPaymentWithHoldingTax])
            ->andFilterWhere(['like', 'Acc_OutputTax', $this->Acc_OutputTax])
            ->andFilterWhere(['like', 'Acc_OutputTaxNotYetDue', $this->Acc_OutputTaxNotYetDue])
            ->andFilterWhere(['like', 'Acc_DepositReceived', $this->Acc_DepositReceived])
            ->andFilterWhere(['like', 'Acc_SaleDebit', $this->Acc_SaleDebit])
            ->andFilterWhere(['like', 'Acc_SaleCredit', $this->Acc_SaleCredit])
            ->andFilterWhere(['like', 'Acc_SaleReturn', $this->Acc_SaleReturn])
            ->andFilterWhere(['like', 'Acc_SaleDiscount', $this->Acc_SaleDiscount])
            ->andFilterWhere(['like', 'Acc_InterestIncome', $this->Acc_InterestIncome])
            ->andFilterWhere(['like', 'Acc_BankIncome', $this->Acc_BankIncome])
            ->andFilterWhere(['like', 'Acc_OtherIncome', $this->Acc_OtherIncome])
            ->andFilterWhere(['like', 'Acc_CostOfGoodsSold', $this->Acc_CostOfGoodsSold])
            ->andFilterWhere(['like', 'Acc_Purchase', $this->Acc_Purchase])
            ->andFilterWhere(['like', 'Acc_PurchaseReturn', $this->Acc_PurchaseReturn])
            ->andFilterWhere(['like', 'Acc_PurchaseDiscount', $this->Acc_PurchaseDiscount])
            ->andFilterWhere(['like', 'Acc_InterestExpense', $this->Acc_InterestExpense])
            ->andFilterWhere(['like', 'Acc_BankCharge', $this->Acc_BankCharge])
            ->andFilterWhere(['like', 'Acc_LostLiabilities', $this->Acc_LostLiabilities])
            ->andFilterWhere(['like', 'Acc_OtherExpense', $this->Acc_OtherExpense])
            ->andFilterWhere(['like', 'Acc_RetainedEarning', $this->Acc_RetainedEarning])
            ->andFilterWhere(['like', 'Acc_RegalReserve', $this->Acc_RegalReserve])
            ->andFilterWhere(['like', 'PrintJobFormNo', $this->PrintJobFormNo])
            ->andFilterWhere(['like', 'Acc_InputTaxNotClaim', $this->Acc_InputTaxNotClaim])
            ->andFilterWhere(['like', 'PrintInventoryFormno', $this->PrintInventoryFormno])
            ->andFilterWhere(['like', 'PrintSaleFormNo', $this->PrintSaleFormNo])
            ->andFilterWhere(['like', 'PrintCloseJobSheetFormNo', $this->PrintCloseJobSheetFormNo])
            ->andFilterWhere(['like', 'PrintAwaitingFormNo', $this->PrintAwaitingFormNo])
            ->andFilterWhere(['like', 'PrintPendingFormNo', $this->PrintPendingFormNo])
            ->andFilterWhere(['like', 'PrintAPCNFormNo', $this->PrintAPCNFormNo])
            ->andFilterWhere(['like', 'PrintTagForSampleFormNo', $this->PrintTagForSampleFormNo])
            ->andFilterWhere(['like', 'PrintInvoiceDOFormNo', $this->PrintInvoiceDOFormNo])
            ->andFilterWhere(['like', 'PrintQAAnalysisCertFormNo', $this->PrintQAAnalysisCertFormNo])
            ->andFilterWhere(['like', 'PrintQAAnalysisReportFormNo', $this->PrintQAAnalysisReportFormNo])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'Acc_ReceivableRevenue', $this->Acc_ReceivableRevenue])
            ->andFilterWhere(['like', 'Acc_AccruedIncome', $this->Acc_AccruedIncome])
            ->andFilterWhere(['like', 'PayForName', $this->PayForName])
            ->andFilterWhere(['like', 'Acc_AdvancePayment', $this->Acc_AdvancePayment])
            ->andFilterWhere(['like', 'Acc_AdvancePayment_Credit', $this->Acc_AdvancePayment_Credit]);

        return $dataProvider;
    }
}
