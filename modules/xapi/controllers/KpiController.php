<?php
namespace app\modules\xapi\controllers;

use Yii;
 
use kartik\mpdf\Pdf;
use app\models\SelectForm;
use yii\helpers\Html;
use app\models\Supplier;
use yii\web\Response;

use app\components\gihelper;

class KpiController extends \yii\web\Controller
{
 


    public function actionSupplierLists()
    {
        
       
        $sql = "
            select rtrim(supp_number) as supp_number,rtrim(supp_number) +' : ' + isnull(supp_name,'') as supp_name 
            from supplier order by  supp_number
            ";
        $connection = \Yii::$app->erpdb;      
        $command = $connection->createCommand($sql);        
 
        $rows =  $command->queryAll();

   

        Yii::$app->response->format = Response::FORMAT_JSON;       
   
        return [            
            'rows'=>$rows
        ];        
  
    }
    // http://gi.greaterman.com/gi/web/index.php?r=xapi/kpi/supp-date-receive
    public function actionSuppDateReceive(
        $supp_select1=null,
        $supp_select2=null,
        $date1=null,
        $date2=null
    ){
        
 
        
        $SelectForm = new SelectForm();

        $SelectForm->date       = Yii::$app->formatter->asDate('now - 1 months');
        $SelectForm->date2      = Yii::$app->formatter->asDate('now');

        if($supp_select1==null){  // 
            $SelectForm->date       = '20180101';
            $SelectForm->date2      = '20181231';

            $SelectForm->supp_no    = 'ก0004';                    
            $SelectForm->supp_no2   = 'ก0017';
            $SelectForm->supp_no2   = 'ฮ9999';
            $SelectForm->supp_no2   = 'ก0030';
        } else {
            $SelectForm->supp_no    = $supp_select1;
            $SelectForm->supp_no2   = $supp_select2;
            $SelectForm->date       = $date1;
            $SelectForm->date2      = $date2;
        }
 

		$sql ="
        -- v.5
        declare @Supp_Number1 varchar(10)
        declare @Supp_Number2 varchar(10)
        
        declare @date1 datetime
        declare @date2 date
        
        set @Supp_Number1='ก0004'
        set @Supp_Number2='ก0017'
        set @Supp_Number2='ฮ9990'
        
        set @Supp_Number1='อ0164'
        set @Supp_Number1='ก0003'
        set @Supp_Number2=@Supp_Number1
        set @Supp_Number2='ก0003'
        
        
        set @date1 = '20180101'
        set @date2 = '20181231'

        set @supp_number1=:supp_no
        set @supp_number2=:supp_no2
                
        set @date1 = :date1
        set @date2 = :date2  
       

        select a.*
        
        ,case when a.Rej_Qty = 0 and a.nc_doc_number is null then 1 else 0 end as case_a  
        ,case when a.Rej_Qty = 0 and a.nc_doc_number is not null then 1 else 0 end as case_an
        ,case when a.Rej_Qty <> 0  then 1 else 0 end as case_n
        ,1 as rec
        
        from ( 	
            select
                a.supp_number
                ,e.VoucherNo as rec_doc_no
                ,e.docdate as rec_date
                
                --,a.due_date
                ,g.dock_number
                ,g.acc_date as qc_date 
                ,a.Order_Number as po_doc_no
                ,a.order_qty
                ,f.recv_qty as rec_qty
            
                ,g.Recd_Qty - g.rej_qty as app_qty 		
                ,g.rej_qty
                ,f.item_number
                ,f.ana_no	
                
                ,d.doc_number as nc_doc_number
                
            from sthead e
            left join stcard f on  e.CompanyCode=f.CompanyCode and e.DocType=f.DocType and e.VoucherNo=f.VoucherNo  
            left join Dock g on g.companycode=f.companycode and g.item_number=f.item_number and g.ana_no=f.ana_no
            left join (
                select a.supp_number,a.CompanyCode,a.Order_Number ,b.Item_Number,sum(b.Order_Qty) as Order_Qty
                    from  PO a 
                    left join PODetail b on a.CompanyCode=b.CompanyCode and a.Order_Number=b.Order_Number
                    group by a.supp_number,a.CompanyCode,a.Order_Number ,b.Item_Number
        
            ) a on a.CompanyCode=e.CompanyCode and a.Order_Number=e.Order_Number and a.Item_Number = f.Item_Number
            --left join PO a on a.Order_Number=e.Order_Number and a.CompanyCode=e.CompanyCode
            --left join PODetail b on a.Order_Number=b.Order_Number and a.CompanyCode=b.CompanyCode and f.Item_Number=b.Item_Number
            left join Conform_Record d on d.CompanyCode=f.companycode  and d.Item_Number=f.Item_Number and d.BatchNo=f.ana_no
            where e.DocType='R1'
            and (rtrim(a.Supp_Number) between  @Supp_Number1 and  @Supp_Number2)
            and e.docdate between @date1 and @date2
            
            
        )a 
        --where item_number='P3791'
        order by a.supp_number,a.rec_doc_no,a.item_number,a.ana_no
        
        ";
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);

