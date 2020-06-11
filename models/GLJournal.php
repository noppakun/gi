<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "GLJournal".
 *
 * @property string $CompanyCode
 * @property string $GLBookCode
 * @property string $VoucherNo
 * @property string $VoucherDate
 * @property string $Remark
 * @property string $UserName
 * @property string $Updatetime
 * @property int $PostStatus
 * @property string $CompanyCodeFrom
 * @property string $DocType
 * @property string $VoucherNoFrom
 * @property string $ApplType
 * @property string $BranchCode
 * @property int $POSTLock
 */
class GLJournal extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'GLJournal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyCode', 'GLBookCode', 'VoucherNo', 'VoucherDate'], 'required'],
            [['CompanyCode', 'GLBookCode', 'VoucherNo', 'Remark', 'UserName', 'CompanyCodeFrom', 'DocType', 'VoucherNoFrom', 'ApplType', 'BranchCode'], 'string'],
            [['VoucherDate', 'Updatetime'], 'safe'],
            [['PostStatus', 'POSTLock'], 'integer'],
            [['CompanyCode', 'GLBookCode', 'VoucherNo'], 'unique', 'targetAttribute' => ['CompanyCode', 'GLBookCode', 'VoucherNo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyCode' => 'Company Code',
            'GLBookCode' => 'Glbook Code',
            'VoucherNo' => 'Voucher No',
            'VoucherDate' => 'Voucher Date',
            'Remark' => 'Remark',
            'UserName' => 'User Name',
            'Updatetime' => 'Updatetime',
            'PostStatus' => 'Post Status',
            'CompanyCodeFrom' => 'Company Code From',
            'DocType' => 'Doc Type',
            'VoucherNoFrom' => 'Voucher No From',
            'ApplType' => 'Appl Type',
            'BranchCode' => 'Branch Code',
            'POSTLock' => 'Postlock',
        ];
    }
}
