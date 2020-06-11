<?php

namespace app\controllers;

use yii;
use yii\data\ArrayDataProvider;
use yii\web\Response;
use app\models\SelectForm;
use yii\helpers\Html;
use app\components\gihelper;
use app\components\XLib;


global $g_amount, $g_payamount, $g_pending_amt;

class printEstimatereceipt
{

    private $rows;
    private $SelectForm;
    public function __construct($config)
    {
        $this->rows = $config['rows'];
        $this->SelectForm = $config['SelectForm'];
    }
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
                                'ปี : ' . $this->SelectForm->year .
                                    '   ไตรมาส / เดือน : ' .
                                    ($this->SelectForm->month == 0 ? 'ทั้งหมด' : $this->monthTextArray[$this->SelectForm->month])
                                    . '<br>ประเภทลูกค้า : ' . ($this->SelectForm->customertypecode == '*'
                                        ? 'ทั้งหมด'
                                        : (\app\models\CustomerType::findOne(['CustomerTypeCode' => $this->SelectForm->customertypecode]))->CustomerTypeDesc)
                                    . '  /  ลูกค้า : ' . ($this->SelectForm->cust_no == '*'
                                        ? 'ทั้งหมด'
                                        : (\app\models\Customer::findOne(['Cust_No' => $this->SelectForm->cust_no]))->Cust_Name)

                            ),
                        ['style' => 'vertical-align:bottom']
                    )
                        . html::tag(
                            'td',
                            'ประมาณการรับชำระ<br>'
                                . 'Page : {PAGENO}/{nbpg}'
                                . '<br>User : ' . Yii::$app->user->identity->username,
                            ['width' => '33%', 'style' => 'text-align: right; vertical-align:bottom']
                        )

                ),
                ['width' => '100%']
            );
    }
    private function _groupHeader1($row, $id)
    {
        return
            Html::tag(
                'tr',
                Html::tag(
                    'td',
                    $this->monthTextArray[$row['month']],
                    [
                        'colspan' => 9,
                        'style' => "padding-left: 15px;",
                        'bgcolor' => '#DCDCDC'
                    ]
                )

            );
    }

    private function _groupHeader2($row, $id)
    {
        global $g_amount, $g_payamount, $g_pending_amt;
        $g_amount = 0;
        $g_payamount = 0;
        $g_pending_amt = 0;
        return Html::tag(
            'tr',
            Html::tag('td', null)
                . Html::tag(
                    'td',
                    //'<u>'.$row['cust_name'].' ( '.$row['cust_no'].' )</u>',
                    '<span class="underline_text">' . $row['cust_name'] . ' ( ' . $row['cust_no'] . ' )</span>',
                    [
                        'colspan' => 5,
                        //'style' => 'border-bottom: 1pt solid ;'
                    ]
                )

        );
    }
    private function _groupFooter2($row, $id)
    {
        global $g_amount, $g_payamount, $g_pending_amt;
        $_st1 = 'border-bottom: 1pt solid ;';
        $_st1 = 'border-bottom: 1pt dotted ;';
        return Html::tag(
            'tr',
            //Html::tag('td', null)
            Html::tag(
                'td',
                '',
                [
                    'colspan' => 2,
                    'style' => $_st1,
                ]
            )
                . Html::tag(
                    'td',
                    'Sum',
                    [
                        'style' => $_st1,
                    ]
                )
                . Html::tag(
                    'td',
                    XLib::xnumber_format($g_amount, 2, ''),
                    [
                        'style' => $_st1,
                        'align' => "right",
                    ]
                )

                . Html::tag(
                    'td',
                    XLib::xnumber_format($g_payamount, 2, ''),
                    [
                        'style' => $_st1,
                        'align' => "right",
                    ]
                )
                . Html::tag(
                    'td',
                    XLib::xnumber_format($g_pending_amt, 2, ''),
                    [
                        'style' => $_st1,
                        'align' => "right",
                    ]
                ) . Html::tag(
                    'td',
                    '',
                    [
                        'colspan' => 3,
                        'style' => $_st1,
                    ]
                )


        );
    }


    private function _headerBand1($row)
    {



        $ret = '<table><thead>'
            . '<tr class="success">
                <th style="width: 12.5%;">เลขที่ใบกำกับฯ</th>
                <th style="width: 12.5%;">วันที่ใบกำกับฯ</th>
                <th style="width: 12.5%;">วันที่ครบกำหนด</th>
                <th style="width: 13.5%;">ยอดใบกำกับฯ</th>
                <th style="width: 13.5%;">ยอดชำระแล้ว</th>
                <th style="width: 12.5%;">ยอดค้างชำระ</th>
                <th style="width: 13.5%;">วันที่นัดชำระ</th>
                <th style="width: 12.5%;">เลขที่ใบวางบิล</th>
                <th style="width: 12.5%;">วันที่รับชำระ</th>
            </tr>'
            . '</thead>';
        return $ret;
    }


    private function _footerBand1()
    {

        $tamt = 0;
        $tpay = 0;
        array_walk($this->rows, function ($_row, $key) use (&$tamt, &$tpay) {
            $tamt += $_row['amount'];
            $tpay += $_row['payamount'];
        });
        $ret =  Html::tag(
            'tr',
            Html::tag('td', 'Summary', [
                'colspan' => 3, 'bgcolor' => '#DCDCDC'
            ])
                . Html::tag('td', XLib::xnumber_format($tamt, 2, ''), ['class' => 'numfmt', 'bgcolor' => '#DCDCDC'])
                . Html::tag('td', XLib::xnumber_format($tpay, 2, ''), ['class' => 'numfmt', 'bgcolor' => '#DCDCDC'])
                . Html::tag('td', XLib::xnumber_format($tamt - $tpay, 2, ''), ['class' => 'numfmt', 'bgcolor' => '#DCDCDC'])
                . Html::tag('td', null, [
                    'align' => "right",  'colspan' => 3, 'bgcolor' => '#DCDCDC',
                ])
        ) . '</table>';
        return   $ret;
    }
    private function _groupFooter1($row, $id)
    {
        $tamt = 0;
        $tpay = 0;
        $month = $row['month'];
        array_walk($this->rows, function ($_row, $key) use (&$tamt, &$tpay, $month) {
            $tamt += ($_row['month'] == $month ? $_row['amount'] : 0);
            $tpay += ($_row['month'] == $month ? $_row['payamount'] : 0);
        });

        return Html::tag(
            'tr',
            Html::tag('td', 'Sum : ' . $this->monthTextArray[$row['month']], ['colspan' => 3, 'bgcolor' => '#DCDCDC', 'style' => "padding-left: 15px;"])
                . Html::tag('td', XLib::xnumber_format($tamt, 2, ''), ['class' => 'numfmt', 'bgcolor' => '#DCDCDC'])
                . Html::tag('td', XLib::xnumber_format($tpay, 2, ''), ['class' => 'numfmt', 'bgcolor' => '#DCDCDC'])
                . Html::tag('td', XLib::xnumber_format($tamt - $tpay, 2, ''), ['class' => 'numfmt', 'bgcolor' => '#DCDCDC'])

                . Html::tag('td', null, ['colspan' => 3, 'bgcolor' => '#DCDCDC'])
        );
    }
    private function _detailBand1($row)
    {
        global $g_amount, $g_payamount, $g_pending_amt;
        $g_pending_amt += ($row['amount'] - $row['payamount']);
        $g_amount += $row['amount'];
        $g_payamount += $row['payamount'];
        $_arduedate = XLib::xisnull($row['arduedate'], XLib::xisnull($row['due_date_acc'], null));


        $ret =  Html::tag(
            'tr',
            Html::tag('td', $row['inv_number'])
                . Html::tag('td', XLib::xisnull(XLib::dateConv($row['inv_date'], 'a'), ''))
                . Html::tag('td', XLib::xisnull(XLib::dateConv($row['due_date'], 'a'), ''))
                . Html::tag('td', XLib::xnumber_format($row['amount'], 2, ''), ['class' => 'numfmt'])
                . Html::tag('td', XLib::xnumber_format($row['payamount'], 2, ''), ['class' => 'numfmt'])
                . Html::tag('td', XLib::xnumber_format($row['amount'] - $row['payamount'], 2, ''), ['class' => 'numfmt'])
                . Html::tag('td', XLib::xisnull(XLib::dateConv($_arduedate, 'a'), ''), ['style' => "padding-left: 15px;"])
                //. Html::tag('td', XLib::xisnull(XLib::dateConv($row['arduedate'], 'a'), ''), ['style' => "padding-left: 15px;"])
                . Html::tag('td', $row['arbillno'])
                . Html::tag('td', XLib::xisnull(XLib::dateConv($row['receive_date'], 'a'), ''))
        );

        return $ret;
    }

    public function print()
    {
        $this->monthTextArray = \app\components\XLib::monthTextArray + [
            21 => "Q1",
            22 => "Q2",
            23 => "Q3",
            24 => "Q4",
        ];
        $XReportContentConfig = [
            'datarows' => $this->rows,
            'headerBand' => function ($_row) {
                return $this->_headerBand1($_row);
            },
            'footerBand' => function () {
                return $this->_footerBand1();
            },
            'detailBand' => function ($_row) {
                return $this->_detailBand1($_row);
            },
            'groupBands' => [
                [
                    'key' => 'month',
                    'groupHearder' => function ($row, $id) {
                        return $this->_groupHeader1($row, $id);
                    },
                    'groupFooter' => function ($row, $id) {
                        return $this->_groupFooter1($row, $id);
                    },

                ],
                [
                    'key' => 'cust_name',
                    'groupHearder' => function ($row, $id) {
                        return $this->_groupHeader2($row, $id);
                    },
                    //'groupFooter' => false,
                    'groupFooter' => function ($row, $id) {
                        return $this->_groupFooter2($row, $id);
                    }
                ]
            ],

        ];
        $xrc = new \app\components\XReportContent($XReportContentConfig);
        //return $xqr->genContent();;    

        //return $this->pageHeader1();
        $XReportConfig = [

            // 'pageHeader' => function () {
            //     return $this->pageHeader1();
            // },
            'pageHeader' => $this->pageHeader1(),
            'marginTop' => 31,
            'orientation' => 'P',
            'content' => $xrc->genContent(),
            // 'SetWatermarkText' => ['preview',.07],
            'cssInline' => ' 
                .underline_text {                
                    border-bottom: solid 1px #000000;
                    display: inline;
                    padding-bottom: 2px;                            
                }
            ',



        ];
        $report = new \app\components\XReport($XReportConfig);
        return $report->print();
    }
}
// -------------------------------------------------
class ReceiveinfoController extends \yii\web\Controller
// -------------------------------------------------
{
    private $SelectForm;
    private $monthTextArray;


    private function rawdataEstimate($year, $month, $customertypecode, $cust_no, $only_arbill, $inc_balance)
    {
        $sql = "
            declare @yyear int            
            declare @mmonth int
            declare @customertypecode char(2)    
            declare @cust_no char(10)
            declare @only_arbill bit
            declare @inc_balance  bit

            set @yyear = 2018
            set @mmonth  = 9
            set @customertypecode = '*' 
            set @cust_no  = '00267'
            set @only_arbill = 1
            set @inc_balance = 1  
    
        
            

            set @yyear = :yyear
            set @mmonth  = :mmonth 
            set @customertypecode = :customertypecode 
            set @cust_no  = :cust_no
            set @only_arbill = :only_arbill
            set @inc_balance = :inc_balance 

            

            select
                a.inv_number ,a.inv_date, a.due_date,a.cust_no
                ,a.totalamount as amount
                ,b.arbillno ,b.payamount
                ,c.arduedate
                ,d.cust_name     
                
                ,month(isnull(f.VoucherDate,isnull(c.arduedate,a.due_date))) as month                
                ,f.VoucherDate as receive_date
                ,g.due_date_acc
                -- -----------------------------------------------------------------
                --, cast(b.amount as varchar) + ' | '+cast(b.payamount as varchar) 
                -- + ' | '+ b.arbillno                
                -- as ardocdate
                --,c.arbillno as ardocdate
                --,c.ardocdate


            from (
                -- invoice
                select 'IV' as doctype, a.inv_number,a.inv_date
                    ,a.due_date                    
                    ,a.cust_no,a.totalamount,a.companycode 
                from invoice a 
                union
                -- CN
                select 'CN' as doctype,b.cn_number as inv_number,b.cn_date as inv_date
                    ,b.due_date
                    ,b.cust_no,- b.totalamount as totalamount,b.companycode            	
                from cn b
            ) a 
    

            left join ArBillTran b
                
                on b.inv_number=a.inv_number
                and b.companycode=a.companycode
            left join ArBillMast c
                on c.arbillno=b.arbillno
                and c.companycode=b.companycode
                -- ,isnull(g.due_date_acc,a.due_date) as due_date  
            left join x_invoice_ext g         	                    
                on a.companycode = g.companycode 
                and  a.inv_number = g.inv_number

                
            left join CashTran e 
                on e.DocNo = b.inv_number  and e.BillNo = b.arbillno
            left join CashMast f                 
                on e.CompanyCode=f.CompanyCode
                    and e.[Type]=f.[Type] 
                    and e.VoucherNo=f.VoucherNo
                
                



            left join customer d on d.cust_no =a.cust_no
            
            
            where year(
                    isnull(f.VoucherDate,isnull(c.arduedate,isnull(g.due_date_acc,a.due_date)))
                )=@yyear
            and ((month(
                isnull(f.VoucherDate,isnull(c.arduedate,isnull(g.due_date_acc,a.due_date)))
                )=@mmonth ) or @mmonth> 20 or @mmonth = 0)
            and (( DATEPART(QUARTER,
                isnull(f.VoucherDate,isnull(c.arduedate,isnull(g.due_date_acc,a.due_date)))
                ) = (@mmonth-20)) or @mmonth< 20  or @mmonth = 0)						 
            and ((d.CustomerTypeCode = @customertypecode)  or @customertypecode='*')
            and ((d.cust_no = @cust_no)  or @cust_no='*')            

            and ((b.arbillno is not  null) or (@only_arbill = 0))
            and ((abs(isnull(b.payamount,0)) < abs(a.totalamount)) or (@inc_balance = 1))           
            
            order by (
                isnull(f.VoucherDate,isnull(c.arduedate,isnull(g.due_date_acc,a.due_date)))
            ),d.cust_name,a.inv_number
                    
        ";

        //$a= ((isnull(b.payamount,0) < a.totalamount) or (:only_arbill = 0))           
        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);


        $command->bindParam(":yyear", $year);
        $command->bindParam(":mmonth", $month);
        $command->bindParam(":customertypecode", $customertypecode);
        $command->bindParam(":cust_no", $cust_no);
        $command->bindParam(":only_arbill", $only_arbill);
        $command->bindParam(":inc_balance", $inc_balance);

        return $command->queryAll();
    }



    // -------------------------------------------------------------------------------        
    public function actionEstimatereceipt()
    // -------------------------------------------------------------------------------        
    {
        $SelectForm = new SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year'];
            $SelectForm->month      = Yii::$app->request->queryParams['SelectForm']['month'];
            $SelectForm->customertypecode     = Yii::$app->request->queryParams['SelectForm']['customertypecode'];
            $SelectForm->cust_no     = Yii::$app->request->queryParams['SelectForm']['cust_no'];
            $SelectForm->checkbox    = Yii::$app->request->queryParams['SelectForm']['checkbox'];
            $SelectForm->checkbox2    = Yii::$app->request->queryParams['SelectForm']['checkbox2'];
        } else {
            $SelectForm->year   = date("Y");
            $SelectForm->month  = date("n");
            $SelectForm->customertypecode     = '*'; // 01'; 
            $SelectForm->cust_no     = '*';
            $SelectForm->checkbox    = false;
            $SelectForm->checkbox2    = false;
        }

        $rows = $this->rawdataEstimate(
            $SelectForm->year,
            $SelectForm->month,
            $SelectForm->customertypecode,
            $SelectForm->cust_no,
            $SelectForm->checkbox,
            $SelectForm->checkbox2

        );

        if (isset(Yii::$app->request->queryParams['btPrint'])) {
            if (count($rows) > 0) {
                $report = new printEstimatereceipt([
                    'rows' => $rows,
                    'SelectForm' => $SelectForm,
                ]);
                return $report->print();
            }
        }
        // echo'<pre><br><br><br>';


        // print_r(Yii::$app->request->queryParams);
        // echo'</pre>';
        if (isset(Yii::$app->request->queryParams['btXls'])) {
            if (count($rows) > 0) {
                $filename = 'estimate_receipt.xls';
                \app\components\XExport::x2xls($rows, $filename);

                (new Response())->sendFile($filename)->send();
                unlink($filename);               
                
            }
        }
        // if ($SelectForm->checkbox3) {
        //     if (count($rows) > 0) {
        //         $report = new printEstimatereceipt([
        //             'rows' => $rows,
        //             'SelectForm' => $SelectForm,
        //         ]);
        //         return $report->print();
        //     }
        // }
        $sum_amount = 0;
        $sum_payamount = 0;
        foreach ($rows as $item) {
            $sum_amount     += $item['amount'];
            $sum_payamount  += $item['payamount'];
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        return $this->render('estimate', [
            'SelectForm'    =>  $SelectForm,
            'dataProvider'  =>  $dataProvider,
            'params'        =>  [
                'sum_amount'    =>  $sum_amount,
                'sum_payamount' =>  $sum_payamount,
            ]
        ]);
    }
    // -------------------------------------------------------------------------------        
    public function actionTospreadsheet($year, $month, $customertypecode, $cust_no, $sm_code)
    // -------------------------------------------------------------------------------        
    {
        $rows = $this->rawdata($year, $month, $customertypecode, $cust_no, $sm_code);



        $filename = 'receiveinfo.xls';
        \app\components\XExport::x2xls($rows, $filename);
        (new Response())->sendFile($filename)->send();
        unlink($filename);
    }

    private function rawdata($year, $month, $customertypecode, $cust_no, $sm_code)
    {
        $sql = "exec process_receiveinfo :year,:month,:customertypecode,:cust_no,:sm_code";

        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);

        $command->bindParam(":year", $year);
        $command->bindParam(":month", $month);
        $command->bindParam(":customertypecode", $customertypecode);
        $command->bindParam(":cust_no", $cust_no);
        $command->bindParam(":sm_code", $sm_code);


        return $command->queryAll();
    }

    public function actionIndex()
    {




        $SelectForm = new SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year'];
            $SelectForm->month      = Yii::$app->request->queryParams['SelectForm']['month'];
            $SelectForm->customertypecode     = Yii::$app->request->queryParams['SelectForm']['customertypecode'];
            $SelectForm->cust_no     = Yii::$app->request->queryParams['SelectForm']['cust_no'];
            $SelectForm->sm_code     = Yii::$app->request->queryParams['SelectForm']['sm_code'];
            //$SelectForm->var2  = Yii::$app->request->queryParams['SelectForm']['var2'];

        } else {
            $SelectForm->year   = date("Y");
            $SelectForm->month  = date("n");
            $SelectForm->customertypecode     = '*'; // 01'; 
            $SelectForm->cust_no     = '*';
            $SelectForm->sm_code     = '*';
            //$SelectForm->var2  = false;

        }

        $rows = $this->rawdata(
            $SelectForm->year,
            $SelectForm->month,
            $SelectForm->customertypecode,
            $SelectForm->cust_no,
            $SelectForm->sm_code
        );

        $totalrec = 0;
        foreach ($rows as $item)
            $totalrec += $item['rec_amt'];
        $SelectForm->var1 =  $totalrec;



        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        //$this->layout = 'layout-fluid';
        //$this->params['fluid'] = true;
        return $this->render('receiveinfo', [
            'SelectForm'    =>  $SelectForm,
            'dataProvider' => $dataProvider,
        ]);
    }
}
