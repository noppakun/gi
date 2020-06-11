<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "x_refdata".
 *
 * @property string $reftype 
 * @property string $refcode
 * @property string $refname
 */
 
 /*
    $reftype   PRI:Priority  JST:Job Status
 */
class XRefdata extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'x_refdata';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('erpdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reftype', 'refcode', 'refname'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reftype' => 'Reftype',
            'refcode' => 'Refcode',
            'refname' => 'Refname',
        ];
    }
}
// -------- XRefdataSearch ----------------------------------------------------
// -------- XRefdataSearch ----------------------------------------------------
// -------- XRefdataSearch ----------------------------------------------------
// -------- XRefdataSearch ----------------------------------------------------
// -------- XRefdataSearch ----------------------------------------------------
class XRefdataSearch extends XRefdata
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reftype', 'refcode', 'refname'], 'safe'],
            [['id'], 'integer'],
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
        $query = XRefdata::find();
        //->where(['reftype'=>'WCA']);

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
        ]);

        $query->andFilterWhere(['like', 'reftype', $this->reftype])
            ->andFilterWhere(['like', 'refcode', $this->refcode])
            ->andFilterWhere(['like', 'refname', $this->refname]);

        return $dataProvider;
    }
}
