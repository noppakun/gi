<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BomTemp;

/**
 * BomTempSearch represents the model behind the search form about `app\models\BomTemp`.
 */
class BomTempSearch extends BomTemp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Assembly', 'Formula_No', 'SpecNo', 'ProcessRemark', 'TransferRecord1', 'TransferRecord2', 'TransferRecord3', 'CompoundCode', 'EffectiveDate', 'RegNo', 'ProductType'], 'safe'],
            [['StandardBatchSize', 'Density', 'StandardYieldMin', 'StandardYieldMax'], 'number'],
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
        /*
         additional param  use in BomController
            $param = Yii::$app->request->queryParams;
            $param['SelectForm'] = $SelectForm;   
            $param['defaultOrder'] =  [
                'EffectiveDate' => SORT_DESC,
                'Assembly' => SORT_ASC,
            ];     
            $dataProvider = $searchModel->search($param);         
        */        
        $query = BomTemp::find();

        // add conditions that should always apply here
        if ( isset($params['SelectForm']) ){     
            if ($params['SelectForm']['checkbox']){                                                                      
                $query->andWhere(['between', 'EffectiveDate', 
                    date('Y-m-d', strtotime(str_replace('/', '-', $params['SelectForm']['date']))), 
                    date('Y-m-d', strtotime(str_replace('/', '-', $params['SelectForm']['date2'])))
                ]);            
            }
        }             
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 40,
            ],             
            'sort'=> ['defaultOrder' => (isset($params['defaultOrder']) ? $params['defaultOrder']:null)]
        ]);
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'StandardBatchSize' => $this->StandardBatchSize,
            'Density' => $this->Density,
            'EffectiveDate' => $this->EffectiveDate,
            'StandardYieldMin' => $this->StandardYieldMin,
            'StandardYieldMax' => $this->StandardYieldMax,
        ]);

 
  
        $query->andFilterWhere(['like', 'Assembly', $this->Assembly])
            ->andFilterWhere(['like', 'Formula_No', $this->Formula_No])
            ->andFilterWhere(['like', 'SpecNo', $this->SpecNo])
            ->andFilterWhere(['like', 'ProcessRemark', $this->ProcessRemark])
            ->andFilterWhere(['like', 'TransferRecord1', $this->TransferRecord1])
            ->andFilterWhere(['like', 'TransferRecord2', $this->TransferRecord2])
            ->andFilterWhere(['like', 'TransferRecord3', $this->TransferRecord3])
            ->andFilterWhere(['like', 'CompoundCode', $this->CompoundCode])
            ->andFilterWhere(['like', 'RegNo', $this->RegNo])
            ->andFilterWhere(['like', 'ProductType', $this->ProductType]);



        return $dataProvider;
    }
}
