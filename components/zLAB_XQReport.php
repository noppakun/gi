<?php
/*

LAB TEST



*/ 
namespace app\components;


use yii\helpers\Html;
use kartik\mpdf\Pdf;
use app\components\gihelper;

/**
 * TestController implements the CRUD actions for Test model.
 */
// ----------------------------------------------------------------------------------------
class XQReport extends \yii\base\Component
//implements   kartik\mpdf\Pdf
// ----------------------------------------------------------------------------------------
{
    /*
    report config
        datarows

            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,

            'marginTop' => 10,
            'marginLeft' => 10,
            'marginRight' => 10,
            'marginBottom' => 10,

    table band
        report header // Title    as TABLE
            page header            
                /group header
                    /detail            
                /group footer            
            page footer
        report footer // summary as TABLE
        

    


    */


    private $pageHeader = null;
    private $pageFooter = null;
    // ------------------------     
    private $headerBand = null;
    private $groupBands = null;
    private $detailBand = null;
    private $footerBand = null;




    private $datarows;
    // -----------------
    private $groupHeadCount;
    private $groupBandLastRow;
    private $rbDetail;


    public function __construct($config)
    {

        $this->pageHeader = isset($config['pageHeader'])
            ? $config['pageHeader'] : function () {
                return Html::tag(
                    'table',
                    Html::tag(
                        'tr',
                        Html::tag(
                            'td',
                            Html::tag('h5', gihelper::comp_name(), ['style' => 'vertical-align:top'])
                        )
                    )
                );
            };
        $this->pageFooter = isset($config['pageFooter'])
            ? $config['pageFooter'] : function () {
                return '';
            };

        $this->datarows = $config['datarows'];;
        $this->headerBand = isset($config['headerBand'])
            ? $config['headerBand'] : function () {
                return '<table>';
            };

        $this->footerBand = isset($config['footerBand'])
            ? $config['footerBand'] : function () {
                return '</table>';
            };
        $this->detailBand = $config['detailBand'];
        // -------------------------
        $this->groupBands = isset($config['groupBands']) ? $config['groupBands'] : null;
    }
    private function _buildGroupFooter($id)
    {
        for ($i = $this->groupHeadCount; $i > ($id - 1); $i--) {
            $this->rbDetail .= ($this->groupBands[$i]['groupFooter'])($this->groupBandLastRow);
            $this->groupHeadCount--;
        }
    }
    public function print()
    {

        $this->rbDetail = '';
        $this->groupBandLastRow = null;

        $this->groupHeadCount = -1;



        // loop every row        
        foreach ($this->datarows as $rownumber => $row) {
            // if set a group 
            if ($this->groupBands != null) {
                $_currkey = [];
                $_lastkey = [];
                // ------------------------------------------
                // loop array of groupBands              
                foreach ($this->groupBands as $id => $gb) {

                    $_currkey[] = $row[$gb['key']];
                    $_lastkey[] = $this->groupBandLastRow[$gb['key']];
                    if (($_currkey != $_lastkey)) {
                        $this->_buildGroupFooter($id);

                        // print head     
                        $this->rbDetail .= ($gb['groupHearder'])($row);
                        $this->groupHeadCount++;
                    }
                }
            }
            // print detail
            $this->rbDetail .= ($this->detailBand)($row);
            $this->groupBandLastRow = $row;
        }
        if ($this->groupBands != null) {
            $this->_buildGroupFooter(0);
        }

        $content =
            //($this->reportHeaderBand)()
            //.$_HBf()
            ($this->headerBand)()
            . $this->rbDetail
            . ($this->footerBand)();

        //return $content;


        $Pdfparam = [
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,

            'marginTop' => 15,
            'marginLeft' => 3,
            'marginRight' => 3,
            'marginBottom' => 15,


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
            ],
            'methods' => [
                //'SetHTMLHeader' => [($this->headerBand)()],
                //'SetHeader' => [($this->headerBand)()],
                //'SetHTMLHeader' => ['xxxxxxxxxxxxxxxxxxxx'],
                //'SetFooter' => ['@ {DATE d-m-Y - H:i:s}'],
                'SetFooter' => [($this->pageFooter)()],
            ],
            'filename' => 'XQReport',
        ];
        $pdf = new Pdf($Pdfparam);
        return $pdf->render();
    }
}

