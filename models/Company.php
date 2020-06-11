<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Company".
 *
 * @property string $CompanyCode
 * @property string $CompanyName
 * @property string $Addr1
 * @property string $Addr2
 * @property string $Addr3
 * @property string $TelePhone
 * @property string $Fax
 * @property string $TaxID
 * @property string $CompanyEngName
 * @property string $AddrE1
 * @property string $AddrE2
 * @property string $AddrE3
 * @property string $VatPercent
 * @property string $LimitOverOrderRate
 * @property int $CheckMasterFormula
 * @property int $Connect_Sale
 * @property int $Connect_GL
 * @property string $StockMethod
 * @property string $DirectLabor
 * @property resource $CompanyLogo
 * @property int $PrintInvoiceHeader
 * @property int $PrintPOHeader
 * @property int $PrintCNHeader
 * @property string $PrintInvoiceFormNo
 * @property string $PrintPOFormNo
 * @property int $PrintDateTimeInVoucher
 * @property string $PrintARBillFormNo
 * @property string $PrintAPBillFormNo
 * @property string $PrintCNFormNo
 * @property string $PrintSpecFormNo
 * @property string $PrintSpecRawFormNo
 * @property string $PrintSpecFinishGoodsFormNo
 * @property string $PrintSpecIntermediateFormNo
 * @property string $PrintSpecBulkFormNo
 * @property string $PrintSpecToothBrushFormNo
 * @property string $PrintDNRFormNo
 * @property string $PrintComplaintFormNo
 * @property string $PrintCheckSpecFormNo
 * @property string $Acc_Cash
 * @property string $Acc_PettyCash
 * @property string $Acc_Receivable
 * @property string $Acc_PostDateCheque
 * @property string $Acc_Inventory
 * @property string $Acc_PrepaidIncomeTax
 * @property string $Acc_InputTax
 * @property string $Acc_InputTaxNotYetDue
 * @property string $Acc_DepositPayment
 * @property string $Acc_Liabilities
 * @property string $Acc_PrepaidCheque
 * @property string $Acc_PaymentWithHoldingTax
 * @property string $Acc_PaymentWithHoldingTax2
 * @property string $Acc_PaymentWithHoldingTax3
 * @property string $Acc_PaymentWithHoldingTax4
 * @property string $Acc_PaymentWithHoldingTax5
 * @property string $Acc_AccuredPaymentWithHoldingTax
 * @property string $Acc_OutputTax
 * @property string $Acc_OutputTaxNotYetDue
 * @property string $Acc_DepositReceived
 * @property string $Acc_SaleDebit
 * @property string $Acc_SaleCredit
 * @property string $Acc_SaleReturn
 * @property string $Acc_SaleDiscount
 * @property string $Acc_InterestIncome
 * @property string $Acc_BankIncome
 * @property string $Acc_OtherIncome
 * @property string $Acc_CostOfGoodsSold
 * @property string $Acc_Purchase
 * @property string $Acc_PurchaseReturn
 * @property string $Acc_PurchaseDiscount
 * @property string $Acc_InterestExpense
 * @property string $Acc_BankCharge
 * @property string $Acc_LostLiabilities
 * @property string $Acc_OtherExpense
 * @property string $Acc_RetainedEarning
 * @property string $Acc_RegalReserve
 * @property string $PrintJobFormNo
 * @property string $TopMargin_Cheque
 * @property string $Acc_InputTaxNotClaim
 * @property string $PrintInventoryFormno
 * @property string $PrintSaleFormNo
 * @property int $CheckSpecQCApproved
 * @property string $PrintCloseJobSheetFormNo
 * @property string $PrintAwaitingFormNo
 * @property string $PrintPendingFormNo
 * @property string $PrintAPCNFormNo
 * @property string $PrintTagForSampleFormNo
 * @property string $PrintInvoiceDOFormNo
 * @property int $CheckInvOverridePrice
 * @property string $PrintQAAnalysisCertFormNo
 * @property string $PrintQAAnalysisReportFormNo
 * @property int $CheckConfirmJob
 * @property int $Month_Mfg_Date
 * @property int $Month_Exp_Date
 * @property int $AutoPaymentCash
 * @property int $CheckCostCenter
 * @property int $CheckAutoCloseSaleOrder
 * @property int $EditInvoiceDays
 * @property int $CheckAutoClosePurchaseOrder
 * @property string $BranchCode
 * @property int $CheckPrintInvNotAtNow
 * @property int $CheckDel_EditInvoice
 * @property int $CalcFixedCostByManHour
 * @property string $Acc_ReceivableRevenue
 * @property string $Acc_AccruedIncome
 * @property string $PayForName
 * @property string $Acc_AdvancePayment
 * @property string $Acc_AdvancePayment_Credit
 */
