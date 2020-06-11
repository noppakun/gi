<?php

namespace app\controllers;
use yii;
use yii\data\ArrayDataProvider;
use app\models\ProdDetSearch;
use app\models\XProdnote;
use app\models\Pr;
use app\models\Item;
use app\models\PurchaseOrder;
use app\models\SelectForm;
use yii\helpers\Url;
// class ProdController extends \yii\web\Controller
class ProdController extends \yii\web\Controller
{
    private $notifyMailList = [		
		
		// md pr
		'parun@greaterman.com',		
		'yaowarat@greaterman.com',			
		
		// bd 		
		'woranuth@greaterman.com',
		'kanlaya@greaterman.com',		
		'punnee@greaterman.com',		
		'pattiya@greaterman.com',

		// rd
		'siriwan@greaterman.com',
		'sopa@greaterman.com',
		'nittaya@greaterman.com',

		// planning
		'pattama@greaterman.com',
		'jirapornp@greaterman.com',

		// it
		'noppakun@greaterman.com'		
	];
	
	// ----------------------------------------------------------------------------------
	function line_notify_message($message){
	// ----------------------------------------------------------------------------------		 
        /*
            From : GI
            To : gpm.gi.plp
            Token : DysqWO8nrzOMP0YjJTtlceZnCPSqKKzwAKRjQeMHZst
        */
		define('LINE_API',"https://notify-api.line.me/api/notify");
		define('LINE_TOKEN','DysqWO8nrzOMP0YjJTtlceZnCPSqKKzwAKRjQeMHZst');
		$queryData = array('message' => $message);
		$queryData = http_build_query($queryData,'','&');
		$headerOptions = array(
			'http'=>array(
				'method'=>'POST',
				'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
						."Authorization: Bearer ".LINE_TOKEN."\r\n"
							."Content-Length: ".strlen($queryData)."\r\n",
				'content' => $queryData
			)
		);
		$context = stream_context_create($headerOptions);
		$result = file_get_contents(LINE_API,FALSE,$context);
		$res = json_decode($result);
		return $res;
	}
	// ----------------------------------------------------------------------------------
	function mail_notify_message($subject,$message)
	// ----------------------------------------------------------------------------------
	{
	
		Yii::$app->mailer->compose()
		->setFrom('itadmin@greaterman.com')
		->setTo($this->notifyMailList)
		->setSubject($subject)
		->setTextBody($message)            
		->send();		
	}

	// ----------------------------------------------------------------------------------
	function notify($action='',$order_no,$item_no,$component,$note,$username)   
	// ----------------------------------------------------------------------------------
	{		
		$_component = Item::findOne($component);   
		$component_name = $_component->Item_Name;
		
		$subject='*** '.$action.' issue ***'."  \n".
			($order_no == '*' ? '' : 'Order no. : '.trim($order_no)."  \n").
			($item_no  == '*' ? '' : 'Item no. : '.trim($item_no)."  \n").
			'Component : '.trim($component).($component_name==null ? '':' '.$component_name)."  \n".
			'User : '.$username;
		$message = $note. "\n".'  ดูรายละเอียดได้ที่  : '.
			'http://gi.greaterman.com'.Url::to(['prod/note', 'order_no'=>trim($order_no),'item_number'=>trim($item_no),'component'=>trim($component)]);
		
		$this->mail_notify_message($subject,$message);
		$this->line_notify_message($subject."\n".$message);				
	}


	// -------------------------------------------------------------------------------------------------------------------------
	public function actionViewpo($po_number=null)   
    // -------------------------------------------------------------------------------------------------------------------------
    { 
		$model = PurchaseOrder::findOne(['Order_Number' => $po_number]);
		return $this->render('viewpo', [
			'model' => $model,
		]);		        	
	}
	
