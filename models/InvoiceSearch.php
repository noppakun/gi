<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Invoice;

/**
 * InvoiceSearch represents the model behind the search form about `app\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    // if (Yii::$app->controller->id=='invoice-acc')
    public $cust_name;
    public $due_date_acc;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'CompanyCode', 'Inv_Number', 'Type_Inv_Code', 'Sale_Number', 'DivisionCode', 'DeptCode', 'Cust_No', 'Inv_Date', 'SalesmanCode', 'DeliveryCode', 'Terms', 'ShipTo_Addr1', 'ShipTo_Addr2', 'ShipTo_Addr3', 'ShipTo_Addr4', 'Remark1', 'Remark2', 'Remark3', 'Due_Date', 'Cust_PO_No', 'Cust_PO_Date', 'Desc_Disc_Other', 'Adjust_Date', 'Currency_Type', 'Inv_Picture', 'UserName', 'LastUpdate', 'Vat_Type', 'BranchCode', 'delivery_date'
            ], 'safe'],
            [['Disc_Cash', 'Disc_Percent', 'Disc_Special', 'Disc_Money', 'Disc_Other', 'Vat_Percent', 'Vat_Amount', 'Currency_Rate', 'Amount', 'TotalAmount', 'PaidAmount'], 'number'],
            [['Inv_Issue', 'Open_Close', 'Adjust_Many'], 'integer'],
            [['cust_name','due_date_acc'], 'safe'],

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
        
        $query = Invoice::find();


        if (Yii::$app->controller->id=='invoice-acc'){
            $query->joinWith(['customer']);  
            $query->joinWith(['xInvoiceExt']);  
                      
        }


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if (Yii::$app->controller->id=='invoice-acc'){
            $dataProvider->sort->attributes['cust_name'] = [ 
                'asc' => ['customer.Cust_Name' => SORT_ASC],
                'desc' => ['customer.Cust_Name' => SORT_DESC],
            ]; 
            $dataProvider->sort->attributes['due_date_acc'] = [ 
                'asc' => ['x_invoice_ext.due_date_acc' => SORT_ASC],
                'desc' => ['x_invoice_ext.due_date_acc' => SORT_DESC],
            ];                        
        }
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'Inv_Date' => $this->Inv_Date,
            //'Due_Date' => $this->Due_Date,
            'Cust_PO_Date' => $this->Cust_PO_Date,
            'Disc_Cash' => $this->Disc_Cash,
            'Disc_Percent' => $this->Disc_Percent,
            'Disc_Special' => $this->Disc_Special,
            'Disc_Money' => $this->Disc_Money,
            'Disc_Other' => $this->Disc_Other,
            'Inv_Issue' => $this->Inv_Issue,
            'Open_Close' => $this->Open_Close,
            'Vat_Percent' => $this->Vat_Percent,
            'Vat_Amount' => $this->Vat_Amount,
            'Adjust_Date' => $this->Adjust_Date,
            'Adjust_Many' => $this->Adjust_Many,
            'Currency_Rate' => $this->Currency_Rate,
            'Amount' => $this->Amount,
            'TotalAmount' => $this->TotalAmount,
            'PaidAmount' => $this->PaidAmount,
            'LastUpdate' => $this->LastUpdate,
            'delivery_date' => $this->delivery_date,
        ]);

        $query->andFilterWhere(['like', 'invoice.CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'invoice.Inv_Number', $this->Inv_Number])
            ->andFilterWhere(['like', 'Type_Inv_Code', $this->Type_Inv_Code])
            ->andFilterWhere(['like', 'Sale_Number', $this->Sale_Number])
            ->andFilterWhere(['like', 'DivisionCode', $this->DivisionCode])
            ->andFilterWhere(['like', 'DeptCode', $this->DeptCode])
            ->andFilterWhere(['like', 'Cust_No', $this->Cust_No])
            ->andFilterWhere(['like', 'SalesmanCode', $this->SalesmanCode])
            ->andFilterWhere(['like', 'DeliveryCode', $this->DeliveryCode])
            ->andFilterWhere(['like', 'Terms', $this->Terms])
            ->andFilterWhere(['like', 'ShipTo_Addr1', $this->ShipTo_Addr1])
            ->andFilterWhere(['like', 'ShipTo_Addr2', $this->ShipTo_Addr2])
            ->andFilterWhere(['like', 'ShipTo_Addr3', $this->ShipTo_Addr3])
            ->andFilterWhere(['like', 'ShipTo_Addr4', $this->ShipTo_Addr4])
            ->andFilterWhere(['like', 'Remark1', $this->Remark1])
            ->andFilterWhere(['like', 'Remark2', $this->Remark2])
            ->andFilterWhere(['like', 'Remark3', $this->Remark3])
            ->andFilterWhere(['like', 'Cust_PO_No', $this->Cust_PO_No])
            ->andFilterWhere(['like', 'Desc_Disc_Other', $this->Desc_Disc_Other])
            ->andFilterWhere(['like', 'Currency_Type', $this->Currency_Type])
            ->andFilterWhere(['like', 'Inv_Picture', $this->Inv_Picture])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'Vat_Type', $this->Vat_Type])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'CONVERT(varchar(10), Due_Date, 105)', $this->Due_Date])
            ->andFilterWhere(['like', 'CONVERT(varchar(10), Inv_Date, 105)', $this->Inv_Date]);
            
            if (Yii::$app->controller->id=='invoice-acc'){
                $query->andFilterWhere(['like', 'customer.cust_name', $this->cust_name]);                
                $query->andFilterWhere(['like', 'CONVERT(varchar(10), x_invoice_ext.due_date_acc, 105)', $this->due_date_acc]);                

            }
    

        return $dataProvider;
    }
}
