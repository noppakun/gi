<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\XPr;

use Yii;

/**
 * XPrSearch represents the model behind the search form of `app\models\XPr`.
 */


class XPrSearchByUser extends XPrSearch
{

    public function review_deptcode_list()
    {
        $row = \app\models\XEmployeeExt::findOne(['gi_username' => Yii::$app->user->identity->username]);
        $deptcode_pr_review = [];
        if (trim($row->deptcode_pr_review) !== '') {
            $deptcode_pr_review = array_merge($deptcode_pr_review, array_map(function ($n) {
                return ($n);
            }, explode(",", $row->deptcode_pr_review)));
            //\app\components\XLib::xprint_r($deptcode_pr_reviews); 
        }
        return $deptcode_pr_review;
    }

    public function search_filter(&$query)
    {
        parent::search_filter($query);

        // acc 930 it 940'        

        // if (\Yii::$app->user->can('/@XPR/APPROVE')) {
        //     $query->andWhere(

        //         [
        //             'or',
        //             ['dept_code' => $this->review_deptcode_list()],
        //             ['prepare_user' => Yii::$app->user->identity->username],
        //             [
        //                 'and',
        //                 ['not', ['review_user' => null]],
        //                 ['dp_approve_user' => null],

        //             ]
        //         ]


        //     );
        // } elseif (\Yii::$app->user->can('/@XPR/VIEWALL')) {
        //     $query->andWhere(
        //         [
        //             'or',
        //             ['dept_code' => $this->review_deptcode_list()],
        //             ['prepare_user' => Yii::$app->user->identity->username],
        //             [
        //                 'and',
        //                 ['not', ['review_user' => null]],
        //                 ['not', ['dp_approve_user' => null]],
        //             ]

        //         ]
        //     );
        // } elseif (\Yii::$app->user->can('/@XPR/DP_APPROVE')) {
        //     $query->andWhere(
        //         [
        //             'and',
        //             ['dept_code' => $this->review_deptcode_list()],
        //             [$this->status() => 'REVIEW'],

        //             // ['prepare_user' => Yii::$app->user->identity->username],
        //         ]
        //     );
        // } else {    // prepare & review user
        //     $query->andWhere(
        //         [
        //             'or',
        //             ['dept_code' => $this->review_deptcode_list()],
        //             ['prepare_user' => Yii::$app->user->identity->username],
        //         ]
        //     );
        // }
    }
}
