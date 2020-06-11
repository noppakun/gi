<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdDet;

/**
 * ProdDetSearch represents the model behind the search form about `app\models\ProdDet`.
 */
class ProdDetSearch extends ProdDet
{
    // for grid search
    public $Industry_Code;
    public $Item_Name;

    //$this->$labels['Item_Name']='รายละเอียด';
    function __construct() 
    { 
        $this->labels['Item_Name']='รายละเอียด';
        
    } 
     
 


    public function rules()
    {
        return [
            [['Order_No', 'Item_Number', 'Priority', 'Rlse_Date', 'Status', 'Due_Date', 'UserName'], 'safe'],
            [['Order_Qty', 'Rlse_Qty'], 'number'],
            // for grid search
            [['Industry_Code','Item_Name'], 'string'],            
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
 
    public function production_order_search($params,$showall=1)
    {
        $query = ProdDet::find()
        ->select('ProdDet.Item_Number,Item.Item_Name,Order_Qty,Due_Date'
            .',ProdDet.Order_No,Priority,Status,Prod.Order_Date,Item.Industry_Code')
        ->joinWith('prod')
        ->joinWith('item')->distinct();

/*

        $subQuery = StCard::find()
            ->select('item_number ,count(*) as instcard')
            ->groupBy('stcard.item_number');
        $query->leftJoin(['_stcard' => $subQuery], '_stcard.item_number = proddet.item_number'); // ==========  แสดง item ใหม่ (ไม่มีใน stcard)
        $query->orFilterWhere(['=','_stcard.instcard',0]); // ==========  แสดง item ใหม่ (ไม่มีใน stcard)            
*/
        /*
           prodnotecount  is view in database 
        */ 
        $query->joinWith('prodnotecount _pnc');                        
/*          
        if (!$showall){
            $query->joinWith('xprodnote xpn');                        
            $query->andFilterWhere(['xpn.status' => 'N']);
        } 
  */      
        if (!$showall){            
            $query->andFilterWhere(['>','_pnc.notecount',0]);                             
            $query->orFilterWhere(['=','_pnc.newitem',1]);                             
            
            
        } 
        
 
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'Item_Number',
                    
                    'Item_Name',
                    'Due_Date',
                    'Order_No',
                    'Industry_Code',
                    'prod.Order_Date',
                    
                ],

                'defaultOrder' => [                        
                    'Due_Date' => SORT_ASC,
                    //'priority.refname' => SORT_ASC,
                    
                ]
            ],  
            'pagination' => [
                'pageSize' => 40,
            ],                           
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Order_Qty' => $this->Order_Qty,
            'Rlse_Qty' => $this->Rlse_Qty,
            'Rlse_Date' => $this->Rlse_Date,
            'Due_Date' => $this->Due_Date,
            //'notecount'=>0,
            'item.Type_Invent_Code' => '01',        // ***  fix condition  เอาเฉพาะ finish good
        ]);

        $query->andFilterWhere(['like', 'ProdDet.Order_No', $this->Order_No])
            ->andFilterWhere(['like', 'ProdDet.Item_Number', $this->Item_Number])            
            ->andFilterWhere(['like', 'Priority', $this->Priority])
            // for grid search
            ->andFilterWhere(['like', 'Item.Industry_Code', $this->Industry_Code])
            ->andFilterWhere(['like', 'Item.Item_Name', $this->Item_Name])
            //->andFilterWhere(['like', 'Status', $this->Status])
            
            

            // $query->andFilterWhere(['like', 'UserName', $this->UserName]);
            
            //->andFilterWhere(['<>', 'Priority', 'I'])  // ***  fix condition  // ไม่เอา IDLE
            /*
                18/8/2017 show IDlE ให้ทาง RD  (k.นิด) 
                25/8/2017 hide IDlE (k.parun,k.นิด) 
                3/10/2017 show IDlE RD  (k.จีด) 
            */
            ->andFilterWhere(['<>', 'ProdDet.Status', 'C']);  // ***  fix condition  // ไม่เอา Close
        

            

/*            
          echo '<br><br><br>';
            echo $query->createCommand()->getRawSql();
*/            
        return $dataProvider;
    }


    public function search($params)
    {
        $query = ProdDet::find();

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
            'Order_Qty' => $this->Order_Qty,
            'Rlse_Qty' => $this->Rlse_Qty,
            'Rlse_Date' => $this->Rlse_Date,
            'Due_Date' => $this->Due_Date,
        ]);

        $query->andFilterWhere(['like', 'Order_No', $this->Order_No])
            ->andFilterWhere(['like', 'ProdDet.Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'Priority', $this->Priority])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'UserName', $this->UserName]);

        return $dataProvider;
    }
    public function attributeLabels()
    {
        
        return [
            'Order_No' => 'Order  No',
            'Item_Number' => 'Item  Number',
            'Order_Qty' => 'Order  Qty',
            'Priority' => 'Priority',
            'Rlse_Qty' => 'Rlse  Qty',
            'Rlse_Date' => 'Rlse  Date',
            'Status' => 'Status',
            'Due_Date' => 'Due  Date',
            'UserName' => 'User Name',
            'Item_Name'=> 'รายละเอียด'
        ];
    }
}
