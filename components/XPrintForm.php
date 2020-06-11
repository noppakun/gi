<?php

namespace app\components;

use kartik\mpdf\Pdf;
use yii\helpers\Html;
use app\components\gihelper;


// ----------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------
// Start and default use in  **********  app\controllers\Xpdr *************** 
// ----------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------
class XPrintForm extends \yii\base\BaseObject 
//class XPrintForm extends  kartik\mpdf\Pdf
// ----------------------------------------------------------------------------------------
{
    public $model;
    public $rows;
    public $params;
    public $modelCompare;
    public $rowCompareD;
    public function __construct($model, $rows = [], $params = [])
    {
        $this->model = $model;
        $this->rows = $rows;
        $this->params = $params;
        $this->modelCompare = $this->params['modelCompare'];
        $this->rowCompareD = isset($this->params['rowCompareD'])
            ? $this->params['rowCompareD']
            : null;

 
    }

    public function renderSubRowHeader()
    { }

    public function renderSubRow($row)
    { }

    public function renderRow($row)
    { }

    protected function tr($tds = [], $options = [])
    {
        $_td = '';
        foreach ($tds as $td) {
            $_td .= Html::tag('td', $td[0], (isset($td[1]) ? $td[1] : []));
        }
        return html::tag(
            'tr',
            $_td,
            $options
        );
    }
    // dl Data & Label        
    protected function dl($fieldName, $labelOnly = false, $decimals = false, $compare = true)
    {
        if ($decimals === false) {
            $_value = $this->model->attributes[$fieldName];
            $same = (rtrim($_value) == rtrim($this->modelCompare->attributes[$fieldName]));
        } else {
            $_value = number_format($this->model->attributes[$fieldName], $decimals);
            $same = (rtrim($_value) == rtrim(number_format($this->modelCompare->attributes[$fieldName], $decimals)));
        }
        //$_value = (trim($this->model->cust_no)=='@emptyform')?'':$_value ;         
        //pummmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm
        $_label = $this->model->attributeLabels()[$fieldName];
        // if (\Yii::$app->user->identity->username == 'noppakun') {
        if ($compare and (!$same)) {
            $_label = '<font color="red">' . $_label . '</font>';
        }
        //}
        return $_label . ($labelOnly ? '' : ' : ' . $_value);
    }
    public function renderPageDetail($rows)
    {
        // for create empty form register to DC
        if (trim($this->model->cust_no) == '@emptyform') {
            $this->model->user_inform = '';
            $this->model->doc_date = '';
            $this->model->sample_req_date = '';
            $this->model->price_req_date = '';
        }

        $_header =
            $this->tr([['<br>']])
            . $this->tr([
                [
                    Html::tag('h3', 'ใบแจ้งเพื่อขอให้พัฒนาผลิตภัณฑ์<br>( Requisition for New Product Development Record )'),
                    [
                        'style' => 'text-align: center',
                        'colspan' => "2"
                    ]
                ]
            ])
            . $this->tr([['<br>']]);
        $content2 = $_header .
            $this->tr([
                [$this->dl('cust_name')],
                [$this->dl('doc_no', false, false, false), ['style' => 'text-align: right;']],
            ])
            . $this->tr([
                [$this->dl('product_name')],
            ])
            . $this->tr([
                [$this->dl('product_cat', true) . ' : ' .  \app\models\xpdr::$product_cat_LIST[$this->model->product_cat]
                    . ($this->model->product_cat == '9' ? '  ' . $this->model->product_cat_other : '')]
            ])
            . $this->tr([
                [$this->dl('description')],
            ])
            . $this->tr([
                [$this->dl('active_ingredients'), ['colspan' => '2']],
            ])
            . $this->tr([
                [$this->dl('appearance')],
            ])
            . $this->tr([
                [$this->dl('color')],
            ])
            . $this->tr([
                [$this->dl('taste')],
            ])
            . $this->tr([
                [$this->dl('odor')],
            ])
            . $this->tr([
                [$this->dl('viscosity')],
            ])
            . $this->tr([
                [$this->dl('bubble')],
            ])
            . $this->tr([
                [$this->dl('other')],
            ])
            . $this->tr([
                [$this->dl('benchmark'), ['colspan' => '2']],
            ])
            . $this->tr([
                [$this->dl('feeling_after_use'), ['colspan' => '2',]],
            ])
            . $this->tr([
                [$this->dl('target_group')],
            ])
            . $this->tr([
                [$this->dl('packaging_conclude', true) . ' : ' . ($this->model->packaging_conclude ? 'สรุปแล้ว' : 'รอสรุป')],
            ])
            . $this->tr([
                [$this->dl('size_text')],
                [$this->dl('order_text')],
            ])
            . $this->tr([
                ['วันที่ต้องการตัวอย่าง : ' . $this->model->sample_req_date, ['width' => '50%']],
                ['วันที่ต้องการราคา : ' . $this->model->price_req_date . '<br><br><br>'],
            ])
            . $this->tr([['<br>', ['style' => 'border-top:1pt solid', 'colspan' => '2', 'width' => '100%']]])
            . $this->tr(
                [
                    [
                        'ผู้แจ้ง : ' . $this->model->user_inform . '<br>' . $this->model->doc_date . '<br>Customer / BD',
                        ['style' => 'text-align: center', 'width' => '50%']
                    ],
                    [
                        'ผู้อนุมัติ : ' . $this->model->user_approve . '<br>' . $this->model->user_approve_date . '<br>BD Manager',
                        [
                            'style' => 'text-align: center', 'width' => '50%'
                        ],

                    ],
                ]
            )
            . $this->tr([['<br>']])
            . $this->tr([['<br>', ['style' => 'border-top:1pt solid', 'colspan' => '2', 'width' => '100%']]])
            . $this->tr([
                [
                    'ผลตอบรับงานวิจัยและพัฒนาผลิตภัณฑ์',
                    [
                        'colspan' => '2',
                        'style' => 'text-align: center',
                        'width' => '100%'
                    ]

                ]
            ])
            . $this->tr([
                [
                    ($this->model->manager_accept == 'Y' ? 'Yes' : ($this->model->manager_accept == 'N' ? 'No' : '-')), [
                        'colspan' => '2',
                        'width' => '100%',
                        'style' => 'text-align: center'
                    ]
                ]
            ])
            . $this->tr([
                [
                    'Remark : ' . $this->model->manager_remark,
                    [
                        'colspan' => '2',
                        'width' => '100%'
                    ]
                ]
            ])

            . $this->tr([
                [
                    'R&D Manager : ' . $this->model->manager_approve . '<br>' . $this->model->manager_approve_date . '',
                    [
                        'colspan' => '2',
                        'width' => '100%',
                        'height' => '100%',
                        'style' => 'text-align: center; '
                    ],
                ],
            ])
            . $this->tr([['<br>']]);
        $content = Html::tag(
            'table',
            $content2,
            [
                'class' => 'formBody',
                'width' => '100%',
                'style' => "border:1pt solid black; "
            ]
        );
        $image_file = $this->params['IMAGE_PATH'] . $this->model->doc_no . '.jpg';
        if (file_exists($image_file)) {
            $content .= Html::img(
                $image_file,
                ['style' => 'border:1pt solid;' . 'display: block; margin-left: auto; margin-right: auto;width:100%;']
            );
        }
        return $content;
    }
    public function renderPageHeader()
    {
        return
            Html::tag(
                'table',
                $this->tr([
                    [Html::tag('h5', gihelper::comp_name()), ['style' => 'vertical-align:top']],
                ])
            );
    }
    protected function renderPageFooter()
    {
        return 'FM017 Rev.2  :  Effective : 20/06/2019';
    }
    private function _ifCfg($key, $value)
    {
        return isset($this->params[$key]) ? $this->params[$key] : $value;
    }    
    public function print()
    {
        
         //\app\components\XLib::xprint_r($this->rowCompareD); 
         //\app\components\XLib::xprint_r('ssss'); 
         //return;
        // -------------------------------
        // for get 4 month report
        ini_set('max_execution_time', 300);
        ini_set("pcre.backtrack_limit", "10000000");
        // -------------------------------

        $content = $this->renderPageDetail($this->rows);

        $Pdfparam = [
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,

            'marginTop' => 15,
            'marginLeft' => 3,
            'marginRight' => 3,
            'marginBottom' => 15,
            //'marginFooter'=>30,           

            'content' => $content,
            'cssFile' => '@app/web/css/kv-mpdf-report.css',

            //'cssFile' => file_get_contents(\Yii::getAlias('@app').'/web/css/mpdf.css'),
            //'cssInline' => file_get_contents(\Yii::getAlias('@app').'/web/css/kv-mpdf.css'),    



            'cssInline' => '                
                .formBody {
                    font-size: 12px;
                    /* 
                    font-family: "saraban";    
                    font-size: 22px;
                    */
                
                }                
            ',
            'options' => [
                'defaultfooterline' => 0,                
                'showWatermarkText' => $this->_ifCfg('WatermarkText', false),                
            ],
            'methods' => [
                'SetWatermarkText'=> $this->_ifCfg('WatermarkText', null),
                'SetHTMLHeader' => [$this->renderPageHeader()],
                //'SetFooter' => ['@ {DATE d-m-Y - H:i:s}'],
                'SetFooter' => [$this->renderPageFooter()],
            ],
            'filename' => $this->model->doc_no,
        ];
        $pdf = new Pdf($Pdfparam);
        return $pdf->render();
        //$mpdf = $pdf->api;        
        //return $mpdf->Output('filename', 'I'); // call the mpdf api output as needed
    }
}