	// -------------------------------------------------------------------------------------------------------------------------
	public function actionViewpr($pr_number=null)   
    // -------------------------------------------------------------------------------------------------------------------------
    { 
		$model = pr::findOne(['PR_Number' => $pr_number]);
		return $this->render('viewpr', [
			'model' => $model,
		]);		        	
    }
	// ----------------------------------------------------------------------------------		
    public function actionIndex()
	// ----------------------------------------------------------------------------------		
    {

        $SelectForm = new SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {                            
            $SelectForm->checkbox       = Yii::$app->request->queryParams['SelectForm']['checkbox']; 
        }else{
            $SelectForm->checkbox   = false;                
        } 


        $searchModel = new ProdDetSearch();
        $dataProvider = $searchModel->production_order_search(Yii::$app->request->queryParams,$SelectForm->checkbox);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'SelectForm'=>$SelectForm,
        ]);        
    }    
    // -------------------------------------------------------------------------------------------------------------------------
	public function actionApprovenote($id=null,$order_no,$item_no)   
    // -------------------------------------------------------------------------------------------------------------------------
    { 

		

		$model = XProdnote::findOne($id);   
		$model->status =  'A';
		$model->tr_datetime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-',   Yii::$app->formatter->asDateTime('now')      ))); 
		$this->notify('Close',$model->order_no,$model->item_no,$model->component,$model->note,$model->username);

		$model->save();    
		return $this->redirect(['view', 
			'order_no'	=> $order_no,
			'item_number'	=> $item_no				
		]);		        	
    } 	
	// ----------------------------------------------------------------------------------		
    public function actionNote($order_no,$item_number,$component)
	// ----------------------------------------------------------------------------------		    
	{
		$sql = "
				
			declare @order_no varchar(20)
			declare @item_number varchar(20)
			declare @component varchar(20)
			set @order_no='801319'
			set @item_number='8850279801066'
			set @item_number='8850279801509'
			set @component=''

			set @order_no = :order_no
			set @item_number = :item_number
			set @component = :component

			select a.* from x_prodnote a 
			where (a.order_no=@order_no or a.order_no='*')
			and (a.item_no=@item_number or a.item_no='*')
			and a.component=@component
			order by a.status desc, a.tr_datetime desc

        ";

        
            
        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);
        
        $command->bindParam(":order_no",$order_no);   
        $command->bindParam(":item_number",$item_number); 
		$command->bindParam(":component",$component); 
        
        $rows = $command->queryAll();
        $dataProvider=new ArrayDataProvider( [
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => 40,
            ],            
            
        ]);

		$modeld1 =   new XProdnote();
		$modeld1->order_no = $order_no;
		$modeld1->item_no = $item_number;
		$modeld1->component = $component;
		$modeld1->username = Yii::$app->user->identity->username;
		$modeld1->allorder = false;
		
		// if (rtrim($item_number)=='*'){
			$sql = "
				declare @component varchar(20)
				declare @item_number varchar(20)
				declare @order_no varchar(20)
				
				set @component = :component
				set @item_number = :item_number
				set @order_no = :order_no
			
				select distinct a.order_no,f.cust_name,b.item_number,b.item_name
				from proddet a
					left join item b on a.item_number=b.item_number
					left join bomdet c on a.item_number=c.Assembly

					left join prod d on a.order_no=d.order_no
					left join sale e on d.sale_number = e.sale_number
					left join customer f on e.cust_no=f.cust_no
				where a.status <> 'C'
					and Type_Invent_Code='01'
					and c.component=@component
					and ((a.item_number=@item_number) or (@item_number = '*'))
					and ((a.order_no=@order_no) or (@order_no = '*'))
			";
			$command = $connection->createCommand($sql);
			
			$command->bindParam(":component",$component); 
			$command->bindParam(":item_number",$item_number); 
			$command->bindParam(":order_no",$order_no); 
			
			$rows = $command->queryAll();
			$itemProvider=new ArrayDataProvider( [
				'allModels' => $rows,
				'pagination' => [
					'pageSize' => 40,
				],            
				
			]);			

		// }else{