        $command->bindParam(":supp_no" ,$SelectForm->supp_no);
        $command->bindParam(":supp_no2",$SelectForm->supp_no2);
        $command->bindParam(":date1",$SelectForm->date);
        $command->bindParam(":date2",$SelectForm->date2);


        $rows = $command->queryAll();

        
        $report = new XReport($SelectForm,$rows);
        return $report->print(); 

    }
}
 
class XReport extends \yii\base\BaseObject
{
    public $SelectForm = [];
    public $rows = [];
    public function __construct($SelectForm,$rows){
        $this->SelectForm = $SelectForm;
        $this->rows = $rows;        
    }
    
    public function renderPageHeader()
    {
        $_user=isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username:'guest';
        return               
        Html::tag('table',
            Html::tag('tr',
                Html::tag('td',
                    Html::tag('h4',gihelper::comp_name())                    
                    .Html::tag('h5',                    
                        'รายงานประเมินคุณภาพของผู้ขายตามวันที่รับของ'                        
                        .'<br>ช่วงวันที่ : '.\app\components\XLib::dateConv($this->SelectForm->date,'a')
                            .' ถึง : '.\app\components\XLib::dateConv($this->SelectForm->date2,'a')
                        .'<br>รหัสผู้ขาย : '.$this->SelectForm->supp_no.' ถึง : '.$this->SelectForm->supp_no2
                    )                    
                )
                .html::tag('td',
                    'Page : {PAGENO}/{nbpg}'                                                            
                    .'<br>User : '.$_user
                    //.'<br>@ {DATE d-m-Y H:i:s} '                     
                    ,['width'=>'33%','style'=>'text-align: right; vertical-align:bottom']
                )

            )
            ,['width'=>'100%']
        ).
        Html::tag('table',        
            Html::tag('thead', 
                Html::tag('tr',                                    
                    Html::tag('th', 'เลขที่',      ['class'=>'hc2'])
                    .Html::tag('th', 'วันที่<br>รับของ',      ['class'=>'hc1'])
                    .Html::tag('th', 'Dock.No.',    ['class'=>'hc2'])
                    .Html::tag('th', 'วันที่ Qc/Rej' ,    ['class'=>'hc1'])
                    .Html::tag('th', 'เลขที่<br>ใบสั่งซื้อ',    ['class'=>'hc2'])
                    .Html::tag('th', 'Order Qty.',    ['class'=>'hc3'])
                    .Html::tag('th', 'จำนวน<br>รับ',       ['class'=>'hc3'])
                    .Html::tag('th', 'จำนวน<br>ผ่าน',     ['class'=>'hc3'])
                    .Html::tag('th', 'จำนวน<br>ไม่ผ่าน',   ['class'=>'hc3'])
                    .Html::tag('th', 'สินค้า / ana.no. / NC',          ['class'=>'hc4'])
                ) 
                
            )
            ,['width'=>'100%','style' => "border-top:1pt solid black; border-bottom:1pt solid black;border-width: thin;"] 
        );
    }
    

    

  
    public function renderFooter($gcase_a,$gcase_an,$gcase_n,$gcase_all)
    {
        return $gcase_all <= 0  ? '':
        Html::tag('table',         
            (
             
                (Html::tag('tr',                
                    Html::tag('td width="30%"', 'รวม จำนวนรายการ ผ่าน = '.$gcase_a.' ('.number_format(($gcase_a/$gcase_all*100),0).'%)')                    
                    .Html::tag('td width="25%"', 'ผ่านแบบมีเงื่อนไข = '.$gcase_an.' ('.number_format(($gcase_an/$gcase_all*100),0).'%)')                    
                    .Html::tag('td width="20%"', 'ไม่ผ่าน = '.$gcase_n.' ('.number_format(($gcase_n/$gcase_all*100),0).'%)')                    
                    .Html::tag('td width="20%"', 'รวม = '.$gcase_all)

                )) .Html::tag('tr',Html::tag('td', ''))
               
            )
            //,['style'=>"width:100% "]
            ,[
                'style'=>"width:100% ;border-bottom:1pt solid black;"
            ]
            
            //'style'=>'margin-bottom:5px;border-bottom:1pt solid black;border-width: thin;'         
        );

    }
    public function renderRowGroup($row,$last_supp_number,$case_a,$case_an,$case_n,$case_all,$last_total)
    {        
        return 
        Html::tag('table',         
            (
                $last_supp_number!==''?
                (Html::tag('tr',                
                    Html::tag('td width="30%"', 'จำนวนรายการ ผ่าน = '.$case_a.' ('.number_format(($case_a/$case_all*100),0).'%)')                    
                    .Html::tag('td width="25%"', 'ผ่านแบบมีเงื่อนไข = '.$case_an.' ('.number_format(($case_an/$case_all*100),0).'%)')                    
                    .Html::tag('td width="20%"', 'ไม่ผ่าน = '.$case_n.' ('.number_format(($case_n/$case_all*100),0).'%)')                    
                    .Html::tag('td width="20%"', 'รวม = '.$case_all.'  ( '.$last_supp_number.' )')

                )) .Html::tag('tr',Html::tag('td', ''))
                :''
            ).
            (
                $last_total ? '' 
                : Html::tag('tr',                             
                    
                    //Html::tag('td', '<h4>'.$row['supp_number'].$supplier['Supp_Name'].'</h4>')
                    Html::tag('td', '<h4>'.$row['supp_number'].' : '.(Supplier::findOne($row['supp_number'])->Supp_Name).'</h4>')
                    
                )
            )            
            //,['style'=>"width:100% "]
            ,[
                'style'=>"width:100% ;border-bottom:1pt solid black;"
                .($last_supp_number!==''?'border-top:1pt solid black;':'')
            ]
            
            //'style'=>'margin-bottom:5px;border-bottom:1pt solid black;border-width: thin;'         
        );
    }
    public function renderRow($row)
    {        
        return 
        Html::tag('table',         
            Html::tag('tr',             
                Html::tag('td', $row['rec_doc_no']   ,['class'=>'rc2'])                
                .Html::tag('td', Yii::$app->formatter->asDate($row['rec_date']),['class'=>'rc1'])            
                .Html::tag('td', $row['dock_number']   ,['class'=>'rc2'])                
                .Html::tag('td', Yii::$app->formatter->asDate($row['qc_date']),['class'=>'rc1'])            
                .Html::tag('td', $row['po_doc_no']   ,['class'=>'rc2'])                
                .Html::tag('td', number_format($row['order_qty'],0),['class'=>'numfmt rc3'])
                .Html::tag('td', number_format($row['rec_qty'],0),['class'=>'numfmt rc3'])
                .Html::tag('td', $row['app_qty']==0?'-':number_format($row['app_qty'],0),['class'=>'numfmt rc3'])
                .Html::tag('td', $row['rej_qty']==0?'-':number_format($row['rej_qty'],0),['class'=>'numfmt rc3'])                
                
                .Html::tag('td', trim($row['item_number']).' / '.trim($row['ana_no'])
                    //.($row['nc_doc_number'] == null ? '':' / ').trim($row['nc_doc_number']) 
                    .($row['nc_doc_number'] == null ? '':' / NC ')
                    ,['class'=>'rc4'])

            )
            ,['style'=>"width:100%"]
        );
    }

    
    public function renderPageDetail($rows)
    {
        $content = '';
        $last_supp_number='';
        $case_all = 0;
        $case_a = 0;
        $case_an = 0;
        $case_n = 0;

        $gcase_all = 0;
        $gcase_a = 0;
        $gcase_an = 0;
        $gcase_n = 0;

        foreach ($rows as $row) { 

            if ($last_supp_number!==$row['supp_number']){
                
                $content .= $this->renderRowGroup($row,$last_supp_number,$case_a,$case_an,$case_n,$case_all,false);
                $last_supp_number=$row['supp_number'];
                $case_all = 0;
                $case_a = 0;
                $case_an = 0;
                $case_n = 0;
        
            }
            $case_all++;
            $case_a     += $row['case_a'];
            $case_an    += $row['case_an'];
            $case_n     += $row['case_n'];

            $gcase_all++;
            $gcase_a     += $row['case_a'];
            $gcase_an    += $row['case_an'];
            $gcase_n     += $row['case_n'];

            $content .= $this->renderRow($row); 
            $content2 = '';
            // foreach ($row->stCard as $rowDetail) {
            //     $content2 .= $this->renderSubRow($rowDetail); 
            // };
            // $content2 = $this->renderSubRowHeader().$content2;


            $content .= Html::tag('table',$content2,[
                'style'=>'margin-bottom:5px;border-bottom:1pt solid black;border-width: thin;'         
                ]);

        }
        if ($last_supp_number!==''){            
            $content .= $this->renderRowGroup($row,$last_supp_number,$case_a,$case_an,$case_n,$case_all,true);
        }
        $content .= $this->renderFooter($gcase_a,$gcase_an,$gcase_n,$gcase_all);

        return $content;
    }
 
