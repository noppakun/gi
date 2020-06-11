
<?php
//use kartik\nav\NavX;
use yii\helpers\Html;
use yii\helpers\Url;

//\app\components\XLib::xprint_r(\Yii::$app->request->cookies->getValue('_csrf')); 

$dbamenu = [
    ['label' => 'ERP', 'items' => [
        ['label' => 'ApCN', 'url' => ['/dbma/apcn']],
        ['label' => 'ApCNDetail', 'url' => ['//dbma/apcn-detail']],        
        ['label' => 'ApproveBulk - Approve ข้อมูลสินค้าจากการผลิต (BULK/INTERMEDIATE)' , 'url' => ['/dbma/approve-bulk']],                          
        ['label' => 'ArBillMast - ใบวางบิล', 'url' => ['/dbma/ar-bill-mast']],
        ['label' => 'ArBillTran - ใบวางบิล', 'url' => ['/dbma/ar-bill-tran']],
        ['label' => 'Asset', 'url' => ['/dbma/asset']],        
        ['label' => 'BankTransaction - ถอนเงินสดโดยใช้เช็ค, จ่ายค่าธรรมเนียม, ชำระค่าใช้จ่ายอื่นโดยใช้เช็ค (ไม่ผ่านการวางบิล)', 'url' => ['/dbma/bank-transaction']],
        ['label' => 'BankTransactionDetailAcc - ถอนเงินสดโดยใช้เช็ค, จ่ายค่าธรรมเนียม, ชำระค่าใช้จ่ายอื่นโดยใช้เช็ค (ไม่ผ่านการวางบิล)', 'url' => ['/dbma/bank-transaction-detail-acc']],        
        ['label' => 'CashMast -(H) รับเงิน/จ่ายเงิน,โอนเงินเข้าบัญชีธนาคาร', 'url' => ['/dbma/cashmast']],
        ['label' => 'CashTran -(D) รับเงิน/จ่ายเงิน,โอนเงินเข้าบัญชีธนาคาร', 'url' => ['/dbma/cash-tran']],
        ['label' => 'ChequeTran - รายการเช็ค', 'url' => ['/dbma/cheque-tran']],
        ['label' => 'Cn', 'url' => ['/dbma/cn']],
        ['label' => 'Company', 'url' => ['/company']],
        ['label' => 'Customer Type', 'url' => ['/dbma/customer-type']],
        ['label' => 'Customer', 'url' => ['/dbma/customer']],                                                                            
        ['label' => 'DocType (Stock Trans. Type)', 'url' => ['/dbma/doc-type']],
        ['label' => 'Dock', 'url' => ['/dbma/dock']],                            
        ['label' => 'Employee', 'url' => ['/dbma/employee']],        
        ['label' => 'GLJournal - รายวัน', 'url' => ['/dbma/gljournal']],
        ['label' => 'GLJournalDet - รายวัน', 'url' => ['/dbma/gljournaldet']],
        ['label' => 'Invoice', 'url' => ['/dbma/invoice']],
        ['label' => 'InvoiceDet', 'url' => ['/dbma/invoice-det']],                            
        ['label' => 'Item Batch', 'url' => ['/dbma/item-batch']],        
        ['label' => 'Item Loc (ราคาทุน)', 'url' => ['/dbma/item-loc']],
        ['label' => 'Item', 'url' => ['/dbma/item']],
        ['label' => 'PO - Purchase Order', 'url' => ['/dbma/po']],
        ['label' => 'PODetail - Purchase Order Detail', 'url' => ['/dbma/podetail']],
        ['label' => 'Pakeging Spec. (Spec)', 'url' => ['/dbma/spec']],        
        ['label' => 'Purchase Request Detail', 'url' => ['/dbma/prdetail']],
        ['label' => 'Purchase Request', 'url' => ['/dbma/pr']],
        ['label' => 'RawMat. Spec. (SpecRaw)', 'url' => ['/dbma/spec-raw']],
        ['label' => 'Recv_Product_Record - ข้อมูลการรับสินค้า,approve ข้อมูลสินค้าจาการผลิต ', 'url' => ['/dbma/recv-product-record']],                                  
        ['label' => 'Sale', 'url' => ['/dbma/sale']],
        ['label' => 'SaleDet', 'url' => ['/dbma/sale-det']],                            
        ['label' => 'StCard', 'url' => ['/dbma/st-card']],             
        ['label' => 'StHead', 'url' => ['/dbma/st-head']],
        ['label' => 'Suppliers', 'url' => ['/dbma/supplier']],
        ['label' => 'Tax - ข้อมูลภาษีซื้อ', 'url' => ['/dbma/tax']],       
        ['label' => 'Type Invents', 'url' => ['/dbma/type-invent']],
        ['label' => 'WPlanDet ใบสั่งงาน,JOB การสั่งผลิต', 'url' => ['/dbma/wplandet']],                          
        ['label' => 'Warehouse', 'url' => ['/dbma/warehouse']],
    ]],
    ['label' => 'Systems', 'items' => [        
        ['label' => 'XQuery', 'url' => ['/dbma/xquery']],                               
        ['label' => 'DeleteLog', 'url' => ['/dbma/delete-log']],                               
        ['label' => 'Gilogs', 'url' => ['/dbma/gilogs']],                               
        ['label' => 'XEmployeeExt', 'url' => ['/dbma/xemployeeext']],                               
    ]],
];

