<?php

namespace app\controllers;

use Yii;
use app\models\StHeadSearch;
use app\models\SelectForm;

use app\components\gihelper;
use yii\helpers\Html;
use app\components\XReport;

// ----------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//----------------------------------------------------------------------------
class StockController extends \yii\web\Controller
{

    private $SelectForm;
    private function pageHeader1()
    {
        return
            Html::tag(
                'table',
                Html::tag(
                    'tr',
                    Html::tag(
                        'td',
                        Html::tag('h4', gihelper::comp_name())
                            . Html::tag(
                                'h5',
                                'ประเภทเอกสาร : ' . (\app\models\DocType::findOne(['DocType' => $this->SelectForm->doctype]))->DocTypeDesc
                                    . '<br>ช่วงวันที่ : ' . $this->SelectForm->date . ' ถึง : ' . $this->SelectForm->date2
                                    . '<br>บริษัท : (' . $this->SelectForm->co_code . ') ' . (\app\models\Company::findOne(['CompanyCode' => $this->SelectForm->co_code]))->CompanyName
                            )
                    )
                        . html::tag(
                            'td',
                            'รายงานความเคลื่อนไหวของสินค้า<br>'
                                . 'Page : {PAGENO}/{nbpg}'
                                . '<br>User : ' . Yii::$app->user->identity->username
                            //.'<br>@ {DATE d-m-Y H:i:s} '                     
                            ,
                            ['width' => '33%', 'style' => 'text-align: right; vertical-align:bottom']
                        )

                ),
                ['width' => '100%']
            ) .
            Html::tag(
                'table',
                Html::tag(
                    'thead',
                    Html::tag(
                        'tr',
                        Html::tag('th', 'วันที่', ['class' => 'hc1'])
                            . Html::tag('th', 'เลขที่เอกสาร', ['class' => 'hc2'])
                            . Html::tag('th', 'OrderNo.', ['class' => 'hc3'])
                            . Html::tag('th', 'JobNo.', ['class' => 'hc4'])
                            . Html::tag('th', 'Item', ['class' => 'hc5'])
                            . Html::tag('th', 'Remark', ['class' => 'hc6'])
                    )

                ),
                ['width' => '100%', 'style' => "border-top:1pt solid black; border-bottom:1pt solid black;border-width: thin;"]
            );
    }

    private function renderSubRowHeader()
    {


        return Html::tag(
            'thead',
            Html::tag(
                'tr',
                Html::tag('td', '', ['style' => 'width: 20px'])
                    . Html::tag('td', 'Item', ['style' => 'width: 70px '])
                    . Html::tag('td', 'Desc.', ['style' => 'width:  250px '])
                    . Html::tag('td', 'Ana No.', ['style' => 'width: 100px'])
                    . Html::tag('td', 'จำนวน', ['style' => 'width: 90px', 'class' => 'numfmt'])
                    . Html::tag('td', 'หน่วย', ['style' => 'width: 50px'])
                    . Html::tag('td', 'มูลค่า/หน่วย', ['style' => 'width: 90px', 'class' => 'numfmt'])
                    . Html::tag('td', 'มูลค่ารวม', ['style' => 'width: 100px', 'class' => 'numfmt'])
                    . Html::tag('td', 'Acc.Code', ['style' => 'width: 100px;padding-left:10px'])
                    . Html::tag('td', 'CS.', ['style' => 'width: 40px'])
                    . Html::tag('td', 'WH.', ['style' => 'width: 40px'])

            )
        );
    }

    private function renderSubRow($row)
    {

        return Html::tag(
            'tr',

            Html::tag('td', '')
                . Html::tag('td', $row['Item_Number'])
                . Html::tag('td', $row['Item_Desc'])
                . Html::tag('td', $row['Ana_No'])
                . Html::tag('td', number_format($row['Recv_Qty'] + $row['Issue_Qty'], 3), ['class' => 'numfmt'])
                . Html::tag('td', $row['item']->Uom)
                . Html::tag('td', number_format($row['UnitPrice'], 2), ['class' => 'numfmt'])
                . Html::tag('td', number_format($row['SumPrice'], 2), ['class' => 'numfmt'])
                . Html::tag('td', $row['AccountCode'], ['style' => 'padding-left:10px'])
                . Html::tag('td', $row['CsCode'])
                . Html::tag('td', $row['WhCode']),
            ['class' => 'DataCell_Detail']

        );
    }
    private function renderRow($row)
    {
        return
            Html::tag(
                'table',
                Html::tag(
                    'tr',
                    Html::tag('td', Yii::$app->formatter->asDate($row['DocDate']), ['class' => 'hc1'])
                        . Html::tag('td', $row['VoucherNo'], ['class' => 'hc2'])
                        . Html::tag('td', $row['Order_Number'], ['class' => 'hc3'])
                        . Html::tag('td', $row['JobNo'], ['class' => 'hc4'])
                        . Html::tag('td', $row['RefDoc'], ['class' => 'hc5'])
                        . Html::tag('td', $row['Remark'], ['class' => 'hc6'])
                ),
                ['style' => "width:100%"]
            );
    }
    private function content1($rows)
    {
        $content = '';
        foreach ($rows as $row) {
            $content .=
                $this->renderRow($row);
            $content2 = '';
            foreach ($row->stCard as $rowDetail) {
                $content2 .= $this->renderSubRow($rowDetail);
            };
            $content2 = $this->renderSubRowHeader() . $content2;

            $content .= Html::tag('table', $content2, [
                'style' => 'margin-bottom:5px;border-bottom:1pt solid black;border-width: thin;'
            ]);
        }
        return $content;
    }
    private function printMovement($rows)
    {
        $config = [
            //'datarows' => $rows,
            // 'pageHeader' => function () {
            //     return $this->pageHeader1();
            // },
            'pageHeader' => $this->pageHeader1(),
            'marginTop' => 43,
            'format' => 'Letter',
            


            'content' => $this->content1($rows),
            'title' => 'รายงานความเคลื่อนไหวของสินค้า',
            'cssInline' => '
                .hc1 { width:  100px ; }
                .hc2 { width:  100px ; }
                .hc3 { width:  100px ; }
                .hc4 { width:  100px ; }
                .hc5 { width:  150px ; } 
            ',

        ];
        $report = new XReport($config);
        return $report->print();
    }
    public function actionMovement()
    {


        $SelectForm = new SelectForm();
        //$SelectForm->labels['date']='วันที่ ของเข้า:';            
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->date       = Yii::$app->request->queryParams['SelectForm']['date'];
            $SelectForm->date2      = Yii::$app->request->queryParams['SelectForm']['date2'];
            $SelectForm->co_code    = Yii::$app->request->queryParams['SelectForm']['co_code'];
            $SelectForm->doctype    = Yii::$app->request->queryParams['SelectForm']['doctype'];
            $searchModel = new StHeadSearch();
            $rows = $searchModel->searchMovement($SelectForm);

            $this->SelectForm = $SelectForm;
            return $this->printMovement($rows);


            //$this->pdfBykartik($SelectForm,$rows);
            //$this->XReport($SelectForm,$rows);

        } else {
            $SelectForm->date       = Yii::$app->formatter->asDate('now - 1 months');
            $SelectForm->date2      = Yii::$app->formatter->asDate('now');
            $SelectForm->co_code    = 'GPM';
            $SelectForm->doctype    = 'I1';
        }


        return $this->render('movementSelect', [
            'SelectForm'    =>  $SelectForm,
        ]);
    }
}
