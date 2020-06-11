<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\XPkgReserve;

/**
 * XPkgReserveSearch represents the model behind the search form of `app\models\XPkgReserve`.
 */
class XPkgReserveSearch extends XPkgReserve
{
    public $m_gproduct;
    public $m_product;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['group_product', 'product', 'condition', 'reserve_remark'], 'safe'],
            [['reserve'], 'number'],
            [['reserve_pcs'], 'integer'],            

            [['m_gproduct','m_product'], 'safe'],
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
        $query = XPkgReserve::find()
            ->joinWith(['gproduct','product2'])
            //->joinWith(['product2'])
            
            //  ->orderBy(['group_product' => SORT_ASC,'product' => SORT_ASC])
            ;

            //$query->joinWith(['gproduct']);
        //$query->join('LEFT JOIN', 'po','po.Order_Number = PODetail.Order_Number and po.CompanyCode=PODetail.CompanyCode');
        //$query->join('LEFT JOIN', 'gproduct','gproduct.Group_Product= x_pkg_reserve.group_product');


        // add conditions that should always apply here
        //echo '<br><br>';
        //\app\components\XLib::xprint_r($query->createCommand()->sql);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],            
        ]);

        $dataProvider->sort->attributes['m_gproduct'] = [
            'asc' => ['gproduct.Group_Product_Desc' => SORT_ASC],
            'desc' => ['gproduct.Group_Product_Desc' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['m_product'] = [
            'asc' => ['product.Product_Desc' => SORT_ASC],
            'desc' => ['product.Product_Desc' => SORT_DESC],
        ];

        $this->load($params);


        // echo '<br><br>';
        //  \app\components\XLib::xprint_r($this->m_gproduct);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'reserve' => $this->reserve,
        ]);

        $query->andFilterWhere(['like', 'x_pkg_reserve.group_product', $this->group_product])
            ->andFilterWhere(['like', 'product', $this->product])
            ->andFilterWhere(['like', 'condition', $this->condition])
            ->andFilterWhere(['like', 'gproduct.Group_Product_Desc', $this->m_gproduct])
            ->andFilterWhere(['like', 'product.Product_Desc', $this->m_product])
            ->andFilterWhere(['like', 'reserve_remark', $this->reserve_remark]);

        return $dataProvider;
    }
}
