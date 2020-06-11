<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PODetail;
use app\models\PurchaseOrder;

/**
 * PODetailSearch represents the model behind the search form about `app\models\PODetail`.
 */
class PODetailSearch extends PODetail
{
    public $Order_date;
    public $Supp_Number;    
    public $Supp_Name;
    

    /**
     * @inheritdoc
     */
    
     
    // public function getPo()
    // {
    //     return $this->hasOne(PurchaseOrder::className(), ['CompanyCode'=>'CompanyCode','Order_Number' => 'Order_Number']);
    // }     
    public function rules()
    {
        return [
            [['CompanyCode', 'Order_Number', 'Item_Number', 'Due_Date', 'Rlse_Date', 'PurDet_Desc', 'Uom', 'Pr_Company', 'Pr_No', 'Rej_date', 'Delivery_Date', 'SpecNo', 'EffectiveDate', 'Seq_Pr', 'PR_Number'], 'safe'],
            [['Seq_Number', 'Type_Desc'], 'integer'],
            [['Order_Qty', 'Price', 'Rlse_Qty', 'Iqc_Qty', 'Rej_Qty', 'Disc_Percent', 'Disc_Cash'], 'number'],
            // ----------------------------------
            [['Order_date'], 'safe'],            
            [['Supp_Number'], 'safe'],            
            //[['Supp_Name'], 'safe'],
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
        $query = PODetail::find();

        
        //$query->joinWith(['po']);
        $query->join('LEFT JOIN', 'po','po.Order_Number = PODetail.Order_Number and po.CompanyCode=PODetail.CompanyCode');


        //$query->joinWith(['supplier']);

        $query->orderby('po.Order_date desc,Order_Number');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],            
            //'sort'=> ['defaultOrder' => ['Order_date'=>SORT_DESC]]
        ]);
        $dataProvider->sort->attributes['Supp_Number'] = [
            'asc' => ['po.Supp_Number' => SORT_ASC],
            'desc' => ['po.Supp_Number' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['Order_date'] = [
            'asc' => ['po.Order_date' => SORT_ASC],
            'desc' => ['po.Order_date' => SORT_DESC],
        ];

        

        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Seq_Number' => $this->Seq_Number,
            'Due_Date' => $this->Due_Date,
            'Order_Qty' => $this->Order_Qty,
            'Rlse_Date' => $this->Rlse_Date,
            'Price' => $this->Price,
            'Rlse_Qty' => $this->Rlse_Qty,
            'Iqc_Qty' => $this->Iqc_Qty,
            'Rej_date' => $this->Rej_date,
            'Rej_Qty' => $this->Rej_Qty,
            'Disc_Percent' => $this->Disc_Percent,
            'Disc_Cash' => $this->Disc_Cash,
            'Type_Desc' => $this->Type_Desc,
            'Delivery_Date' => $this->Delivery_Date,
            'EffectiveDate' => $this->EffectiveDate,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'podetail.Order_Number', $this->Order_Number])
            ->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'PurDet_Desc', $this->PurDet_Desc])
            ->andFilterWhere(['like', 'Uom', $this->Uom])
            ->andFilterWhere(['like', 'Pr_Company', $this->Pr_Company])
            ->andFilterWhere(['like', 'Pr_No', $this->Pr_No])
            ->andFilterWhere(['like', 'SpecNo', $this->SpecNo])
            ->andFilterWhere(['like', 'Seq_Pr', $this->Seq_Pr])
            ->andFilterWhere(['like', 'PR_Number', $this->PR_Number])
            // -----------------------------------------------------------
            ->andFilterWhere(['like', 'po.Supp_Number', $this->Supp_Number])
            ->andFilterWhere(['like', 'CONVERT(varchar(10), po.Order_date, 105)', $this->Order_date]);
// echo '<br><br><br>';
//             \app\components\XLib::xprint_r($query->createCommand()->sql);            
        return $dataProvider;
    }
    // -----------------------------------------------------------------------------
    public function shipdatesearch($params,$p_SelectForm)
    //----------------------------------------------------------------------------
    {
        $CompanyCode = \Yii::$app->params['comp_code'];
        $d1 = date('Y-m-d', strtotime(str_replace('/', '-', $p_SelectForm['date'])));   
        $d2 = date('Y-m-d', strtotime(str_replace('/', '-', $p_SelectForm['date2'])));          
        $subQuery = ItemLoc::find()->select('Item_Number')->distinct();
        $query = PODetail::find()
            ->leftJoin('po', 'po.order_number = podetail.order_number')
            ->where("podetail.companycode='".$CompanyCode."'")
            ->andWhere("po.companycode='".$CompanyCode."'")
            ->andwhere("isnull(item_number,'') <> ''")                        
            ->andWhere(['between', 'due_date', $d1, $d2])            
            ->andWhere(['not in', 'item_number', $subQuery]);            

            
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['Order_Number'=>SORT_ASC]]
            
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Seq_Number' => $this->Seq_Number,
            'Due_Date' => $this->Due_Date,
            'Order_Qty' => $this->Order_Qty,
            'Rlse_Date' => $this->Rlse_Date,
            'Price' => $this->Price,
            'Rlse_Qty' => $this->Rlse_Qty,
            'Iqc_Qty' => $this->Iqc_Qty,
            'Rej_date' => $this->Rej_date,
            'Rej_Qty' => $this->Rej_Qty,
            'Disc_Percent' => $this->Disc_Percent,
            'Disc_Cash' => $this->Disc_Cash,
            'Type_Desc' => $this->Type_Desc,
            'Delivery_Date' => $this->Delivery_Date,
            'EffectiveDate' => $this->EffectiveDate,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'Order_Number', $this->Order_Number])
            ->andFilterWhere(['like', 'Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'PurDet_Desc', $this->PurDet_Desc])
            ->andFilterWhere(['like', 'Uom', $this->Uom])
            ->andFilterWhere(['like', 'Pr_Company', $this->Pr_Company])
            ->andFilterWhere(['like', 'Pr_No', $this->Pr_No])
            ->andFilterWhere(['like', 'SpecNo', $this->SpecNo])
            ->andFilterWhere(['like', 'Seq_Pr', $this->Seq_Pr])
            ->andFilterWhere(['like', 'PR_Number', $this->PR_Number]);
            echo '<br><br>---------------------';
            
        return $dataProvider;
    }    
       
}