//			$itemProvider=[];
//		}
				
        return $this->render('note', [            
            'dataProvider' => $dataProvider,
			'modeld1' => $modeld1,
			'order_no'=>$order_no,
			'item_number'=>$item_number	,
			'component'=>$component,
			'itemProvider'=>$itemProvider,
        ]);
				
	}
    // -------------------------------------------------------------------------------------------------------------------------
	public function actionUpdatenote($id=null)   
    // -------------------------------------------------------------------------------------------------------------------------
    { 

        if ($id==null){ // create
            $model = new XProdnote();       
			$model->status='N';
        }else{ 
            $model = XProdnote::findOne($id);   
        }
        if ($model->load(Yii::$app->request->post())) {    // ---- save data from create or update             
			$p_order_no = $model->order_no;
			$p_item_no = $model->item_no;
			if ($model->allorder){
				$model->order_no = '*';
				$model->item_no = '*';
			}
			$model->tr_datetime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-',   Yii::$app->formatter->asDateTime('now')      ))); 
            $model->save();            

			$this->notify('New',$model->order_no,$model->item_no,$model->component,$model->note,$model->username);


			
            return $this->redirect(['view', 
				'order_no' => $p_order_no,
				'item_number' => $p_item_no				
			]);
        }
    } 

	// ----------------------------------------------------------------------------------		
    public function actionView($order_no,$item_number)
	// ----------------------------------------------------------------------------------		    
    {
		$sql = "
				
			declare @order_no varchar(20)
			declare @item_number varchar(20)
			set @order_no='978010'
			set @item_number='8850279801066'
			set @item_number='8850279978300'



			set @order_no = :order_no
			set @item_number = :item_number


			select 
			a.Order_No 
			,a.Item_Number
			,b.Component
			,c.Item_Name as Component_name
			----- จำนวนที่ใช้ตามใบสั่งผลิต ---
			,a.Order_Qty*b.Qty as qty_use
			,c.QtyOnhand
			,d.pr_date
			,d.pr_number
			,e.po_date
			,e.po_number
			,f.recd_date
			,f.dock_number
			,e.delivery_date
			,g.note,g.username,g.tr_datetime



			--,c.type_invent_code
			,h.type_invent
			,isnull(i.notecount,0)+isnull(j.notecount,0) as notecount
			--,a.*
			,a.Status
			from ProdDet a
			left join BomDet b on a.Item_Number=b.Assembly
			left join Item c on b.Component=c.Item_Number
			left join Item cc on a.Item_Number=cc.Item_Number
			-- ----------------------------------------------
			left join (
				----- pr ล่าสุด -----
				select d.Item_Number,d.pr_number ,d.pr_date from (
					select c.Item_Number,c.PR_Number  ,c.pr_date 
						,ROW_NUMBER () OVER (PARTITION BY c.Item_Number ORDER BY c.pr_date desc) AS seq -- Code Added
					from(
						select b.Item_Number,a.PR_Number  ,max(a.Order_Date) as pr_date 
						from PR a 
							left join PRDetail b on a.PR_Number=b.PR_Number	
						where a.Open_Close = 0 -- open
							and isnull(b.Item_Number,'')<>''
						group by b.Item_Number,a.PR_Number 
					)c
				) d where d.seq=1

			) d on c.Item_Number=d.Item_Number
			-- --------------------------------
			left join (
				/*  po ล่าสุด */
				select e.Item_Number ,e.po_number, e.po_date ,e.delivery_date
				from(
					select d.Item_Number ,d.po_number, d.po_date ,d.Delivery_Date
						,ROW_NUMBER () OVER (PARTITION BY d.Item_Number ORDER BY d.po_date desc) AS seq -- Code Added
					from (
				
					select b.Item_Number ,a.Order_Number as po_number
						-- ,isnull(b.Pr_Number,a.PR_Number) as pr_number
						,b.Delivery_Date
						,max(a.Order_Date) as po_date

						from po a 
						left join PODetail b on a.order_Number=b.order_Number
						where a.Open_Close = 0 -- open
							and isnull(b.Item_Number,'')<>''
							and not isnull(b.Pr_Number,a.PR_Number) is null
						group by b.Item_Number,a.Order_date ,a.Order_Number ,b.Delivery_Date
					)d
				)e where e.seq=1

			)e on c.Item_Number=e.Item_Number 
			left join(
				-----   รับเข้าล่าสุด จาก dock
				select a.Item_Number,a.Order_Number ,a.dock_number ,a.recd_date
				from (
					select a.*
						,ROW_NUMBER () OVER (PARTITION BY a.Item_Number ORDER BY a.recd_date desc) AS seq -- Code Added
					from (
						select a.Item_Number,a.Order_Number,max (a.Recd_Date) as recd_date
							,a.Dock_Number
						From Dock  a
						where isnull(a.Item_Number,'')<>''
						group by a.Item_Number,a.Order_Number,a.Dock_Number
					)a
				)a where a.seq=1

			)f on c.Item_Number=f.Item_Number
			left join (
				----- note ล่าสุด
				select h.order_no,h.item_no,h.component,h.note,h.username,h.tr_datetime,seq
				from(
					select h.order_no,h.item_no,h.component,h.note,h.username,h.tr_datetime	
					,ROW_NUMBER () OVER (PARTITION BY h.order_no,h.item_no,h.component ORDER BY h.order_no,h.item_no,h.component, h.tr_datetime desc) AS seq -- Code Added	
					from  x_prodnote h
					where h.status='N'
				)h where seq=1
			) g on a.order_no=g.order_no 
				and a.item_number = g.item_no 
				and b.Component=g.Component
			left join (
				----- นับจำนวน note ตาม h.order_no,h.item_no
				select h.order_no,h.item_no,h.component,count(*) as notecount	
				from  x_prodnote h
				where h.status='N'
				group by h.order_no,h.item_no,h.component
			) i on (a.order_no=i.order_no ) 
				and (a.item_number = i.item_no)
				and b.Component=i.Component

			left join (
				----- นับจำนวน note ตาม  component
				select h.component,count(*) as notecount	
				from  x_prodnote h
				where h.status='N'
				and  h.order_no = '*' and h.item_no='*'				
				group by h.component	
			) j on b.Component=j.Component
			left join type_invent h on c.type_invent_code=h.type_invent_code

			where a.Order_No=@order_no

			-- แสดงเฉพาะที่ 885 ที่เลือก  k.nid 14/2/2019
			and ((cc.type_invent_code='03') or (cc.type_invent_code='01' and a.item_number=@item_number))

			-- ให้แสดง code ที่ปิดไปแล้วด้วย k.nid 14/2/2019
			-- and a.Status<>'C'

			order by a.item_number,c.Type_Invent_Code desc ,f.recd_date,b.Component

        ";

        
            
        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);
        
        $command->bindParam(":order_no",$order_no);   
        $command->bindParam(":item_number",$item_number); 
        
        $rows = $command->queryAll();
        $dataProvider=new ArrayDataProvider( [
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => 40,
            ],            
            
        ]);

        return $this->render('view', [            
            'dataProvider' => $dataProvider,
			'order_no'=>$order_no,
			'item_number'=>$item_number
        ]);
    }



}