function menu_print($value,$key){ 
    if (!is_array($value)){
        //echo $value;  *** for skip '<hr/>', 17/5/2018
        //echo $value; 
    }elseif (array_key_exists('items', $value)){
        echo '<div class="row">';      
        echo '<li class="appa-head ">'.$value['label'].'</li>';        
        echo '<ul>'   ;
        foreach($value['items'] as $key1 => $value1){
            menu_print($value1,$key1);                               
        }              
        echo '</ul>';                                   
        echo '</div>';
    }else{        
        echo '<div class="col-md-4">';
        echo '<li class="appa">'.Html::a($value['label'], [$value['url'][0]]).'</li>';
        echo '</div>';
     }
}
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title">os.srv. : <?=php_uname('v');?> php : <?=PHP_MAJOR_VERSION.'.'. PHP_MINOR_VERSION ?></h3>            
            </div>
            <div class="col-md-6 text-right">
                <?='_csrf : '.(\Yii::$app->request->cookies->getValue('_csrf'))?>
            </div>
        </div>
    </div>    
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <?='REMOTE_ADDR  '.$_SERVER['REMOTE_ADDR']?>
            </div>

            

            <div class="col-md-4">
                <?='SERVER_ADDR  '.$_SERVER['SERVER_ADDR']?>
            </div>
            <div class="col-md-4">
                <?='TIME ZONE  '.Yii::$app->timeZone; ?>
            </div>
            <div class="col-md-4">
                <?='S '.preg_replace('/www\./i', '', $_SERVER['SERVER_NAME']); ?>
            </div>
            <div class="col-md-4">
                <?=Html::a(
                    'Test',  
                    Url::to('http://192.168.0.5/tr?csrf='.(\Yii::$app->request->cookies->getValue('_csrf')))
                    //(\Yii::$app->request->cookies->getValue('_csrf'))
                );?>
            </div>
            <div class="col-md-4">
                <?='__DIR__ : '.__DIR__; ?>
            </div>
        </div>                   
        
        <appa-nav>
        <?php 
            foreach($dbamenu as $key => $value){
                menu_print($value,$key);
            }     
        ?>
        </appa-nav>        
    </div>
    <!-- <div class="panel-footer">Panel footer</div> -->
</div>
<?php
    //$mac = system('arp -an'); 
    
    $mac = shell_exec('arp -an');         
    echo '<pre>';
    echo 'mac address<br>';
    echo $mac;
    echo '</pre>';     
?>


<style> 
    li.appa{
        /* float: left; */
        /* display: block; */
        padding: 3px 15px;
        /* margin: 0; */
        vertical-align: middle;
        /* color: #fff; */
    }
    li.appa-head{
        background-color: Lavender    ;
        display: block;
        padding: 5px 15px; 
    }  
</style>
