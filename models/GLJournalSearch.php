<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GLJournal;

/**
 * GLJournalSearch represents the model behind the search form of `app\models\GLJournal`.
 */
class GLJournalSearch extends GLJournal
{
    public $tryear;
    public $prefix;
    public $_new_glbookcode;
    public $_new_prefix;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'GLBookCode', 'VoucherNo', 'VoucherDate', 'Remark', 'UserName', 'Updatetime', 'CompanyCodeFrom', 'DocType', 'VoucherNoFrom', 'ApplType', 'BranchCode'], 'safe'],
            [['PostStatus', 'POSTLock'], 'integer'],

            [['tryear'], 'integer'],
            [['prefix','_new_glbookcode', '_new_prefix'], 'safe'],
            
            
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
       

      //  $query = GLJournal::find();

        $query = GLJournal::find()->from(['t' => '(SELECT *   FROM GLJournal)'])
            ->select(['t.*,year(VoucherDate) as tryear,left(voucherno,2) as prefix']);
            


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
            'VoucherDate' => $this->VoucherDate,
            'Updatetime' => $this->Updatetime,
            'PostStatus' => $this->PostStatus,
            'POSTLock' => $this->POSTLock,
            'year(VoucherDate)' => $this->tryear,
            'left(voucherno,2)'=> $this->prefix,
        ]);

        $query->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'GLBookCode', $this->GLBookCode])
            ->andFilterWhere(['like', 'VoucherNo', $this->VoucherNo])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'CompanyCodeFrom', $this->CompanyCodeFrom])
            ->andFilterWhere(['like', 'DocType', $this->DocType])
            ->andFilterWhere(['like', 'VoucherNoFrom', $this->VoucherNoFrom])
            ->andFilterWhere(['like', 'ApplType', $this->ApplType])            
            ->andFilterWhere(['like', 'BranchCode', $this->BranchCode]);
            

        return $dataProvider;
    }
}
