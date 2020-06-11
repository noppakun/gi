<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "level2".
 *
 * @property string $Level1Code
 * @property string $Level2Code
 * @property string $Level2Desc
 * @property string $TypeCode
 * @property string $CategoryCode
 * @property string $Level2Doc
 * @property string $Level2Date
 * @property string $Expiredate
 * @property string $UserName
 * @property string $DeptCode
 * @property string $ResponCode
 * @property integer $ReviseNo
 * @property string $Level2workfile
 * @property string $Level2workFile2
 * @property string $Level2workFile3
 * @property string $Level2workFile4
 * @property string $Level2workFile5
 * @property string $Level2workFile6
 * @property string $Level2workFile7
 * @property string $Level2workFile8
 * @property string $Level2workFile9
 * @property string $Level2workFile10
 * @property string $Level2workFile11
 * @property string $Level2workFile12
 * @property string $Level2WorkText
 * @property string $Level2WorkText2
 * @property string $Level2WorkText3
 * @property string $DcCode
 * @property string $Orientation
 * @property integer $CompressStatus
 * @property resource $Level2WorkTextCompress
 * @property resource $Level2WorkTextCompress2
 * @property resource $Level2WorkTextCompress3
 * @property string $DepartCode
 */
class Level2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'level2';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('isodb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Level1Code', 'Level2Code'], 'required'],
            [['Level1Code', 'Level2Code', 'Level2Desc', 'TypeCode', 'CategoryCode', 'Level2Doc', 'UserName', 'DeptCode', 'ResponCode', 'Level2workfile', 'Level2workFile2', 'Level2workFile3', 'Level2workFile4', 'Level2workFile5', 'Level2workFile6', 'Level2workFile7', 'Level2workFile8', 'Level2workFile9', 'Level2workFile10', 'Level2workFile11', 'Level2workFile12', 'Level2WorkText', 'Level2WorkText2', 'Level2WorkText3', 'DcCode', 'Orientation', 'Level2WorkTextCompress', 'Level2WorkTextCompress2', 'Level2WorkTextCompress3', 'DepartCode'], 'string'],
            [['Level2Date', 'Expiredate'], 'safe'],
            [['ReviseNo', 'CompressStatus'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Level1Code' => 'Level1 Code',
            'Level2Code' => 'Level2 Code',
            'Level2Desc' => 'Level2 Desc',
            'TypeCode' => 'Type Code',
            'CategoryCode' => 'Category Code',
            'Level2Doc' => 'Level2 Doc',
            'Level2Date' => 'Level2 Date',
            'Expiredate' => 'Expiredate',
            'UserName' => 'User Name',
            'DeptCode' => 'Dept Code',
            'ResponCode' => 'Respon Code',
            'ReviseNo' => 'Revise No',
            'Level2workfile' => 'Level2workfile',
            'Level2workFile2' => 'Level2work File2',
            'Level2workFile3' => 'Level2work File3',
            'Level2workFile4' => 'Level2work File4',
            'Level2workFile5' => 'Level2work File5',
            'Level2workFile6' => 'Level2work File6',
            'Level2workFile7' => 'Level2work File7',
            'Level2workFile8' => 'Level2work File8',
            'Level2workFile9' => 'Level2work File9',
            'Level2workFile10' => 'Level2work File10',
            'Level2workFile11' => 'Level2work File11',
            'Level2workFile12' => 'Level2work File12',
            'Level2WorkText' => 'Level2 Work Text',
            'Level2WorkText2' => 'Level2 Work Text2',
            'Level2WorkText3' => 'Level2 Work Text3',
            'DcCode' => 'Dc Code',
            'Orientation' => 'Orientation',
            'CompressStatus' => 'Compress Status',
            'Level2WorkTextCompress' => 'Level2 Work Text Compress',
            'Level2WorkTextCompress2' => 'Level2 Work Text Compress2',
            'Level2WorkTextCompress3' => 'Level2 Work Text Compress3',
            'DepartCode' => 'Depart Code',
        ];
    }
}
