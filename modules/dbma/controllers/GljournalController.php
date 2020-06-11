<?php
namespace app\modules\dbma\controllers;
use Yii;
 
class GljournalController extends \app\components\XQEdit\XQEditController
{
    /*
        echo $this->render('_search_change_book', ['model' => $searchModel]);
    */
    protected $MAIN_MODEL 	    =   'app\models\GLJournal';    
 

    public function init()  
    {
        parent::init();
        
         
        $this->VIEWPARA['XQEDIT']['index_columns'] = [  
            'CompanyCode',
            'GLBookCode',
            'VoucherNo',
            'VoucherDate',
            'Remark',
            //'tryear',
            //'UserName',
            //'Updatetime',
            //'PostStatus',
            //'CompanyCodeFrom',
            //'DocType',
            //'VoucherNoFrom',
            //'ApplType',
            //'BranchCode',
            //'POSTLock',
             
        ];
        $this->VIEWPARA['XQEDIT']['update_columns'] = [ 
            'CompanyCode',
            'GLBookCode',
            'VoucherNo',
            'VoucherDate',
            'Remark',
            'UserName',
            'Updatetime',
            'PostStatus',
            'CompanyCodeFrom',
            'DocType',
            'VoucherNoFrom',
            'ApplType',
            'BranchCode',
            'POSTLock',
 
        ];

    }      
    
    
    public function actionChangebookcode($tryear,$gb1,$pf1,$gb2,$pf2){
        $sql="
                    
            declare @tryear INTEGER
            DECLARE @gb1 char(2)
            DECLARE @pf1 char(2)

            DECLARE @gb2 char(2)
            DECLARE @pf2 char(2)



            set @tryear = 2018
            set @gb1 = '02'
            set @pf1 = 'CI'

            set @gb2 = '16'
            set @pf2 = 'PC'

            set @tryear = :tryear
            set @gb1 = :gb1
            set @pf1 = :pf1
            
            set @gb2 = :gb2
            set @pf2 = :pf2

            -- ----------------------------------------------------------
            -- step 1   update detail
            -- ----------------------------------------------------------
            update Gljournaldet 
                set glbookcode=@gb2
                ,voucherno=@pf2+substring(a.voucherno,3,20)
            from Gljournaldet a
            where voucherno in (
                ------ list ------------
                select  a.voucherno 
                from Gljournal a
                where year(Voucherdate)=@tryear
                and glbookcode=@gb1
                and left(voucherno,2)=@pf1
                ------------------------

            ) 

            -- ----------------------------------------------------------
            -- step 2   update head
            -- ----------------------------------------------------------
            update Gljournal 
            set glbookcode=@gb2
            ,voucherno=@pf2+substring(voucherno,3,20)	
            where year(Voucherdate)=@tryear
            and glbookcode=@gb1
            and left(voucherno,2)=@pf1        
        ";


        $connection = \Yii::$app->erpdb;  
        $command=$connection->createCommand($sql);

        $command->bindParam(":tryear",$tryear);   
        $command->bindParam(":gb1",$gb1); 
        $command->bindParam(":pf1",$pf1);          
        $command->bindParam(":gb2",$gb2); 
        $command->bindParam(":pf2",$pf2);          

      

        
        $rowCount=$command->execute(); // execute the non-query SQL

        return $this->redirect(['index']);
    }
 

  
}

