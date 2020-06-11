<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "x_query".
 *
 * @property int $id
 * @property string $code
 * @property string $description
 * @property string $query
 * @property string $colsoption
 */
class XQuery extends \yii\db\ActiveRecord
{
    private $tablenote;
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'x_query';
    }

    /**
     * {@inheritdoc}
     */
    public function getTablenote()
    {
        return '
        exp : colsoption = 
        {
            "columns":{
                        "order_date":{
                                    "DateFormat":"dd-MM-yyyy"
                        },
                            "price":{
                                    "NumberFormat":"#,##0.00"

                        }
            }
        }
        ';
    }    

    public function rules()
    {
        return [
            [['code', 'description', 'query', 'colsoption'], 'string'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'description' => 'Description',
            'query' => 'Query',
            'colsoption' => 'Colsoption ( JSON )',
        ];
    }
}
