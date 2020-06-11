<?php
/*

LAB TEST



*/

namespace app\components;


use yii\helpers\Html;

use app\components\gihelper;

/**
 * TestController implements the CRUD actions for Test model.
 */
// ----------------------------------------------------------------------------------------
class XReportContent extends \yii\base\Component
//implements   kartik\mpdf\Pdf
// ----------------------------------------------------------------------------------------
{
    /*
    table band
        report header // Title    as TABLE
            page header            
                /group header
                    /detail            
                /group footer            
            page footer
        report footer // summary as TABLE
    */


    // ------------------------     

    private $groupBands = null;
    private $detailBand = null;
    private $headerBand = null;
    private $footerBand = null;

    private $datarows;
    // -----------------
    private $groupHeadCount;
    private $groupBandLastRow;
    private $rbDetail;
    public function __construct($config)
    {
        $this->datarows = $config['datarows'];;
        $this->headerBand = isset($config['headerBand'])
            ? $config['headerBand']
            : function ($rows) {
                return $this->_headerBandDefault($rows);
            };

        $this->footerBand = isset($config['footerBand'])
            ? $config['footerBand'] : function () {
                return '</td></tr></table>';
            };
        $this->detailBand = isset($config['detailBand'])
            ? $config['detailBand']
            : function ($row) {
                return $this->_detailBandDefault($row);
            };


        // -------------------------
        $this->groupBands = isset($config['groupBands']) ? $config['groupBands'] : null;
    }

    private function _headerBandDefault($row)
    {
        $ret = '<table><thead><tr>';
        foreach ($row as $key => $value) {
            $ret .= '<td>' . $key . '</td>';
        }
        return $ret . '</tr></thead>';
    }
    private function _detailBandDefault($row)
    {
        $ret = '<tr>';
        foreach ($row as $key => $value) {
            $ret .= '<td>' . $value . '</td>';
        }
        return $ret . '</tr>';
    }

    private function _groupHFDefault($row, $id)
    {

        return Html::tag(
            'tr',
            ($id == 0
                ? ''
                : Html::tag(
                    'td',
                    '',
                    ['colspan' => $id]
                ))
                . Html::tag(
                    'td',
                    '[' . $this->groupBands[$id]['key'] . ' : ' . $row[$this->groupBands[$id]['key']] . ']',
                    ['colspan' => count($row) - $id, 'bgcolor' => '#cccccc']
                )
        );
    }



    private function _buildGroupFooter($id)
    {
        if ($this->groupBands != null) {
            for ($i = $this->groupHeadCount; $i > ($id - 1); $i--) {

                $groupFooter = isset($this->groupBands[$i]['groupFooter'])
                    ? $this->groupBands[$i]['groupFooter']
                    : function ($row, $_id) {
                        return $this->_groupHFDefault($row, $_id);
                    };

                $this->rbDetail .= ($groupFooter !== false) ? ($groupFooter)($this->groupBandLastRow, $i) : '';
                $this->groupHeadCount--;
            }
        }
    }
    public function genContent()
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



                        //groupHearderDefault

                        $groupHearder = isset($gb['groupHearder'])
                            ? $gb['groupHearder']
                            : function ($row, $id) {
                                return $this->_groupHFDefault($row, $id);
                            };

                        // print head     
                        //$this->rbDetail .= ($gb['groupHearder'])($row);

                        //$this->rbDetail .= ($groupHearder)($row, $id);
                        $this->rbDetail .= ($groupHearder !== false) ? ($groupHearder)($row, $id) : '';
                        $this->groupHeadCount++;
                    }
                }
            }
            // print detail
            $this->rbDetail .= ($this->detailBand)($row);
            $this->groupBandLastRow = $row;
        }

        $this->_buildGroupFooter(0);



        //$headerBand = $this->config['headerBand'];
        //\app\components\XLib::xprint_r($this->config);

        $content = ($this->headerBand)($this->datarows[0])
            . $this->rbDetail            
            . ($this->footerBand)();

        //\app\components\XLib::xprint_r($this->datarows);
        //\app\components\XLib::xprint_r($content);
        return $content;
    }
}
// ---------------------------------------------------------------------
// --------------------TEST-------------------------------------------------
// ---------------------------------------------------------------------

// $config = [
//     'datarows' => $rows,
//     '1headerBand' => function () {
//         return $this->headerBand1();
//     },
//     //'headerBand' => $this->headerBand1(),
                
//     '1detailBand' => function ($_row) {
//         return $this->detailBand1($_row);
//     },
//     '1groupBands' => [
//         [
//             'key' => 'CustomerTypeCode',
//             'groupHearder' => function ($row) {
//                 return $this->groupHearder1($row);
//             },
//             'groupFooter' => function ($row) {
//                 return $this->groupFooter1($row);
//             },
//         ],
//         [
//             'key' => 'Terms',
//             'groupHearder' => function ($row) {
//                 return $this->groupHearder2($row);
//             },
//             'groupFooter' => function ($row) {
//                 return $this->groupFooter2($row);
//             },
//         ]

//     ]
// ];
// $xqr = new \app\components\XReportContent($config);
// return $xqr->genContent();;        

// }
