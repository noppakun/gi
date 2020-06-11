<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\XPdr;

/**
 * XPdrSearch represents the model behind the search form of `app\models\XPdr`.
 */
class XPdrSearch extends XPdr
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['doc_no', 'doc_date', 'cust_no', 'cust_name', 'product_name', 'product_cat', 'product_cat_other', 'description', 'active_ingredients', 'appearance', 'color', 'taste', 'odor', 'viscosity', 'bubble', 'other', 'benchmark', 'feeling_after_use', 'target_group', 'size_unit', 'first_order', 'total_order', 'order_unit', 'sample_req_date', 'price_req_date', 'user_inform', 'user_approve', 'user_approve_date', 'manager_accept', 'manager_remark', 'manager_approve', 'manager_approve_date','bd_owner', 'rd_owner', 'cancel_user'], 'safe'],
            [['size'], 'number'],
            [['packaging_conclude'], 'integer'],

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
        
        $query = XPdr::find();
        if (!isset($params['sort'])){
            $query->orderBy([
                'doc_date' => SORT_DESC,
                'doc_no' => SORT_DESC,
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
            'id' => $this->id,
            //'doc_date' => $this->doc_date,
            'size' => $this->size,
            'sample_req_date' => $this->sample_req_date,
            'price_req_date' => $this->price_req_date,
            'user_approve_date' => $this->user_approve_date,
            'manager_approve_date' => $this->manager_approve_date,
        ]);

        if (array_search('N', $params['SelectForm']['checkbox']) !== false) {
            $query->andWhere(['user_approve' => null]);
        }
        if (array_search('B', $params['SelectForm']['checkbox']) !== false) {
            $query->andWhere(['not', ['user_approve' => null]]);
        }
        if (array_search('R', $params['SelectForm']['checkbox']) !== false) {
            $query->andWhere(['not', ['manager_approve' => null]]);
        }

        //$query->andWhere($params['SelectForm']['checkbox3'] ? ['not',['manager_approve'=> null]]:null);            


        $query->andFilterWhere(['like', 'doc_no', $this->doc_no])
            ->andFilterWhere(['like', 'cust_no', $this->cust_no])
            ->andFilterWhere(['like', 'cust_name', $this->cust_name])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_cat', $this->product_cat])
            ->andFilterWhere(['like', 'product_cat_other', $this->product_cat_other])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'active_ingredients', $this->active_ingredients])
            ->andFilterWhere(['like', 'appearance', $this->appearance])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'taste', $this->taste])
            ->andFilterWhere(['like', 'odor', $this->odor])
            ->andFilterWhere(['like', 'viscosity', $this->viscosity])
            ->andFilterWhere(['like', 'bubble', $this->bubble])
            ->andFilterWhere(['like', 'other', $this->other])
            ->andFilterWhere(['like', 'benchmark', $this->benchmark])
            ->andFilterWhere(['like', 'feeling_after_use', $this->feeling_after_use])
            ->andFilterWhere(['like', 'target_group', $this->target_group])
            ->andFilterWhere(['like', 'size_unit', $this->size_unit])
            ->andFilterWhere(['like', 'first_order', $this->first_order])
            ->andFilterWhere(['like', 'total_order', $this->total_order])
            ->andFilterWhere(['like', 'order_unit', $this->order_unit])
            ->andFilterWhere(['like', 'user_inform', $this->user_inform])
            ->andFilterWhere(['like', 'user_approve', $this->user_approve])
            ->andFilterWhere(['like', 'manager_accept', $this->manager_accept])
            ->andFilterWhere(['like', 'manager_remark', $this->manager_remark])
            ->andFilterWhere(['like', 'manager_approve', $this->manager_approve])
            ->andFilterWhere(['like', 'bd_owner', $this->bd_owner])
            ->andFilterWhere(['like', 'rd_owner', $this->rd_owner])
            
            

            ->andFilterWhere(['like', 'CONVERT(varchar(10), doc_date, 105)', $this->doc_date]);

        return $dataProvider;
    }
}