// -----------------------------------------------------------------
// ------------------------ FOR LAB TEST -------------------------------
// -----------------------------------------------------------------

// <?php

// namespace app\controllers;

// use Yii;

// use yii\web\Controller;
// use yii\helpers\Html;
// use app\components\XQReport;



// // -----------------------------------------------------------------
// // -----------------------------------------------------------------
// // -----------------------------------------------------------------
// class TestController extends Controller
// {


//     private function groupHearder2($row)
//     {
//         return Html::tag(
//             'tr',
//             Html::tag(
//                 'td',
//                 ''
//             ) . Html::tag(
//                 'td',
//                 'HeaderB ' . $row['Terms'],
//                 ['colspan' => "3", 'bgcolor' => '#e6e600']
//             )
//         );
//     }
//     private function groupFooter2($row)
//     {
//         return Html::tag(
//             'tr',
//             Html::tag(
//                 'td',
//                 ''
//             ) . Html::tag(
//                 'td',
//                 'FooterB ' . $row['Terms'],
//                 ['colspan' => "3", 'bgcolor' => '#999900']
//             )
//         );
//     }

//     private function groupHearder1($row)
//     {
//         return Html::tag(
//             'tr',
//             Html::tag(
//                 'td',
//                 'HeaderA ' . $row['CustomerTypeCode'],
//                 ['colspan' => "4", 'bgcolor' => '#b31aff']
//             )
//         );
//     }
//     private function groupFooter1($row)
//     {
//         return Html::tag(
//             'tr',
//             Html::tag(
//                 'td',
//                 'FooterA  ' . $row['CustomerTypeCode'],
//                 ['colspan' => "4", 'bgcolor' => '#cc66ff']
//             )
//         );
//     }
//     private function headerBand1()
//     {

//         return '<table>' . Html::tag(
//             'thead',
//             Html::tag(
//                 'tr',
//                 Html::tag(
//                     'th',
//                     'CustomerTypeCode'
//                 ) . Html::tag(
//                     'th',
//                     'Terms'
//                 ) .  Html::tag(
//                     'th',
//                     'Cust_No'
//                 ) . Html::tag(
//                     'th',
//                     'Cust_Name'
//                 )

//             )
//         );
//     }
//     private function detailBand1($row)
//     {
//         return Html::tag(
//             'tr',
//             Html::tag(
//                 'td',
//                 $row['CustomerTypeCode']
//             ) . Html::tag(
//                 'td',
//                 $row['Terms']
//             ) .  Html::tag(
//                 'td',
//                 $row['Cust_No']
//             ) . Html::tag(
//                 'td',
//                 $row['Cust_Name']
//             )
//         );
//     }
//     public function actionIndex()
//     {
//         $sql = "select top 100  * from customer where CustomerTypeCode<>'' order by CustomerTypeCode, Terms,Cust_No";
//         $connection = \Yii::$app->erpdb;
//         $command = $connection->createCommand($sql);
//         $rows =  $command->queryAll();
//         $config = [
//             'datarows' => $rows,
//             'headerBand' => function () {
//                 return $this->headerBand1();
//             },
//             'detailBand' => function ($row) {
//                 return $this->detailBand1($row);
//             },
//             'groupBands' => [
//                 [
//                     'key' => 'CustomerTypeCode',
//                     'groupHearder' => function ($row) {
//                         return $this->groupHearder1($row);
//                     },
//                     'groupFooter' => function ($row) {
//                         return $this->groupFooter1($row);
//                     },
//                 ],
//                 [
//                     'key' => 'Terms',
//                     'groupHearder' => function ($row) {
//                         return $this->groupHearder2($row);
//                     },
//                     'groupFooter' => function ($row) {
//                         return $this->groupFooter2($row);
//                     },
//                 ]

//             ]
//         ];
//         $xqr = new XQReport($config);
//         return $xqr->print();
//     }
// }
