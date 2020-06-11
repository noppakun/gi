<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Approve_Bulk".
 *
 * @property int $Docno
 * @property string $Item_Number
 * @property string $FormulaNo
 * @property string $SpecNo
 * @property string $Ana_No
 * @property string $BatchNo
 * @property string $BatchSize
 * @property string $Uom
 * @property string $Mfg_Date
 * @property string $Exp_Date
 * @property string $Ana_Date
 * @property string $RegNo
 * @property string $Results
 * @property string $Remarks
 * @property string $Jobno
 * @property string $UserName
 * @property string $QA_ReceiveDate
 * @property string $QA_DeterDate
 * @property string $QA_ReleaseNo
 * @property string $QA_AnalysisDate
 */
class ApproveBulk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Approve_Bulk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Docno', 'Item_Number', 'Ana_No', 'BatchNo', 'BatchSize', 'Uom', 'Jobno'], 'required'],
            [['Docno'], 'integer'],
            [['Item_Number', 'FormulaNo', 'SpecNo', 'Ana_No', 'BatchNo', 'Uom', 'RegNo', 'Results', 'Remarks', 'Jobno', 'UserName', 'QA_ReleaseNo'], 'string'],
            [['BatchSize'], 'number'],
            [['Mfg_Date', 'Exp_Date', 'Ana_Date', 'QA_ReceiveDate', 'QA_DeterDate', 'QA_AnalysisDate'], 'safe'],
            [['Docno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Docno' => 'Docno',
            'Item_Number' => 'Item  Number',
            'FormulaNo' => 'Formula No',
            'SpecNo' => 'Spec No',
            'Ana_No' => 'Ana  No',
            'BatchNo' => 'Batch No',
            'BatchSize' => 'Batch Size',
            'Uom' => 'Uom',
            'Mfg_Date' => 'Mfg  Date',
            'Exp_Date' => 'Exp  Date',
            'Ana_Date' => 'Ana  Date',
            'RegNo' => 'Reg No',
            'Results' => 'Results',
            'Remarks' => 'Remarks',
            'Jobno' => 'Jobno',
            'UserName' => 'User Name',
            'QA_ReceiveDate' => 'Qa  Receive Date',
            'QA_DeterDate' => 'Qa  Deter Date',
            'QA_ReleaseNo' => 'Qa  Release No',
            'QA_AnalysisDate' => 'Qa  Analysis Date',
        ];
    }
}
