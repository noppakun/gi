<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\XJobtracking;

/**
 * XJobtrackingSearch represents the model behind the search form of `app\models\XJobtracking`.
 */
class XJobtrackingSearch extends XJobtracking
{
     
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','cancel'], 'integer'],
            [['jobtype', 'detail', 'jobdate', 'duedate', 'finishdate', 'responsible_user', 'remark', 'owner_user'], 'safe'],
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
    public function search($params,$SelectForm=null)
    {
        //$query = XJobtracking::find();

        $query = XJobtracking::find()->orderBy([
            'duedate' => SORT_DESC,
            'id'=>SORT_ASC
        ]);

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
            //'jobdate' => $this->jobdate,
            // 'duedate' => $this->duedate,
            // 'finishdate' => $this->finishdate,
            'cancel' => $this->cancel,
 
        ]);
        if ($SelectForm !=null){
 
            $query->andFilterWhere(['between', 'jobdate', 
                date('Y-m-d', strtotime(str_replace('/', '-', $SelectForm['date']))), 
                date('Y-m-d', strtotime(str_replace('/', '-', $SelectForm['date2'])))
            ]);   
 
            if ($SelectForm['status'] != 0){                
                if ($SelectForm['status'] == 1){                                       
                    $query->andWhere(['finishdate' => null]);                                                
                    $query->andWhere(['cancel' => 0]);
                } else if ($SelectForm['status'] == 2){
                    $query->andWhere(['not',['finishdate' => null]]);
                } else if ($SelectForm['status'] == 3){
                    $query->andWhere(['cancel' => 1]);
                }
            }
  
        }
        
        $query->andFilterWhere(['like', 'jobtype', $this->jobtype])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'responsible_user', $this->responsible_user])
            ->andFilterWhere(['like', 'remark', $this->remark])

            ->andFilterWhere(['like', 'CONVERT(varchar(10), jobdate, 105)', $this->jobdate])
            ->andFilterWhere(['like', 'CONVERT(varchar(10), duedate, 105)', $this->duedate])
            ->andFilterWhere(['like', 'CONVERT(varchar(10), finishdate, 105)', $this->finishdate])

            //'jobdate' => $this->jobdate,

            ->andFilterWhere(['like', 'owner_user', $this->owner_user]);

        return $dataProvider;
    }
}
