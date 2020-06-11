<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Cust_No', 'Cust_Name', 'Addr1', 'Addr2', 'Addr3', 'Addr4', 'Phone', 'Contact', 'Position', 'Saleman', 'Terms', 'Price_Code', 'Currency_Type', 'Shipto_Addr1', 'Shipto_Addr2', 'Shipto_Addr3', 'Shipto_Addr4', 'CountryCode', 'Fax', 'Account_Code', 'ProvinceCode', 'AreaCode', 'DistrictCode', 'SaleZoneCode', 'PostalCode', 'Remark', 'CustomerTypeCode', 'CustomerGroupCode', 'RegisterNo', 'RegisterExpireDate', 'Account_Code_Credit', 'Account_Code_Return', 'Account_Code_Distcount', 'Account_Code_Material', 'Taxid', 'BranchCode', 'Vat_ch'], 'safe'],
            [['Credit_Limit'], 'number'],
            [['NotActive', 'BlackList'], 'integer'],
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
        $query = Customer::find();

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
            'Credit_Limit' => $this->Credit_Limit,
            'NotActive' => $this->NotActive,
            'BlackList' => $this->BlackList,
            'RegisterExpireDate' => $this->RegisterExpireDate,
        ]);

        $query->andFilterWhere(['like', 'Cust_No', $this->Cust_No])
            ->andFilterWhere(['like', 'Cust_Name', $this->Cust_Name])
            ->andFilterWhere(['like', 'Addr1', $this->Addr1])
            ->andFilterWhere(['like', 'Addr2', $this->Addr2])
            ->andFilterWhere(['like', 'Addr3', $this->Addr3])
            ->andFilterWhere(['like', 'Addr4', $this->Addr4])
            ->andFilterWhere(['like', 'Phone', $this->Phone])
            ->andFilterWhere(['like', 'Contact', $this->Contact])
            ->andFilterWhere(['like', 'Position', $this->Position])
            ->andFilterWhere(['like', 'Saleman', $this->Saleman])
            ->andFilterWhere(['like', 'Terms', $this->Terms])
            ->andFilterWhere(['like', 'Price_Code', $this->Price_Code])
            ->andFilterWhere(['like', 'Currency_Type', $this->Currency_Type])
            ->andFilterWhere(['like', 'Shipto_Addr1', $this->Shipto_Addr1])
            ->andFilterWhere(['like', 'Shipto_Addr2', $this->Shipto_Addr2])
            ->andFilterWhere(['like', 'Shipto_Addr3', $this->Shipto_Addr3])
            ->andFilterWhere(['like', 'Shipto_Addr4', $this->Shipto_Addr4])
            ->andFilterWhere(['like', 'CountryCode', $this->CountryCode])
            ->andFilterWhere(['like', 'Fax', $this->Fax])
            ->andFilterWhere(['like', 'Account_Code', $this->Account_Code])
            ->andFilterWhere(['like', 'ProvinceCode', $this->ProvinceCode])
            ->andFilterWhere(['like', 'AreaCode', $this->AreaCode])
            ->andFilterWhere(['like', 'DistrictCode', $this->DistrictCode])
            ->andFilterWhere(['like', 'SaleZoneCode', $this->SaleZoneCode])
            ->andFilterWhere(['like', 'PostalCode', $this->PostalCode])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'CustomerTypeCode', $this->CustomerTypeCode])
            ->andFilterWhere(['like', 'CustomerGroupCode', $this->CustomerGroupCode])
            ->andFilterWhere(['like', 'RegisterNo', $this->RegisterNo])
            ->andFilterWhere(['like', 'Account_Code_Credit', $this->Account_Code_Credit])
            ->andFilterWhere(['like', 'Account_Code_Return', $this->Account_Code_Return])
            ->andFilterWhere(['like', 'Account_Code_Distcount', $this->Account_Code_Distcount])
            ->andFilterWhere(['like', 'Account_Code_Material', $this->Account_Code_Material])
            ->andFilterWhere(['like', 'Taxid', $this->Taxid])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'Vat_ch', $this->Vat_ch]);

        return $dataProvider;
    }
}
