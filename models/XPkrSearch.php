<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\XPkr;

/**
 * XPkrSearch represents the model behind the search form of `app\models\XPkr`.
 */
class XPkrSearch extends XPkr
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'other_detail_picture', 'other_detail_sample', 'other_detail_other'], 'integer'],
            [['doc_no', 'doc_date', 'cust_no', 'cust_name', 'product_name', 'product_cat', 'product_cat_other', 'bulk', 'benchmark', 'target_group', 'size_unit', 'order_unit', 'artwork_design', 'other_detail_other_text', 'present_req_date', 'price_req_date', 'user_inform', 'user_accept', 'user_remark', 'user_approve', 'user_approve_date', 'manager_accept', 'manager_remark', 'manager_approve', 'manager_approve_date', 'bd_owner', 'rd_owner', 'cancel_user'], 'safe'],
            [['size', 'first_order', 'total_order'], 'number'],
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

        $query = XPkr::find();
        if (!isset($params['sort'])) {
            $query->orderBy([
                'doc_date' => SORT_DESC,
                'doc_no' => SORT_DESC,
            ]);
        }
        // $query->select('
        //     id
        //     ,doc_no
        //     ,doc_date
        //     ,cust_no
        //     ,cust_name
        //     ,product_name
        //     ,product_cat
        //     ,product_cat_other
        //     ,bulk 
        //     ,bulk_note
        //     ,benchmark
        //     ,target_group
        //     ,size_text
        //     ,size
        //     ,size_unit
        //     ,order_text
        //     ,first_order
        //     ,total_order
        //     ,order_unit
        //     ,artwork_design

        //     ,present_req_date
        //     ,price_req_date
        //     ,user_inform
        //     ,user_accept
        //     ,user_remark
        //     ,user_approve
        //     ,user_approve_date
        //     ,manager_accept
        //     ,manager_remark
        //     ,manager_approve
        //     ,manager_approve_date
        //     ,bd_owner
        //     ,rd_owner
        //     ,cancel_date
        //     ,cancel_user
        //     ,cancel_resson        
                    
        // ');
        /*
//  ,other_detail_picture
// ,other_detail_sample
// ,other_detail_other
// ,other_detail_other_text
//  */

        //         // add conditions that should always apply here

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
            // 'doc_date' => $this->doc_date,
            'size' => $this->size,
            'first_order' => $this->first_order,
            'total_order' => $this->total_order,
            'other_detail_picture' => $this->other_detail_picture,
            'other_detail_sample' => $this->other_detail_sample,
            'other_detail_other' => $this->other_detail_other,
            'present_req_date' => $this->present_req_date,
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
        $query->andFilterWhere(['like', 'doc_no', $this->doc_no])
            ->andFilterWhere(['like', 'cust_no', $this->cust_no])
            ->andFilterWhere(['like', 'cust_name', $this->cust_name])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_cat', $this->product_cat])
            ->andFilterWhere(['like', 'product_cat_other', $this->product_cat_other])
            ->andFilterWhere(['like', 'bulk', $this->bulk])
            ->andFilterWhere(['like', 'benchmark', $this->benchmark])
            ->andFilterWhere(['like', 'target_group', $this->target_group])
            ->andFilterWhere(['like', 'size_unit', $this->size_unit])
            ->andFilterWhere(['like', 'order_unit', $this->order_unit])
            ->andFilterWhere(['like', 'artwork_design', $this->artwork_design])
            ->andFilterWhere(['like', 'other_detail_other_text', $this->other_detail_other_text])
            ->andFilterWhere(['like', 'user_inform', $this->user_inform])
            ->andFilterWhere(['like', 'user_accept', $this->user_accept])
            ->andFilterWhere(['like', 'user_remark', $this->user_remark])
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
