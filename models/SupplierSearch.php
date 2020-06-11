<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Supplier;

/**
 * SupplierSearch represents the model behind the search form about `app\models\Supplier`.
 */
class SupplierSearch extends Supplier
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Supp_Number', 'Supp_Name', 'Addr1', 'Addr2', 'Addr3', 'Addr4', 'Contact', 'Position', 'Remarks', 'Phone', 'Fax', 'Terms', 'Currency_Type', 'Account_Code', 'TaxID', 'SupplierTypeCode', 'BranchCode', 'Vat_Ch'], 'safe'],
            [['Credit_Limit'], 'number'],
            [['Supp_Cancel'], 'integer'],
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

    // -------------------------------------------------------------------
    public function search($params) {
        // -------------------------------------------------------------------
            return $this->_search(0,$params);
        }
    
    // -------------------------------------------------------------------
    public function quotationPriceSearch($params) {
    // -------------------------------------------------------------------        
        return $this->_search(1,$params);
    }    

    
    // ............................................................................
    function _searchQuery($cho)
    // ............................................................................
    {
        if ($cho==0){ // default
            $query = Supplier::find();
        }if ($cho==1){ // quotationPriceSearch
            $subQuery = Quote::find()->select('Supp_Number')->distinct();    
            $query = Supplier::find()->where(['in', 'Supp_Number', $subQuery]);
        }
        return $query;
    }
    // ............................................................................
    function _search($cho,$params)
    // ............................................................................
    {
             //$query = Supplier::find();
        $query = $this->_searchQuery($cho);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'Supp_Number' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Credit_Limit' => $this->Credit_Limit,
            'Supp_Cancel' => $this->Supp_Cancel,
        ]);

        $query->andFilterWhere(['like', 'Supp_Number', $this->Supp_Number])
            ->andFilterWhere(['like', 'Supp_Name', $this->Supp_Name])
            ->andFilterWhere(['like', 'Addr1', $this->Addr1])
            ->andFilterWhere(['like', 'Addr2', $this->Addr2])
            ->andFilterWhere(['like', 'Addr3', $this->Addr3])
            ->andFilterWhere(['like', 'Addr4', $this->Addr4])
            ->andFilterWhere(['like', 'Contact', $this->Contact])
            ->andFilterWhere(['like', 'Position', $this->Position])
            ->andFilterWhere(['like', 'Remarks', $this->Remarks])
            ->andFilterWhere(['like', 'Phone', $this->Phone])
            ->andFilterWhere(['like', 'Fax', $this->Fax])
            ->andFilterWhere(['like', 'Terms', $this->Terms])
            ->andFilterWhere(['like', 'Currency_Type', $this->Currency_Type])
            ->andFilterWhere(['like', 'Account_Code', $this->Account_Code])
            ->andFilterWhere(['like', 'TaxID', $this->TaxID])
            ->andFilterWhere(['like', 'SupplierTypeCode', $this->SupplierTypeCode])
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode])
            ->andFilterWhere(['like', 'Vat_Ch', $this->Vat_Ch]);

        return $dataProvider;
    }
}
