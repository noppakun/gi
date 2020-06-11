<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StHead;

/**
 * StHeadSearch represents the model behind the search form of `app\models\StHead`.
 */
class StHeadSearch extends StHead
{
    public $MOVEMENT = 1;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'DocType', 'VoucherNo', 'DocDate', 'Order_Number', 'RefDoc', 'JobNo', 'Remark', 'AccountCode', 'Manufacturer', 'Supplier_Lot', 'RefDoc2', 'UserName', 'RecvDocDate', 'PO_NO', 'Inv_Number', 'Inv_Date', 'Supp_Number', 'Supp_Name', 'UserPostGL', 'DateTimePostGL', 'BranchCode', 'AccountCode_Tax', 'TransferStatus', 'TaxID', 'DivisionCode', 'DeptCode', 'AccountCode_Deposit'], 'safe'],
            [['VatRate', 'VatAmt', 'Discount', 'Deposit', 'Amount', 'TotalAmount', 'PaidAmount'], 'number'],
            [['PostGL', 'PrintDocStatus', 'BranchNo'], 'integer'],
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
    public function search($params,$opt=0,$SelectForm = null)
    {
        $query = StHead::find();
        if ($opt == $this->MOVEMENT){
            $query->orderBy( [
                'DocDate' => SORT_ASC,
                'VoucherNo' => SORT_ASC, 
            ]);
        }

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
            //'DocDate' => $this->DocDate,
            'VatRate' => $this->VatRate,
            'VatAmt' => $this->VatAmt,
            'RecvDocDate' => $this->RecvDocDate,
            'Inv_Date' => $this->Inv_Date,
            'Discount' => $this->Discount,
            'Deposit' => $this->Deposit,
            'Amount' => $this->Amount,
            'TotalAmount' => $this->TotalAmount,
            'PaidAmount' => $this->PaidAmount,
            'PostGL' => $this->PostGL,
            'DateTimePostGL' => $this->DateTimePostGL,
            'PrintDocStatus' => $this->PrintDocStatus,
            'BranchNo' => $this->BranchNo,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', "CONVERT(varchar(10), DocDate, 105)+' '+CONVERT(varchar(10), DocDate, 108)", $this->DocDate])           
            ->andFilterWhere(['like', 'DocType', $this->DocType])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'Order_Number', $this->Order_Number])
            ->andFilterWhere(['like', 'RefDoc', $this->RefDoc])
            ->andFilterWhere(['like', 'JobNo', $this->JobNo])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'AccountCode', $this->AccountCode])
            ->andFilterWhere(['like', 'Manufacturer', $this->Manufacturer])
            ->andFilterWhere(['like', 'Supplier_Lot', $this->Supplier_Lot])
            ->andFilterWhere(['like', 'RefDoc2', $this->RefDoc2])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'PO_NO', $this->PO_NO])
            ->andFilterWhere(['like', 'Inv_Number', $this->Inv_Number])
            ->andFilterWhere(['like', 'Supp_Number', $this->Supp_Number])
            ->andFilterWhere(['like', 'Supp_Name', $this->Supp_Name])
            ->andFilterWhere(['like', 'UserPostGL', $this->UserPostGL])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'AccountCode_Tax', $this->AccountCode_Tax])
            ->andFilterWhere(['like', 'TransferStatus', $this->TransferStatus])
            ->andFilterWhere(['like', 'TaxID', $this->TaxID])
            ->andFilterWhere(['like', 'DivisionCode', $this->DivisionCode])
            ->andFilterWhere(['like', 'DeptCode', $this->DeptCode])
            ->andFilterWhere(['like', 'AccountCode_Deposit', $this->AccountCode_Deposit]);
        if ($opt == $this->MOVEMENT){
            $d1 = date('Y-m-d', strtotime(str_replace('/', '-', $SelectForm['date'])));   
            $d2 = date('Y-m-d', strtotime(str_replace('/', '-', $SelectForm['date2'])));
            $query->andFilterWhere([
                    'CompanyCode' => $SelectForm->co_code,
                    'DocType' => $SelectForm->doctype
                    ])
                ->andFilterWhere(['between', 'DocDate', $d1, $d2 ]);
                
            
             
            

        }
        return $dataProvider;
    }
//---------------------------------------------------------------------    
    public function searchMovement($SelectForm)
    {
        $d1 = date('Y-m-d', strtotime(str_replace('/', '-', $SelectForm['date'])));   
        $d2 = date('Y-m-d', strtotime(str_replace('/', '-', $SelectForm['date2'])));

        $query = StHead::find()
        // ->select([
        //     'DocDate',
        //     'VoucherNo',
        //     'Order_Number',
        //     'JobNo',
        //     'RefDoc',
        //     'Remark',            
        // ])
        ->andFilterWhere([
                'CompanyCode' => $SelectForm->co_code,
                'DocType' => $SelectForm->doctype
                ])
        ->andFilterWhere(['between', 'CAST(docdate AS date)', $d1, $d2 ])
        ->orderBy([
            'DocDate' => SORT_ASC,
            'VoucherNo' => SORT_ASC, 
        ]);

 
        return $query->all();

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,   
        //     'pagination' => false,       
        // ]);
        // return $dataProvider;
        
        

    }    
}
