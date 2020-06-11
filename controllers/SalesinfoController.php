<?php

namespace app\controllers;
use yii;
use yii\data\ArrayDataProvider;
use yii\web\Response;
use app\models\SelectForm; 
use app\models\XSalesinfoSearch; 
use app\models\ItemSearch;

class SalesinfoController extends \yii\web\Controller
{

    // public function actionRawdata()
    // {
    //     // 8/12/2017  k.jed
    //     // change to 2+1 year
         
    //     $sql =
    //     "
    //         select * from x_salesinfo a
	// 					where tryear >=(DATEPART(yyyy,getdate()) -2)
    //         order by  a.tryear,a.trquarter,a.trmonth
    //         ,a.Cust_Name  ,a.CustomerTypeDesc
    //         ,a.Item_Name
    //     ";
    //         // gidata.dbo.
    //     //$connection = \Yii::$app->erpdb;
    //     $connection = \Yii::$app->db;
    //     $command = $connection->createCommand($sql);


    //     $rows = $command->queryAll();
    //     $dataProvider=new ArrayDataProvider( [
    //         'allModels' => $rows,
    //         'pagination'=>[
    //             'pageSize'=>3,
    //         ],
    //     ]);

    //     return $this->render('rawdata', [
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }
    // -------------------------------------------------------------------------------        
    public function actionIndex()
    {
        $SelectForm = new SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {                            
            $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year']; 
            $SelectForm->month      = Yii::$app->request->queryParams['SelectForm']['month']; 
            $SelectForm->customertypecode     = Yii::$app->request->queryParams['SelectForm']['customertypecode'];
            $SelectForm->cust_no     = Yii::$app->request->queryParams['SelectForm']['cust_no'];
            $SelectForm->checkbox     = Yii::$app->request->queryParams['SelectForm']['checkbox'];
        }else{
            $SelectForm->year   = date("Y");                
            $SelectForm->month  = date("n"); 
            $SelectForm->customertypecode     ='*'; // 01'; 
            $SelectForm->cust_no     = '*';        
            $SelectForm->checkbox    = 1;        
        }         
        //$rows = $this->rawdataEstimate($SelectForm->year,$SelectForm->month,$SelectForm->customertypecode,$SelectForm->cust_no);


        $searchModel = new XSalesinfoSearch();
        $qParam = Yii::$app->request->queryParams;        
        $SelectForm->action   = 'salesinfo/index';
        $qParam['SelectForm'] = $SelectForm->toArray();        
        $dataProvider = $searchModel->search($qParam);                
    

                

        return $this->render('index', [
            'searchModel'   =>  $searchModel,
            'dataProvider'  =>  $dataProvider,
            'SelectForm'    =>  $SelectForm,

        ]); 
    }    

 
 

    // // -------------------------------------------------------------------------------        
    // public function actionIndextospreadsheet($year,$month,$customertypecode,$cust_no)
    // // -------------------------------------------------------------------------------        
    // {

    //     $SelectForm = new SelectForm();
    //     $SelectForm->year   = $year ;
    //     $SelectForm->month  = $month ;
    //     $SelectForm->customertypecode     =$customertypecode;
    //     $SelectForm->cust_no     = $cust_no; 
            
            
    //     $searchModel = new XSalesinfoSearch();
    //     $qParam = Yii::$app->request->queryParams;        
    //     $SelectForm->action = 'salesinfo/index';
    //     $qParam['SelectForm'] = $SelectForm->toArray();        
    //     $dataProvider = $searchModel->search($qParam);                
    
    //     $rows = $dataProvider->query->all();
    //     $filename='salesinfo.xls';
    //     \app\components\XExport::x2xls($rows,$filename);
    //     (new Response())->sendFile($filename)->send();
    //     unlink($filename);
 						
    // }   

     // -------------------------------------------------------------------------------           
     public function actionTospreadsheet(array $searchModel=null)
     // -------------------------------------------------------------------------------        
     {
 
        $qParams['XSalesinfoSearch'] = $searchModel;        
        $dataProvider = (new XSalesinfoSearch())->search($qParams);       

        $rows = $dataProvider->query->all();         
        $filename='salesinfoRawdata.xls';
        \app\components\XExport::x2xls($rows,$filename);
        (new Response())->sendFile($filename)->send();
        unlink($filename);
                          
     }   
    // -------------------------------------------------------------------------------        
    public function actionRawdata()
    // -------------------------------------------------------------------------------
    {
        // 8/12/2017  k.jed
        // change to 2+1 year
        
        $searchModel = new XSalesinfoSearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $SelectForm = new SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {                            
            $SelectForm->var1  = Yii::$app->request->queryParams['SelectForm']['var1'];             

        }else{
            $SelectForm->var1  = false;            
        } 
                

        return $this->render('rawdata', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'SelectForm'    =>  $SelectForm,
        ]);


    }
    // -------------------------------------------------------------------------------
    public function actionByproduct()
    // -------------------------------------------------------------------------------
    {

      $SelectForm = new SelectForm();
      $searchModel = new ItemSearch();
      if (isset(Yii::$app->request->queryParams['SelectForm'])) {
          $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year'];
      }else{
          $SelectForm->year   = date("Y");
      }


        $dataProvider = $searchModel->salesbyproductSearch(Yii::$app->request->queryParams,$SelectForm);
        $dataProvider->setSort([
            'attributes' => [                            
                'Item_Number',
                'Item_Name',
                
            ]
        ]);
        return $this->render('byproduct', [
            'SelectForm'    =>  $SelectForm,
            'searchModel'   => $searchModel,            
            'dataProvider' => $dataProvider,
            
            
        ]);
    }    
    // -------------------------------------------------------------------------------
    public function actionBycustomertype()
    // -------------------------------------------------------------------------------
    {

      $SelectForm = new SelectForm();
      if (isset(Yii::$app->request->queryParams['SelectForm'])) {
          $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year'];
      }else{
          $SelectForm->year   = date("Y");
      }
  		$sql ="
        declare @year int
        set  @year = :year
        SELECT  isnull(customertypedesc,cust_no) as  customertypedesc
          ,sum(case when a.tryear=@year and trmonth =   1 then  amt else 0 end) as amt1
          ,sum(case when a.tryear=@year and trmonth =   2 then  amt else 0 end) as amt2
          ,sum(case when a.tryear=@year and trmonth =   3 then  amt else 0 end) as amt3
          ,sum(case when a.tryear=@year and trmonth =   4 then  amt else 0 end) as amt4
          ,sum(case when a.tryear=@year and trmonth =   5 then  amt else 0 end) as amt5
          ,sum(case when a.tryear=@year and trmonth =   6 then  amt else 0 end) as amt6
          ,sum(case when a.tryear=@year and trmonth =   7 then  amt else 0 end) as amt7
          ,sum(case when a.tryear=@year and trmonth =   8 then  amt else 0 end) as amt8
          ,sum(case when a.tryear=@year and trmonth =   9 then  amt else 0 end) as amt9
          ,sum(case when a.tryear=@year and trmonth =  10 then  amt else 0 end) as amt10
          ,sum(case when a.tryear=@year and trmonth =  11 then  amt else 0 end) as amt11
          ,sum(case when a.tryear=@year and trmonth =  12 then  amt else 0 end) as amt12
          ,sum(case when a.tryear=@year then  amt else 0 end) as total          
          ,sum(case when a.tryear=@year     and a.trmonth<month(getdate()) then  amt else 0 end) as total_ytlm          
          ,sum(case when a.tryear=(@year-1) and a.trmonth<month(getdate()) then  amt else 0 end) as total_l1_ytlm

          ,sum(case when a.tryear=(@year-1) then  amt else 0 end) as total_l1
          ,sum(case when a.tryear=(@year-2) then  amt else 0 end) as total_l2
          
        FROM [x_salesinfo] a
        where tryear >= (@year-2)
        group by isnull(customertypedesc,cust_no)
        order by isnull(customertypedesc,cust_no)
      ";
    // -- tryear
            // gidata.dbo.
        //$connection = \Yii::$app->erpdb;
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);

        $command->bindParam(":year",$SelectForm->year);

        $rows = $command->queryAll();
        $dataProvider=new ArrayDataProvider( [
            'allModels' => $rows,
        ]);
 
        return $this->render('bycustomertype', [
            'dataProvider' => $dataProvider,
            'SelectForm'    =>  $SelectForm,
        ]);
    }
    // -------------------------------------------------------------------------------
    public function actionUpdate()
    // -------------------------------------------------------------------------------
    {

  
        // //call function 
        \Yii::$app->runAction('jobproductcost/calvcost');


        $sql ="exec process_salesinfo";

        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);
        $command->execute();
        //return $this->redirect('/gi/web/index.php?r=salesinfo/rawdata',302);
        //return $this->redirect(['salesinfo/rawdata']);
        return $this->redirect(Yii::$app->request->referrer);
        



    }

}
