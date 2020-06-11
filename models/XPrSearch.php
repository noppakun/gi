<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\XPr;

use Yii;

/**
 * XPrSearch represents the model behind the search form of `app\models\XPr`.
 */

class XPrSearch extends XPr
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_no', 'doc_date', 'ref_doc_no', 'supp_name', 'shipto', 'remark', 'dept_code', 'vat_type', 'prepare_user', 'prepare_date', 'review_user', 'review_date', 'dp_approve_user', 'dp_approve_date', 'dp_reject_user', 'dp_reject_date', 'md_approve_user', 'md_approve_date', 'md_reject_user', 'md_reject_date', 'last_update_user', 'last_update_date', 'po_create_user', 'po_create_date'], 'safe'],
            [['vat_percent', 'vat_amount', 'amount', 'total_amount'], 'number'],
            [['value_req_md_approve'], 'integer'],
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
    public function search_filter(&$query)
    {
        $query->andFilterWhere([
            'doc_date' => $this->doc_date,
            'prepare_date' => $this->prepare_date,
            'review_date' => $this->review_date,
            'dp_approve_date' => $this->dp_approve_date,
            'dp_reject_date' => $this->dp_reject_date,
            'md_approve_date' => $this->md_approve_date,
            'md_reject_date' => $this->md_reject_date,
            'last_update_date' => $this->last_update_date,
            'po_create_date' => $this->po_create_date
        ]);

        $query->andFilterWhere(['like', 'doc_no', $this->doc_no])
            ->andFilterWhere(['like', 'ref_doc_no', $this->ref_doc_no])
            ->andFilterWhere(['like', 'supp_name', $this->supp_name])
            ->andFilterWhere(['like', 'shipto', $this->shipto])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'dept_code', $this->dept_code])
            ->andFilterWhere(['like', 'prepare_user', $this->prepare_user])
            ->andFilterWhere(['like', 'review_user', $this->review_user])
            ->andFilterWhere(['like', 'dp_approve_user', $this->dp_approve_user])
            ->andFilterWhere(['like', 'dp_reject_user', $this->dp_reject_user])
            ->andFilterWhere(['like', 'md_approve_user', $this->md_approve_user])
            ->andFilterWhere(['like', 'md_reject_user', $this->md_reject_user])
            ->andFilterWhere(['like', 'last_update_user', $this->last_update_user])
            ->andFilterWhere(['like', 'po_create_user', $this->po_create_user]);

    }
    public function search($params)
    {
        $query = XPr::find();

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
        // call by Reference 
        $this->search_filter($query);


        return $dataProvider;
    }
}
