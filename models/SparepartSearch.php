<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sparepart;

/**
 * SparepartSearch represents the model behind the search form about `app\models\Sparepart`.
 */
class SparepartSearch extends Sparepart
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Item_Number', 'WhCode', 'Loc_Number', 'Item_Name', 'Uom', 'Type_Invent_Code', 'Group_Product', 'Product', 'Brand', 'Type', 'SubType', 'Tariff_Code', 'Industry_Code', 'InsteadCode', 'PackUom', 'Price', 'Supp_Number', 'Uom_Buy', 'LastBuyDate', 'LastBuyCurrency_type', 'Uom_Sale', 'LastSaleDate', 'Class', 'Source', 'Account_Code', 'Order_Policy', 'Cost_Type', 'Picture', 'CompanyCode', 'Item_Type', 'CSCode', 'LastPclDate', 'OHCode', 'UserName', 'LastUpdate', 'Remark', 'FormatDateCoding', 'CateCode', 'ControlItemType', 'Sale_Category_Code', 'Account_Code_Credit', 'StorageConditionCode', 'Cust_No', 'Barcode', 'Remark1_Coding', 'Remark2_Coding'], 'safe'],
            [['Pack', 'Flag_Ana', 'LeadTime', 'Iqc_Check', 'Life_Check', 'RetestDate_Check', 'Shrink', 'ShrinkSize', 'Lot_Size', 'Retest_Cycle', 'ShelfLife', 'Std_Approve_Purchase_LeadTime', 'Std_Apprv_Production_LeadTime', 'Std_Purchase_LeadTime', 'Tag_Qty', 'Pallet_Row', 'Pallet_Layer', 'NotActive'], 'integer'],
            [['PackSize', 'QtyOnhand', 'Price_A', 'Price_B', 'Price_C', 'Price_D', 'Minimum', 'Maximum', 'LastBuyPrice', 'LastSalePrice', 'Balbf', 'Balbf_Avg_Cost', 'Balbf_Fifo_Cost', 'Sales_Reserved', 'Prodn_Reserved', 'Scrap_Qty', 'QtyOnhand_OH', 'Buffer', 'LabelPrice', 'Waste_Qty', 'Defective_Qty', 'Good_Qty', 'AvgSale_OH', 'VariableCost', 'FixedCost', 'Pallet', 'StandardCost', 'WeightPerCorbox', 'AvgCost', 'Carton_Width', 'Carton_Hight', 'Carton_Depth', 'Box_Width', 'Box_Hight', 'Box_Depth', 'Box_Weight', 'Box_Weight_Qty', 'Keep_Temperature', 'CostOfAssay', 'QtyPerPackSize', 'WeightPerPackSize'], 'number'],
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
        $query = Sparepart::find()->orderBy(['item_number'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
          'pagination' => [
                'pageSize' => 50,
            ],             
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Pack' => $this->Pack,
            'PackSize' => $this->PackSize,
            'QtyOnhand' => $this->QtyOnhand,
            'Price_A' => $this->Price_A,
            'Price_B' => $this->Price_B,
            'Price_C' => $this->Price_C,
            'Price_D' => $this->Price_D,
            'Minimum' => $this->Minimum,
            'Maximum' => $this->Maximum,
            'LastBuyDate' => $this->LastBuyDate,
            'LastBuyPrice' => $this->LastBuyPrice,
            'LastSaleDate' => $this->LastSaleDate,
            'LastSalePrice' => $this->LastSalePrice,
            'Flag_Ana' => $this->Flag_Ana,
            'LeadTime' => $this->LeadTime,
            'Balbf' => $this->Balbf,
            'Balbf_Avg_Cost' => $this->Balbf_Avg_Cost,
            'Balbf_Fifo_Cost' => $this->Balbf_Fifo_Cost,
            'Sales_Reserved' => $this->Sales_Reserved,
            'Prodn_Reserved' => $this->Prodn_Reserved,
            'Iqc_Check' => $this->Iqc_Check,
            'Life_Check' => $this->Life_Check,
            'RetestDate_Check' => $this->RetestDate_Check,
            'Shrink' => $this->Shrink,
            'ShrinkSize' => $this->ShrinkSize,
            'Lot_Size' => $this->Lot_Size,
            'Retest_Cycle' => $this->Retest_Cycle,
            'Scrap_Qty' => $this->Scrap_Qty,
            'LastPclDate' => $this->LastPclDate,
            'QtyOnhand_OH' => $this->QtyOnhand_OH,
            'LastUpdate' => $this->LastUpdate,
            'Buffer' => $this->Buffer,
            'LabelPrice' => $this->LabelPrice,
            'ShelfLife' => $this->ShelfLife,
            'Waste_Qty' => $this->Waste_Qty,
            'Defective_Qty' => $this->Defective_Qty,
            'Good_Qty' => $this->Good_Qty,
            'AvgSale_OH' => $this->AvgSale_OH,
            'VariableCost' => $this->VariableCost,
            'FixedCost' => $this->FixedCost,
            'Std_Approve_Purchase_LeadTime' => $this->Std_Approve_Purchase_LeadTime,
            'Std_Apprv_Production_LeadTime' => $this->Std_Apprv_Production_LeadTime,
            'Std_Purchase_LeadTime' => $this->Std_Purchase_LeadTime,
            'Tag_Qty' => $this->Tag_Qty,
            'Pallet' => $this->Pallet,
            'StandardCost' => $this->StandardCost,
            'WeightPerCorbox' => $this->WeightPerCorbox,
            'AvgCost' => $this->AvgCost,
            'Carton_Width' => $this->Carton_Width,
            'Carton_Hight' => $this->Carton_Hight,
            'Carton_Depth' => $this->Carton_Depth,
            'Box_Width' => $this->Box_Width,
            'Box_Hight' => $this->Box_Hight,
            'Box_Depth' => $this->Box_Depth,
            'Box_Weight' => $this->Box_Weight,
            'Box_Weight_Qty' => $this->Box_Weight_Qty,
            'Keep_Temperature' => $this->Keep_Temperature,
            'Pallet_Row' => $this->Pallet_Row,
            'Pallet_Layer' => $this->Pallet_Layer,
            'NotActive' => $this->NotActive,
            'CostOfAssay' => $this->CostOfAssay,
            'QtyPerPackSize' => $this->QtyPerPackSize,
            'WeightPerPackSize' => $this->WeightPerPackSize,
        ]);

        $query->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'WhCode', $this->WhCode])
            ->andFilterWhere(['like', 'Loc_Number', $this->Loc_Number])
            ->andFilterWhere(['like', 'Item_Name', $this->Item_Name])
            ->andFilterWhere(['like', 'Uom', $this->Uom])
            ->andFilterWhere(['like', 'Type_Invent_Code', $this->Type_Invent_Code])
            ->andFilterWhere(['like', 'Group_Product', $this->Group_Product])
            ->andFilterWhere(['like', 'Product', $this->Product])
            ->andFilterWhere(['like', 'Brand', $this->Brand])
            ->andFilterWhere(['like', 'Type', $this->Type])
            ->andFilterWhere(['like', 'SubType', $this->SubType])
            ->andFilterWhere(['like', 'Tariff_Code', $this->Tariff_Code])
            ->andFilterWhere(['like', 'Industry_Code', $this->Industry_Code])
            ->andFilterWhere(['like', 'InsteadCode', $this->InsteadCode])
            ->andFilterWhere(['like', 'PackUom', $this->PackUom])
            ->andFilterWhere(['like', 'Price', $this->Price])
            ->andFilterWhere(['like', 'Supp_Number', $this->Supp_Number])
            ->andFilterWhere(['like', 'Uom_Buy', $this->Uom_Buy])
            ->andFilterWhere(['like', 'LastBuyCurrency_type', $this->LastBuyCurrency_type])
            ->andFilterWhere(['like', 'Uom_Sale', $this->Uom_Sale])
            ->andFilterWhere(['like', 'Class', $this->Class])
            ->andFilterWhere(['like', 'Source', $this->Source])
            ->andFilterWhere(['like', 'Account_Code', $this->Account_Code])
            ->andFilterWhere(['like', 'Order_Policy', $this->Order_Policy])
            ->andFilterWhere(['like', 'Cost_Type', $this->Cost_Type])
            ->andFilterWhere(['like', 'Picture', $this->Picture])
            ->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'Item_Type', $this->Item_Type])
//            ->andFilterWhere(['like', 'Item_Type', '5'])
            ->andFilterWhere(['like', 'CSCode', $this->CSCode])
            ->andFilterWhere(['like', 'OHCode', $this->OHCode])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'FormatDateCoding', $this->FormatDateCoding])
            ->andFilterWhere(['like', 'CateCode', $this->CateCode])
            ->andFilterWhere(['like', 'ControlItemType', $this->ControlItemType])
            ->andFilterWhere(['like', 'Sale_Category_Code', $this->Sale_Category_Code])
            ->andFilterWhere(['like', 'Account_Code_Credit', $this->Account_Code_Credit])
            ->andFilterWhere(['like', 'StorageConditionCode', $this->StorageConditionCode])
            ->andFilterWhere(['like', 'Cust_No', $this->Cust_No])
            ->andFilterWhere(['like', 'Barcode', $this->Barcode])
            ->andFilterWhere(['like', 'Remark1_Coding', $this->Remark1_Coding])
            ->andFilterWhere(['like', 'Remark2_Coding', $this->Remark2_Coding]);

        return $dataProvider;
    }
}