class Company extends \yii\db\ActiveRecord
{
 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'CompanyName'], 'required'],
            [['CompanyCode', 'CompanyName', 'Addr1', 'Addr2', 'Addr3', 'TelePhone', 'Fax', 'TaxID', 'CompanyEngName', 'AddrE1', 'AddrE2', 'AddrE3', 'StockMethod', 'CompanyLogo', 'PrintInvoiceFormNo', 'PrintPOFormNo', 'PrintARBillFormNo', 'PrintAPBillFormNo', 'PrintCNFormNo', 'PrintSpecFormNo', 'PrintSpecRawFormNo', 'PrintSpecFinishGoodsFormNo', 'PrintSpecIntermediateFormNo', 'PrintSpecBulkFormNo', 'PrintSpecToothBrushFormNo', 'PrintDNRFormNo', 'PrintComplaintFormNo', 'PrintCheckSpecFormNo', 'Acc_Cash', 'Acc_PettyCash', 'Acc_Receivable', 'Acc_PostDateCheque', 'Acc_Inventory', 'Acc_PrepaidIncomeTax', 'Acc_InputTax', 'Acc_InputTaxNotYetDue', 'Acc_DepositPayment', 'Acc_Liabilities', 'Acc_PrepaidCheque', 'Acc_PaymentWithHoldingTax', 'Acc_PaymentWithHoldingTax2', 'Acc_PaymentWithHoldingTax3', 'Acc_PaymentWithHoldingTax4', 'Acc_PaymentWithHoldingTax5', 'Acc_AccuredPaymentWithHoldingTax', 'Acc_OutputTax', 'Acc_OutputTaxNotYetDue', 'Acc_DepositReceived', 'Acc_SaleDebit', 'Acc_SaleCredit', 'Acc_SaleReturn', 'Acc_SaleDiscount', 'Acc_InterestIncome', 'Acc_BankIncome', 'Acc_OtherIncome', 'Acc_CostOfGoodsSold', 'Acc_Purchase', 'Acc_PurchaseReturn', 'Acc_PurchaseDiscount', 'Acc_InterestExpense', 'Acc_BankCharge', 'Acc_LostLiabilities', 'Acc_OtherExpense', 'Acc_RetainedEarning', 'Acc_RegalReserve', 'PrintJobFormNo', 'Acc_InputTaxNotClaim', 'PrintInventoryFormno', 'PrintSaleFormNo', 'PrintCloseJobSheetFormNo', 'PrintAwaitingFormNo', 'PrintPendingFormNo', 'PrintAPCNFormNo', 'PrintTagForSampleFormNo', 'PrintInvoiceDOFormNo', 'PrintQAAnalysisCertFormNo', 'PrintQAAnalysisReportFormNo', 'BranchCode', 'Acc_ReceivableRevenue', 'Acc_AccruedIncome', 'PayForName', 'Acc_AdvancePayment', 'Acc_AdvancePayment_Credit'], 'string'],
            [['VatPercent', 'LimitOverOrderRate', 'DirectLabor', 'TopMargin_Cheque'], 'number'],
            [['CheckMasterFormula', 'Connect_Sale', 'Connect_GL', 'PrintInvoiceHeader', 'PrintPOHeader', 'PrintCNHeader', 'PrintDateTimeInVoucher', 'CheckSpecQCApproved', 'CheckInvOverridePrice', 'CheckConfirmJob', 'Month_Mfg_Date', 'Month_Exp_Date', 'AutoPaymentCash', 'CheckCostCenter', 'CheckAutoCloseSaleOrder', 'EditInvoiceDays', 'CheckAutoClosePurchaseOrder', 'CheckPrintInvNotAtNow', 'CheckDel_EditInvoice', 'CalcFixedCostByManHour'], 'integer'],
            [['CompanyCode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'รหัสบริษัท',
            'CompanyName' => 'บริษัท',
            'Addr1' => 'ที่อยู่',
            'Addr2' => 'ที่อยู่ 2',
            'Addr3' => 'ที่อยู่ 3',
            'TelePhone' => 'โทรศัพท์',
            'Fax' => 'โทรสาร',
            'TaxID' => 'หมายเลขประจำตัวผู้เสียภาษี',
            'CompanyEngName' => 'บริษัท (ภาษาอังกฤษ)',
            'AddrE1' => 'ที่อยู่ (ภาษาอังกฤษ)',
            'AddrE2' => 'ที่อยู่ 2 (ภาษาอังกฤษ)',
            'AddrE3' => 'ที่อยู่ 3 (ภาษาอังกฤษ)',
            'VatPercent' => 'ภาษีมูลค่าเพิ่ม',
            'LimitOverOrderRate' => 'อัตราที่รับของเกินจากการสั่งผลิต',
            'CheckMasterFormula' => 'Check Master Formula',
            'Connect_Sale' => 'Connect  Sale',
            'Connect_GL' => 'Connect  Gl',
            'StockMethod' => 'Stock Method',
            'DirectLabor' => 'Direct Labor',
            'CompanyLogo' => 'Company Logo',
            'PrintInvoiceHeader' => 'Print Invoice Header',
            'PrintPOHeader' => 'Print Poheader',
            'PrintCNHeader' => 'Print Cnheader',
            'PrintInvoiceFormNo' => 'Print Invoice Form No',
            'PrintPOFormNo' => 'Print Poform No',
            'PrintDateTimeInVoucher' => 'Print Date Time In Voucher',
            'PrintARBillFormNo' => 'Print Arbill Form No',
            'PrintAPBillFormNo' => 'Print Apbill Form No',
            'PrintCNFormNo' => 'Print Cnform No',
            'PrintSpecFormNo' => 'Print Spec Form No',
            'PrintSpecRawFormNo' => 'Print Spec Raw Form No',
            'PrintSpecFinishGoodsFormNo' => 'Print Spec Finish Goods Form No',
            'PrintSpecIntermediateFormNo' => 'Print Spec Intermediate Form No',
            'PrintSpecBulkFormNo' => 'Print Spec Bulk Form No',
            'PrintSpecToothBrushFormNo' => 'Print Spec Tooth Brush Form No',
            'PrintDNRFormNo' => 'Print Dnrform No',
            'PrintComplaintFormNo' => 'Print Complaint Form No',
            'PrintCheckSpecFormNo' => 'Print Check Spec Form No',
            'Acc_Cash' => 'Acc  Cash',
            'Acc_PettyCash' => 'Acc  Petty Cash',
            'Acc_Receivable' => 'Acc  Receivable',
            'Acc_PostDateCheque' => 'Acc  Post Date Cheque',
            'Acc_Inventory' => 'Acc  Inventory',
            'Acc_PrepaidIncomeTax' => 'Acc  Prepaid Income Tax',
            'Acc_InputTax' => 'Acc  Input Tax',
            'Acc_InputTaxNotYetDue' => 'Acc  Input Tax Not Yet Due',
            'Acc_DepositPayment' => 'Acc  Deposit Payment',
            'Acc_Liabilities' => 'Acc  Liabilities',
            'Acc_PrepaidCheque' => 'Acc  Prepaid Cheque',
            'Acc_PaymentWithHoldingTax' => 'Acc  Payment With Holding Tax',
            'Acc_PaymentWithHoldingTax2' => 'Acc  Payment With Holding Tax2',
            'Acc_PaymentWithHoldingTax3' => 'Acc  Payment With Holding Tax3',
            'Acc_PaymentWithHoldingTax4' => 'Acc  Payment With Holding Tax4',
            'Acc_PaymentWithHoldingTax5' => 'Acc  Payment With Holding Tax5',
            'Acc_AccuredPaymentWithHoldingTax' => 'Acc  Accured Payment With Holding Tax',
            'Acc_OutputTax' => 'Acc  Output Tax',
            'Acc_OutputTaxNotYetDue' => 'Acc  Output Tax Not Yet Due',
            'Acc_DepositReceived' => 'Acc  Deposit Received',
            'Acc_SaleDebit' => 'Acc  Sale Debit',
            'Acc_SaleCredit' => 'Acc  Sale Credit',
            'Acc_SaleReturn' => 'Acc  Sale Return',
            'Acc_SaleDiscount' => 'Acc  Sale Discount',
            'Acc_InterestIncome' => 'Acc  Interest Income',
            'Acc_BankIncome' => 'Acc  Bank Income',
            'Acc_OtherIncome' => 'Acc  Other Income',
            'Acc_CostOfGoodsSold' => 'Acc  Cost Of Goods Sold',
            'Acc_Purchase' => 'Acc  Purchase',
            'Acc_PurchaseReturn' => 'Acc  Purchase Return',
            'Acc_PurchaseDiscount' => 'Acc  Purchase Discount',
            'Acc_InterestExpense' => 'Acc  Interest Expense',
            'Acc_BankCharge' => 'Acc  Bank Charge',
            'Acc_LostLiabilities' => 'Acc  Lost Liabilities',
            'Acc_OtherExpense' => 'Acc  Other Expense',
            'Acc_RetainedEarning' => 'Acc  Retained Earning',
            'Acc_RegalReserve' => 'Acc  Regal Reserve',
            'PrintJobFormNo' => 'Print Job Form No',
            'TopMargin_Cheque' => 'Top Margin  Cheque',
            'Acc_InputTaxNotClaim' => 'Acc  Input Tax Not Claim',
            'PrintInventoryFormno' => 'Print Inventory Formno',
            'PrintSaleFormNo' => 'Print Sale Form No',
            'CheckSpecQCApproved' => 'Check Spec Qcapproved',
            'PrintCloseJobSheetFormNo' => 'Print Close Job Sheet Form No',
            'PrintAwaitingFormNo' => 'Print Awaiting Form No',
            'PrintPendingFormNo' => 'Print Pending Form No',
            'PrintAPCNFormNo' => 'Print Apcnform No',
            'PrintTagForSampleFormNo' => 'Print Tag For Sample Form No',
            'PrintInvoiceDOFormNo' => 'Print Invoice Doform No',
            'CheckInvOverridePrice' => 'Check Inv Override Price',
            'PrintQAAnalysisCertFormNo' => 'Print Qaanalysis Cert Form No',
            'PrintQAAnalysisReportFormNo' => 'Print Qaanalysis Report Form No',
            'CheckConfirmJob' => 'Check Confirm Job',
            'Month_Mfg_Date' => 'Month  Mfg  Date',
            'Month_Exp_Date' => 'Month  Exp  Date',
            'AutoPaymentCash' => 'Auto Payment Cash',
            'CheckCostCenter' => 'Check Cost Center',
            'CheckAutoCloseSaleOrder' => 'Check Auto Close Sale Order',
            'EditInvoiceDays' => 'Edit Invoice Days',
            'CheckAutoClosePurchaseOrder' => 'Check Auto Close Purchase Order',
            'BranchCode' => 'Branch Code',
            'CheckPrintInvNotAtNow' => 'Check Print Inv Not At Now',
            'CheckDel_EditInvoice' => 'Check Del  Edit Invoice',
            'CalcFixedCostByManHour' => 'Calc Fixed Cost By Man Hour',
            'Acc_ReceivableRevenue' => 'Acc  Receivable Revenue',
            'Acc_AccruedIncome' => 'Acc  Accrued Income',
            'PayForName' => 'Pay For Name',
            'Acc_AdvancePayment' => 'Acc  Advance Payment',
            'Acc_AdvancePayment_Credit' => 'Acc  Advance Payment  Credit',
        ];
    }
}