    public function print()
    {
        // -------------------------------
        // for get 4 month report
        ini_set('max_execution_time', 300); 
        ini_set("pcre.backtrack_limit", "10000000");
        // -------------------------------
        
        $content = $this->renderPageDetail($this->rows);   

 
        $Pdfparam = [
            'mode' => Pdf::MODE_UTF8,
            //'format' => Pdf::FORMAT_LETTER,    
            'format' => Pdf::FORMAT_A4,                         
            'orientation' => Pdf::ORIENT_PORTRAIT,             
            'marginTop'=>38,
            'marginLeft'=>3,
            'marginRight'=>3,            
            'marginBottom'=>15,
            //'marginFooter'=>30,           
            
            'content' => $content,            
            'cssFile' => '@app/web/css/kv-mpdf-report.css',
            
            //'cssFile' => file_get_contents(\Yii::getAlias('@app').'/web/css/mpdf.css'),
            //'cssInline' => file_get_contents(\Yii::getAlias('@app').'/web/css/kv-mpdf.css'),    
            'cssInline' => '
                .rc1, .hc1 { width:  90px ; }
                .rc2, .hc2 { width:  80px ; }
                .rc3, .hc3 { width:  70px ; }
                .rc4, .hc4 { width:  180px ;  padding-left: 10px ; }
                
                
                .hc3 { text-align: center}

            ',   
            'options' => [
                'title' => 'รายงานความเคลื่อนไหวของสินค้า ',
                'subject' => 'Generating PDF files',
             ],            
            'methods' => [
                'SetHTMLHeader' => [$this->renderPageHeader()],                
                'SetFooter' => ['@ {DATE d-m-Y - H:i:s}'],
            ],        
        ];


        $pdf = new Pdf($Pdfparam);         
        return $pdf->render();  

        // $mpdf = $pdf->api;        
        // //return $mpdf->Output('filename', 'I'); // call the mpdf api output as needed
        // return $mpdf->Output('filename.pdf', 'S'); // call the mpdf api output as needed


    }
    

}