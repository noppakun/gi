<?php

namespace app\models;

use Yii;
use \app\components\XLib;


/**
 * This is the model class for table "x_pr".
 *
 * @property string $doc_no
 * @property string $doc_date
 * @property string|null $ref_doc_no
 * @property string|null $supp_name
 * @property string|null $shipto
 * @property string|null $remark
 * @property string|null $dept_code
 * @property string|null $vat_type
 * @property float|null $vat_percent
 * @property float|null $vat_amount
 * @property float|null $amount
 * @property float|null $total_amount
 * @property string|null $prepare_user
 * @property string|null $prepare_date
 * @property string|null $review_user
 * @property string|null $review_date
 * @property string|null $dp_approve_user
 * @property string|null $dp_approve_date
 * @property string|null $dp_reject_user
 * @property string|null $dp_reject_date
 * @property string|null $md_approve_user
 * @property string|null $md_approve_date
 * @property string|null $md_reject_user
 * @property string|null $md_reject_date
 * @property string|null $last_update_user
 * @property string|null $last_update_date
 * @property string|null $po_create_user
 * @property string|null $po_create_date
 * @property int|null $value_req_md_approve
 */
class XPr extends \yii\db\ActiveRecord
{
    // public function getCal_docstatus()
    // {
    //     $_ret = 'PP';
    //     if (1 !== 1) {
    //     } elseif ($this->md_reject_user !== null) {
    //         $_ret = 'MR';
    //     } elseif ($this->md_approve_user !== null) {
    //         $_ret = 'MA';
    //     } elseif ($this->dp_reject_user !== null) {
    //         $_ret = 'DR';
    //     } elseif ($this->dp_approve_user !== null) {
    //         $_ret = 'DA';
    //     } elseif ($this->review_user !== null) {
    //         $_ret = 'RV';
    //     }
    //     return $_ret;
    // }

    // Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, function ($event) {
    //     Yii::debug(get_class($event->sender) . ' is inserted');
    // });
    public function afterFind()
    //-------------------------
    {
        parent::afterFind();
        $this->doc_date = XLib::dateConv($this->doc_date, 'a');
        $this->prepare_date = XLib::dateTimeConv($this->prepare_date, 'a');
        $this->review_date = XLib::dateTimeConv($this->review_date, 'a');
        $this->dp_approve_date = XLib::dateTimeConv($this->dp_approve_date, 'a');
    }
    public function beforeSave($insert)
    //---------------------------------
    {
        if ($insert) { // กรณีรายการใหม่ gen เลขที่อีกครั้งก่อน save ป้องกันการซ้ำจากการกด create พร้อมกัน
            $this->doc_no =  $this->genDocNumber();
        }
        $this->doc_date = XLib::dateConv($this->doc_date, 'b');
        $this->review_date = XLib::dateTimeConv($this->review_date, 'b');
        $this->prepare_date = XLib::dateTimeConv($this->prepare_date, 'b');


        return parent::beforeSave($insert);;
    }

    public function genDocNumber()
    //-------------------------
    {
        $prefix = 'PR'
            . substr('0' . (date('y') + 0), -2)
            . substr('0' . (date('m') + 0), -2);
        $lastdoc = $this->find()
            ->select('max(doc_no) as doc_no')
            ->where(['left(doc_no,6)' => $prefix])
            ->one();
        return $prefix . substr('0000' . (($lastdoc) ? (substr($lastdoc->doc_no, 6, 4) + 1) : 1), -4);
    }

    /*********************************************************************************
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'x_pr';
    }

    /**
     * {@inheritdoc}
     */


    public function rules()
    {
        return [
            [['doc_no', 'doc_date'], 'required'],
            [['doc_date', 'prepare_date', 'review_date', 'dp_approve_date', 'dp_reject_date', 'md_approve_date', 'md_reject_date', 'last_update_date', 'po_create_date'], 'safe'],
            [['vat_percent', 'vat_amount', 'amount', 'total_amount'], 'number'],
            [['value_req_md_approve'], 'integer'],
            [['doc_no'], 'string', 'max' => 12],
            [['ref_doc_no'], 'string', 'max' => 20],
            [['supp_name', 'shipto', 'remark'], 'string', 'max' => 100],
            [['dept_code'], 'string', 'max' => 3],
            [['vat_type'], 'string', 'max' => 1],
            [['prepare_user', 'review_user', 'dp_approve_user', 'dp_reject_user', 'md_approve_user', 'md_reject_user', 'last_update_user', 'po_create_user'], 'string', 'max' => 10],
            [['doc_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'doc_no' => 'เลขที่เอกสาร',
            'doc_date' => 'วันที่เอกสาร',
            'ref_doc_no' => 'เลขที่อ้างอิง',
            'supp_name' => 'ผู้จำหน่าย',
            'shipto' => 'ส่งของที่',
            'remark' => 'หมายเหตุ',
            'dept_code' => 'แผนก',
            'vat_type' => 'ประเภทภาษี',
            'vat_percent' => 'อัตราภาษีร้อยละ',
            'vat_amount' => 'Vat Amount',
            'amount' => 'Amount',
            'total_amount' => 'Total Amount',
            'prepare_user' => 'ผู้จัดเตรียม',
            'prepare_date' => 'Prepare Date',
            'review_user' => 'Review User',
            'review_date' => 'Review Date',
            'dp_approve_user' => 'Dp Approve User',
            'dp_approve_date' => 'Dp Approve Date',
            'dp_reject_user' => 'Dp Reject User',
            'dp_reject_date' => 'Dp Reject Date',
            'md_approve_user' => 'Md Approve User',
            'md_approve_date' => 'Md Approve Date',
            'md_reject_user' => 'Md Reject User',
            'md_reject_date' => 'Md Reject Date',
            'last_update_user' => 'Last Update User',
            'last_update_date' => 'Last Update Date',
            'po_create_user' => 'Po Create User',
            'po_create_date' => 'Po Create Date',
            'value_req_md_approve' => 'Value Req Md Approve',
        ];
    }
}
