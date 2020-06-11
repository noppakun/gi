<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\XSalesinfo;
use app\components\XLib;

/**
 * XSalesinfoSearch represents the model behind the search form about `app\models\XSalesinfo`.
 */
class XSalesinfoSearch extends XSalesinfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tryear', 'trmonth'], 'integer'],
            [['trquarter', 'cust_no', 'cust_name', 'CustomerTypeCode', 'customertypedesc', 'item_name', 'group_product_desc', 'product_desc', 'branddesc', 'sku', 'item_number', 'ana_no', 'salesman'], 'string'],
            [['qty', 'amt', 'markup', 'unit_markup', 'std_price', 'actual_cost', 'variable_cost', 'percent_markup'], 'number'],
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
        
        $sf=null;
        $query = XSalesinfo::find();
        if (isset($params['SelectForm']) and isset($params['SelectForm']['action'])){
            $sf = $params['SelectForm'];
            if (($sf['action']=='salesinfo/index') or ($sf['action']=='salesinfo/indexbd')){                               }
                $query = XSalesinfo::find()
                    ->select(['trmonth, customertypedesc, cust_name,item_name,sum(qty) as qty,sum(amt) AS amt'])        
                    ->groupBy(['trmonth', 'customertypedesc', 'cust_name','item_name']);                        
        } 
        // if ($query !== null ){
        //     $query = XSalesinfo::find();
        // }

        // 8/12/2017  k.jed
        // change to 2+1 year

        //->all();
                
            //->where('tryear >=(DATEPART(yyyy,getdate()) - 2)');
            //->orderBy('tryear,trmonth,item_number,ana_no');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => [
               
                'trmonth'=>SORT_ASC,
                'cust_name'=>SORT_ASC,                
                'item_name'=>SORT_ASC,
                //'ana_no'=>SORT_ASC,
            ]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'tryear' => $this->tryear,
            'trmonth' => $this->trmonth,
            'qty' => $this->qty,
            'amt' => $this->amt,
            'markup' => $this->markup,
            'unit_markup' => $this->unit_markup,
            'std_price' => $this->std_price,
            'actual_cost' => $this->actual_cost,
            'variable_cost' => $this->variable_cost,            
            'percent_markup' => $this->percent_markup,            
        ]);

        $query->andFilterWhere(['like', 'trquarter', $this->trquarter])
            ->andFilterWhere(['like', 'cust_no', $this->cust_no])
            ->andFilterWhere(['like', 'cust_name', $this->cust_name])
            ->andFilterWhere(['like', 'customertypedesc', $this->customertypedesc])
            ->andFilterWhere(['like', 'item_name', $this->item_name])
            ->andFilterWhere(['like', 'group_product_desc', $this->group_product_desc])
            ->andFilterWhere(['like', 'product_desc', $this->product_desc])
            ->andFilterWhere(['like', 'branddesc', $this->branddesc])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'item_number', $this->item_number])
            ->andFilterWhere(['like', 'ana_no', $this->ana_no])
            ->andFilterWhere(['like', 'salesman', $this->salesman]);
            
        // if (isset($params['SelectForm']) and isset($params['SelectForm']['action'])){            
        //     $sf = $params['SelectForm'];
        if ($sf<> null){                
    
            if (($sf['action']=='salesinfo/index') or ($sf['action']=='salesinfo/indexbd')){                
                if ( ($sf['month'] >= 1) and ($sf['month'] <=12) ){                 
                    $query->andFilterWhere(['trmonth' => $sf['month']]);                
                }else if ($sf['month'] >= 20){
                    $query->andFilterWhere(['trquarter' => 'Q'.($sf['month']-20)]);                                
                }
                if ($sf['cust_no']!=='*'){
                    $query->andFilterWhere(['cust_no' => $sf['cust_no']]);                                            
                }
                if ($sf['customertypecode']!=='*'){
                    $query->andFilterWhere(['customertypecode' => $sf['customertypecode']]);                                            
                }            
                if ($sf['checkbox']==1){
                    $query->andFilterWhere(['<>', 'item_number','Y0003']);
                }
    
                $query->andFilterWhere(['tryear' => $sf['year']]);                
                
            }
 
        }
        return $dataProvider;
    }
    
    public function search1($params)
    {



        // 8/12/2017  k.jed
        // change to 2+1 year

        $query = XSalesinfo::find()
            ->where('tryear >=(DATEPART(yyyy,getdate()) - 2)');
            //->orderBy('tryear,trmonth,item_number,ana_no');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => [
                'tryear'=>SORT_ASC,
                'trmonth'=>SORT_ASC,
                'cust_no'=>SORT_ASC,                
                'item_number'=>SORT_ASC,
                //'ana_no'=>SORT_ASC,
            ]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'tryear' => $this->tryear,
            'trmonth' => $this->trmonth,
            'qty' => $this->qty,
            'amt' => $this->amt,
            'markup' => $this->markup,
            'unit_markup' => $this->unit_markup,
            'std_price' => $this->std_price,
            'actual_cost' => $this->actual_cost,
            'variable_cost' => $this->variable_cost,            
            'percent_markup' => $this->percent_markup,            
        ]);

        $query->andFilterWhere(['like', 'trquarter', $this->trquarter])
            ->andFilterWhere(['like', 'cust_no', $this->cust_no])
            ->andFilterWhere(['like', 'cust_name', $this->cust_name])
            ->andFilterWhere(['like', 'customertypedesc', $this->customertypedesc])
            ->andFilterWhere(['like', 'item_name', $this->item_name])
            ->andFilterWhere(['like', 'group_product_desc', $this->group_product_desc])
            ->andFilterWhere(['like', 'product_desc', $this->product_desc])
            ->andFilterWhere(['like', 'branddesc', $this->branddesc])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'item_number', $this->item_number])
            ->andFilterWhere(['like', 'ana_no', $this->ana_no])
            ->andFilterWhere(['like', 'salesman', $this->salesman]);
            
        if (isset($params['SelectForm']) and isset($params['SelectForm']['action'])){
            $sf = $params['SelectForm'];
            if (($sf['action']=='salesinfo/index') or ($sf['action']=='salesinfo/indexbd')){
                
                if ( ($sf['month'] >= 1) and ($sf['month'] <=12) ){                 
                    $query->andFilterWhere(['trmonth' => $sf['month']]);                
                }else if ($sf['month'] >= 20){
                    $query->andFilterWhere(['trquarter' => 'Q'.($sf['month']-20)]);                                
                }
                if ($sf['cust_no']!=='*'){
                    $query->andFilterWhere(['cust_no' => $sf['cust_no']]);                                            
                }
                if ($sf['customertypecode']!=='*'){
                    $query->andFilterWhere(['customertypecode' => $sf['customertypecode']]);                                            
                }            
                if ($sf['checkbox']==1){
                    $query->andFilterWhere(['<>', 'item_number','Y0003']);
                }
    
                $query->andFilterWhere(['tryear' => $sf['year']]);                
            }
 
        }
        return $dataProvider;
    }
}
